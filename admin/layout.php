<?php
/**
 * VoltchZ Brasil - Layout e Template do Painel Administrativo
 */
require_once __DIR__ . '/auth.php';

function admin_header($title = "Painel Administrativo", $active_menu = "dashboard") {
    check_admin_auth();
    $admin_nome = $_SESSION['admin_nome'] ?? 'Administrador';
    $admin_email = $_SESSION['admin_email'] ?? 'admin@voltchz.com.br';
    
    // Lista de menus com rotas e ícones SVG
    $menus = [
        'dashboard' => [
            'label' => 'Dashboard',
            'url' => 'index.php',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"></path></svg>'
        ],
        'produtos' => [
            'label' => 'Produtos',
            'url' => 'produtos.php',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"></path></svg>'
        ],
        'categorias' => [
            'label' => 'Categorias & Marcas',
            'url' => 'categorias.php',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a1.125 1.125 0 001.59 0l4.318-4.318a1.125 1.125 0 000-1.59L9.568 3.659a2.25 2.25 0 00-1.591-.659z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"></path></svg>'
        ],
        'portfolio' => [
            'label' => 'Portfólio',
            'url' => 'portfolio.php',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"></path></svg>'
        ],
        'banners' => [
            'label' => 'Banners da Home',
            'url' => 'banners.php',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>'
        ],
        'depoimentos' => [
            'label' => 'Depoimentos',
            'url' => 'depoimentos.php',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"></path></svg>'
        ],
        'faq' => [
            'label' => 'Perguntas (FAQ)',
            'url' => 'faq.php',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"></path></svg>'
        ],
        'blog' => [
            'label' => 'Blog / Artigos',
            'url' => 'blog.php',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 17.75V6.125C3 5.504 3.504 5 4.125 5H18a1.125 1.125 0 011.125 1.125V7.5"></path></svg>'
        ],
        'leads' => [
            'label' => 'Leads / Contatos',
            'url' => 'leads.php',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>'
        ],
        'configuracoes' => [
            'label' => 'Configurações',
            'url' => 'configuracoes.php',
            'svg' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.43l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.991l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.645-.869l.214-1.28z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>'
        ]
    ];
    ?>
<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-brand-bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> | Admin VoltchZ</title>
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
        .grain-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.012'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 99;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0a0a0f;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(34, 197, 94, 0.4);
        }
    </style>
</head>
<body class="h-full font-outfit bg-brand-bg text-brand-text flex overflow-hidden">
    <div class="grain-overlay"></div>

    <!-- Sidebar móvel overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-30 hidden transition-opacity duration-300 md:hidden"></div>

    <!-- SIDEBAR -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 w-64 bg-brand-bg2 border-r border-white/5 flex flex-col z-40 transform -translate-x-full md:translate-x-0 md:static transition-transform duration-300">
        <!-- Logo Area -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-white/5 shrink-0 bg-brand-bg/50">
            <a href="../index.php" target="_blank" class="flex items-center gap-2">
                <img src="../static/logo.webp" alt="VoltchZ Brasil" class="h-7 w-auto">
            </a>
            <button id="close-sidebar" class="text-brand-muted hover:text-white md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <?php foreach ($menus as $key => $menu): 
                $is_active = ($active_menu === $key);
            ?>
                <a href="<?php echo $menu['url']; ?>" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14.5px] font-medium transition-all duration-150 <?php echo $is_active ? 'bg-brand-green/10 text-brand-green font-semibold' : 'text-brand-muted hover:text-white hover:bg-white/5'; ?>">
                    <?php echo $menu['svg']; ?>
                    <?php echo $menu['label']; ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <!-- Profile / Logout Area -->
        <div class="p-4 border-t border-white/5 bg-brand-bg/40">
            <div class="flex items-center gap-3 px-2 py-2 mb-3">
                <div class="w-9 h-9 rounded-xl bg-brand-green/20 text-brand-green flex items-center justify-center font-bold text-sm shrink-0 border border-brand-green/30">
                    <?php echo strtoupper(substr($admin_nome, 0, 1)); ?>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate"><?php echo $admin_nome; ?></p>
                    <p class="text-xs text-brand-muted truncate"><?php echo $admin_email; ?></p>
                </div>
            </div>
            <a href="logout.php" 
               class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl border border-white/5 hover:border-red-500/20 hover:bg-red-500/10 hover:text-red-400 text-brand-muted text-[13.5px] font-medium transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"></path></svg>
                Sair do painel
            </a>
        </div>
    </aside>

    <!-- CONTENT WRAPPER -->
    <div class="flex-1 flex flex-col min-w-0 relative">
        <!-- HEADER -->
        <header class="h-16 border-b border-white/5 flex items-center justify-between px-6 bg-brand-bg2/40 backdrop-blur-xl shrink-0 z-20">
            <div class="flex items-center gap-4">
                <button id="open-sidebar" class="text-brand-muted hover:text-white p-1 rounded-lg hover:bg-white/5 md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h2 class="text-lg font-bold text-white tracking-tight"><?php echo $title; ?></h2>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="../index.php" target="_blank" 
                   class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-white/5 hover:border-brand-green/20 hover:bg-brand-green/5 text-xs text-brand-muted hover:text-brand-green transition-all">
                    Visualizar Site
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path></svg>
                </a>
            </div>
        </header>

        <!-- MAIN MAIN -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-brand-bg">
            <div class="max-w-6xl mx-auto space-y-8">
<?php
}

function admin_footer() {
?>
            </div>
        </main>
    </div>

    <script>
        // Sidebar toggle controls
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const openBtn = document.getElementById('open-sidebar');
        const closeBtn = document.getElementById('close-sidebar');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        if (openBtn) openBtn.addEventListener('click', toggleSidebar);
        if (closeBtn) closeBtn.addEventListener('click', toggleSidebar);
        if (overlay) overlay.addEventListener('click', toggleSidebar);
    </script>
</body>
</html>
<?php
}
