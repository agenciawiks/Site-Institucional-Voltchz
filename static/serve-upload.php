<?php
/**
 * VoltchZ Brasil - Recupera uploads do armazenamento persistente
 * (fora do public_html, portanto imune aos deploys via Git da Hostinger).
 *
 * Só é acionado pelo .htaccess quando o arquivo não existe fisicamente dentro
 * de static/uploads/ (ou seja, sumiu no último deploy ou nunca foi commitado).
 * Ao encontrar o arquivo no armazenamento persistente, copia ele de volta para
 * static/uploads/ antes de servir — assim o próximo request pra essa mesma
 * imagem já é atendido direto pelo Apache (rápido, sem passar pelo PHP), e essa
 * cópia física se refaz sozinha a cada deploy, sem depender de commit manual.
 */
require_once __DIR__ . '/../includes/uploads.php';

// $_GET['f'] chega como o caminho relativo a static/uploads/ (ex: 'marcas/logo.png').
$relative = isset($_GET['f']) ? (string) $_GET['f'] : '';
$relative = ltrim($relative, '/');

if ($relative === '' || strpos($relative, '..') !== false) {
    http_response_code(404);
    exit;
}

$persistent_root = realpath(uploads_persistent_root());
$real_path = realpath(uploads_persistent_path('static/uploads/' . $relative));

if ($persistent_root === false || $real_path === false || strpos($real_path, $persistent_root) !== 0 || !is_file($real_path)) {
    http_response_code(404);
    exit;
}

// Recompõe o arquivo dentro de static/uploads/ para virar cache físico local.
$cache_path = __DIR__ . '/uploads/' . $relative;
$cache_dir = dirname($cache_path);
if (!is_dir($cache_dir)) {
    @mkdir($cache_dir, 0755, true);
}
@copy($real_path, $cache_path);

$mime = function_exists('mime_content_type') ? mime_content_type($real_path) : false;
header('Content-Type: ' . ($mime ?: 'application/octet-stream'));
header('Content-Length: ' . filesize($real_path));
header('Cache-Control: public, max-age=31536000, immutable');
readfile($real_path);
exit;
