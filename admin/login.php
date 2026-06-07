<?php
/**
 * VoltchZ Brasil - Login do Painel Administrativo
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/auth.php';

// Se já estiver logado, vai para o dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error_message = '';
$info_message = '';

// Conexão com o Banco de Dados
try {
    $db = get_db_connection();
    
    // Verifica se existem usuários no banco. Se não houver, auto-cria um administrador padrão
    $stmtCount = $db->query("SELECT COUNT(*) FROM usuarios");
    $userCount = $stmtCount->fetchColumn();
    
    if ($userCount == 0) {
        $default_email = 'admin@voltchz.com.br';
        $default_pass = 'voltchz2026';
        $hashed_pass = password_hash($default_pass, PASSWORD_BCRYPT);
        
        $stmtInsert = $db->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmtInsert->execute(['Administrador VoltchZ', $default_email, $hashed_pass]);
        
        $info_message = "Primeiro acesso detectado! Criamos o usuário <strong>{$default_email}</strong> com a senha temporária <strong>{$default_pass}</strong>. Por favor, anote-a.";
    }
} catch (Exception $e) {
    $error_message = "Erro de conexão com o banco de dados: " . $e->getMessage();
}

// Processa o Formulário de Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error_message)) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'] ?? '';
    
    if (empty($email) || empty($senha)) {
        $error_message = "Por favor, preencha todos os campos.";
    } else {
        try {
            $stmtUser = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmtUser->execute([$email]);
            $user = $stmtUser->fetch();
            
            if ($user && password_verify($senha, $user['senha'])) {
                // Login com sucesso
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_nome'] = $user['nome'];
                $_SESSION['admin_email'] = $user['email'];
                
                header('Location: index.php');
                exit;
            } else {
                $error_message = "E-mail ou senha incorretos.";
            }
        } catch (Exception $e) {
            $error_message = "Erro ao autenticar: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo | VoltchZ Brasil</title>
    <link rel="shortcut icon" href="../static/logo_ico.ico" type="image/x-icon">
    <!-- Tailwind & Google Fonts -->
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace']
                    },
                    colors: {
                        brand: {
                            green: '#22c55e',
                            bg: '#0a0a0f',
                            bg2: '#0d0d14',
                            bg3: '#111118',
                            text: '#f0f0f4',
                            muted: 'rgba(240, 240, 244, 0.60)',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Grain overlay */
        .grain-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.015'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 99;
        }
    </style>
</head>
<body class="h-full font-outfit bg-brand-bg text-brand-text flex items-center justify-center p-6 relative overflow-hidden">
    <div class="grain-overlay"></div>

    <!-- Background Glows -->
    <div class="absolute w-[500px] h-[500px] rounded-full bg-brand-green/5 blur-[120px] -top-40 -left-40 pointer-events-none"></div>
    <div class="absolute w-[500px] h-[500px] rounded-full bg-brand-green/5 blur-[120px] -bottom-40 -right-40 pointer-events-none"></div>

    <!-- Login Container -->
    <div class="w-full max-w-md z-10 transition-all duration-300">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <img src="../static/logo.webp" alt="VoltchZ Brasil" class="h-10 w-auto">
        </div>

        <!-- Login Card -->
        <div class="bg-brand-bg2/85 border border-white/5 rounded-2xl p-8 backdrop-blur-xl shadow-2xl shadow-black/50">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-white tracking-tight">Painel Administrativo</h1>
                <p class="text-brand-muted text-sm mt-1">Identifique-se para gerenciar os dados da plataforma</p>
            </div>

            <!-- Alerts -->
            <?php if (!empty($error_message)): ?>
                <div class="mb-5 bg-red-500/10 border border-red-500/20 text-red-400 text-sm p-4 rounded-xl flex gap-3 items-start">
                    <svg class="h-5 w-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span><?php echo $error_message; ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($info_message)): ?>
                <div class="mb-5 bg-brand-green/10 border border-brand-green/20 text-brand-green text-sm p-4 rounded-xl flex gap-3 items-start">
                    <svg class="h-5 w-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.063.852l-.041.02a.75.75 0 01-1.063-.852zM12 18.75a.75.75 0 110-1.5 .75.75 0 010 1.5z"></path>
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg>
                    <span><?php echo $info_message; ?></span>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="" method="POST" class="space-y-5">
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-brand-muted mb-2">E-mail corporativo</label>
                    <input type="email" id="email" name="email" required placeholder="admin@voltchz.com.br"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-[14.5px] text-white placeholder-brand-muted/40 focus:outline-none focus:border-brand-green/50 transition-colors">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="senha" class="block text-xs font-semibold uppercase tracking-wider text-brand-muted">Senha de acesso</label>
                    </div>
                    <input type="password" id="senha" name="senha" required placeholder="••••••••"
                           class="w-full bg-brand-bg3/50 border border-white/5 rounded-xl px-4 py-3 text-[14.5px] text-white placeholder-brand-muted/40 focus:outline-none focus:border-brand-green/50 transition-colors">
                </div>

                <button type="submit" 
                        class="w-full bg-brand-green text-brand-bg font-bold py-3.5 px-4 rounded-xl hover:brightness-110 active:scale-[0.99] transition-all flex items-center justify-center gap-2 mt-4 text-[14.5px] shadow-lg shadow-brand-green/10">
                    Entrar no painel
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Back to Website Link -->
        <div class="text-center mt-6">
            <a href="../index.php" class="text-xs text-brand-muted hover:text-white transition-colors inline-flex items-center gap-1.5">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Voltar para o site institucional
            </a>
        </div>
    </div>
</body>
</html>
