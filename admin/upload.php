<?php
/**
 * VoltchZ Brasil - Upload Seguro de Arquivos de Imagem
 */
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/uploads.php';

// Garantir que a sessão esteja ativa e o usuário esteja logado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Não autorizado. Faça login primeiro.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        $error_code = $_FILES['file']['error'] ?? UPLOAD_ERR_NO_FILE;
        $msg = 'Ocorreu um erro no upload do arquivo.';
        if ($error_code === UPLOAD_ERR_INI_SIZE || $error_code === UPLOAD_ERR_FORM_SIZE) {
            $msg = 'O arquivo excede o limite de tamanho permitido pelo servidor.';
        } elseif ($error_code === UPLOAD_ERR_NO_FILE) {
            $msg = 'Nenhum arquivo foi enviado.';
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $msg]);
        exit;
    }

    $file = $_FILES['file'];
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
    $file_info = pathinfo($file['name']);
    $extension = strtolower($file_info['extension'] ?? '');

    if (!in_array($extension, $allowed_extensions)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Tipo de arquivo não permitido. Apenas JPG, JPEG, PNG, GIF, WEBP e SVG são aceitos.']);
        exit;
    }

    // Limite de 5MB
    if ($file['size'] > 5 * 1024 * 1024) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'O arquivo excede o limite máximo de 5MB.']);
        exit;
    }

    $type = $_REQUEST['type'] ?? '';
    $allowed_types = ['portfolio', 'produto', 'blog', 'banner', 'depoimento', 'marca'];
    $sub_dir = '';
    if (in_array($type, $allowed_types)) {
        $sub_dir = $type . 's/';
    }

    $upload_dir = uploads_persistent_subdir($sub_dir);

    // Nome único para evitar conflito de arquivos com o mesmo nome
    $safe_name = preg_replace('/[^a-z0-9]/', '', strtolower(trim($file_info['filename'])));
    $new_filename = 'img_' . $safe_name . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
    $dest_path = $upload_dir . $new_filename;

    if (move_uploaded_file($file['tmp_name'], $dest_path)) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'path' => 'static/uploads/' . $sub_dir . $new_filename
        ]);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar o arquivo. Verifique as permissões da pasta de uploads persistente.']);
        exit;
    }
}

header('Content-Type: application/json');
echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
exit;
