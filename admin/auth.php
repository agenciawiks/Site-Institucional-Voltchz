<?php
/**
 * VoltchZ Brasil - Controle de Sessão e Acesso Administrativo
 */
if (session_status() === PHP_SESSION_NONE) {
    // Configurações de segurança para cookies de sessão
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    
    // Habilita secure cookie se estiver em ambiente HTTPS
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', 1);
    }
    
    session_start();
}

/**
 * Verifica se o usuário está autenticado. Caso contrário, redireciona para a tela de login.
 */
function check_admin_auth() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php');
        exit;
    }
}
