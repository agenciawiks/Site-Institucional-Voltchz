<?php
/**
 * VoltchZ Brasil - Endpoint AJAX para Salvar Leads no Banco
 */
require_once __DIR__ . '/includes/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?: '';
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
    $empresa = filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_SPECIAL_CHARS) ?: '';
    $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_SPECIAL_CHARS) ?: '';
    $tipo_projeto = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
    $prazo_desejado = filter_input(INPUT_POST, 'prazo', FILTER_SANITIZE_SPECIAL_CHARS) ?: 'Não informado';
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_SPECIAL_CHARS) ?: '';

    if ($nome && $telefone && $tipo_projeto) {
        try {
            $db = get_db_connection();
            $stmt = $db->prepare("INSERT INTO leads (nome, email, telefone, empresa, cidade, tipo_projeto, prazo_desejado, mensagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nome, $email, $telefone, $empresa, $cidade, $tipo_projeto, $prazo_desejado, $mensagem]);
            
            echo json_encode(['success' => true]);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }
}

http_response_code(400);
echo json_encode(['success' => false, 'error' => 'Dados incompletos ou requisição inválida.']);
