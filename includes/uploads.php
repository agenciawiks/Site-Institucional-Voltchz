<?php
/**
 * VoltchZ Brasil - Armazenamento persistente de uploads
 *
 * A Hostinger sobrescreve/limpa o public_html a cada deploy automático via Git,
 * então qualquer arquivo salvo dentro de static/uploads (que fica dentro do
 * public_html versionado) é perdido no próximo push. Para não depender de
 * lembrar de commitar cada upload manualmente, os arquivos são gravados fora do
 * public_html (num diretório irmão, fora do repositório Git) e servidos de volta
 * pelo mesmo caminho público de sempre via fallback no .htaccess + serve-upload.php.
 *
 * Dentro do armazenamento persistente, a estrutura de pastas é uma cópia fiel da
 * estrutura usada dentro de static/ no site (ex: persistent_uploads/static/uploads/marcas/logo.png),
 * pra facilitar localizar/inspecionar arquivos manualmente se precisar.
 */

// Raiz do armazenamento persistente: um nível acima do document root (fora do public_html/repo Git).
function uploads_persistent_root(): string {
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['DOCUMENT_ROOT'])), '/');
    $dir = $base . '/persistent_uploads';
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    return $dir;
}

// Caminho físico dentro do armazenamento persistente para um caminho relativo ao
// site (ex: 'static/uploads/marcas/logo.png'), espelhando a mesma subestrutura.
function uploads_persistent_path(string $relative): string {
    $relative = ltrim(str_replace('\\', '/', $relative), '/');
    return uploads_persistent_root() . '/' . $relative;
}

// Garante que a subpasta static/uploads/<sub_dir> exista dentro do armazenamento
// persistente e retorna o caminho absoluto, pronto para receber o arquivo.
function uploads_persistent_subdir(string $sub_dir): string {
    $dir = uploads_persistent_root() . '/static/uploads/' . trim($sub_dir, '/');
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    return rtrim($dir, '/') . '/';
}

// Apaga um upload de todos os locais onde ele pode existir fisicamente: o cache
// local dentro de static/uploads/ (git/deploy) e o original no armazenamento
// persistente. Usar sempre que uma imagem for removida ou substituída no admin.
function uploads_delete(string $relative): void {
    $relative = trim($relative);
    if ($relative === '' || strpos($relative, 'static/uploads/') !== 0) {
        return;
    }
    $legacy_path = __DIR__ . '/../' . $relative;
    if (file_exists($legacy_path)) {
        @unlink($legacy_path);
    }
    $persistent_path = uploads_persistent_path($relative);
    if (file_exists($persistent_path)) {
        @unlink($persistent_path);
    }
}
