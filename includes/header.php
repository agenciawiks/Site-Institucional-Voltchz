<!doctype html>
<html lang="pt-BR" class="h-full scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Primary Meta Tags -->
    <title><?php echo isset($page_title) ? $page_title : "VoltchZ Brasil | Engenharia para Mobilidade Elétrica"; ?></title>
    <meta name="title" content="<?php echo isset($page_title) ? $page_title : "VoltchZ Brasil | Engenharia para Mobilidade Elétrica"; ?>">
    <meta name="description" content="<?php echo isset($page_desc) ? $page_desc : "Infraestrutura de engenharia certificada (ITA/INATEL) para carregamento de veículos elétricos. Projetos, laudos e instalação com segurança absoluta em SJC e Vale do Paraíba."; ?>">
    <meta name="theme-color" content="#050508">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://voltchz.com.br/">
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title : "VoltchZ Brasil | Engenharia para Mobilidade Elétrica"; ?>">
    <meta property="og:description" content="<?php echo isset($page_desc) ? $page_desc : "Infraestrutura certificada para mobilidade elétrica. Segurança e inovação em cada recarga."; ?>">
    <meta property="og:image" content="static/banner-social.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://voltchz.com.br/">
    <meta property="twitter:title" content="<?php echo isset($page_title) ? $page_title : "VoltchZ Brasil | Engenharia para Mobilidade Elétrica"; ?>">
    <meta property="twitter:description" content="<?php echo isset($page_desc) ? $page_desc : "Infraestrutura certificada para mobilidade elétrica. Segurança e inovação em cada recarga."; ?>">
    <meta property="twitter:image" content="static/banner-social.png">

    <!-- Favicon -->
    <link rel="shortcut icon" href="static/logo_ico.ico" type="image/x-icon">
    <link rel="icon" href="static/logo_ico.ico" type="image/x-icon">

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.tailwindcss.com">

    <!-- Preload LCP Image -->
    <link rel="preload" as="image" href="static/banner-rotativo-01webp.webp" fetchpriority="high">

    <!-- CSS & Tailwind -->
    <link rel="stylesheet" href="styles.css">
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
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <?php if (isset($additional_head)) echo $additional_head; ?>
</head>

<body class="h-full font-outfit bg-brand-bg text-brand-text selection:bg-brand-green/30 overflow-x-hidden">

    <!-- GRAIN OVERLAY -->
    <div class="grain-overlay"></div>

    <!-- PROGRESS BAR -->
    <div id="progress-bar" class="fixed top-0 left-0 h-[2px] bg-brand-green z-[100] transition-all duration-150" style="width: 0%"></div>

    <!-- ──────────────────────────────────────────
       NAVIGATION & MENU
  ────────────────────────────────────────── -->
    <nav id="main-nav" class="fixed top-0 left-0 w-full z-50 bg-brand-bg/90 backdrop-blur-[18px] border-b border-white/5 transition-all duration-300">
        <div class="max-w-[1200px] mx-auto px-6 h-[60px] flex items-center justify-between gap-8">
            <a href="index.php" class="flex-shrink-0" aria-label="VoltchZ Brasil Home">
                <img src="static/logo.webp" alt="VoltchZ Brasil" class="h-8 w-auto" loading="lazy" width="160" height="32">
            </a>

            <?php $active_page = isset($current_page) ? $current_page : ''; ?>

            <div id="nav-links" class="hidden md:flex items-center gap-1.5">
                <a href="index.php" class="text-[13.5px] font-medium px-3 py-1.5 rounded-lg transition-all duration-200 <?php echo $active_page === 'index' ? 'text-brand-text bg-white/5' : 'text-brand-muted hover:text-brand-text hover:bg-white/5'; ?>">Início</a>
                <a href="sobre.php" class="text-[13.5px] font-medium px-3 py-1.5 rounded-lg transition-all duration-200 <?php echo $active_page === 'sobre' ? 'text-brand-text bg-white/5' : 'text-brand-muted hover:text-brand-text hover:bg-white/5'; ?>">Sobre Nós</a>
                <a href="produtos.php" class="text-[13.5px] font-medium px-3 py-1.5 rounded-lg transition-all duration-200 <?php echo $active_page === 'produtos' ? 'text-brand-text bg-white/5' : 'text-brand-muted hover:text-brand-text hover:bg-white/5'; ?>">Produtos</a>
                <a href="app.php" class="text-[13.5px] font-medium px-3 py-1.5 rounded-lg transition-all duration-200 <?php echo $active_page === 'app' ? 'text-brand-text bg-white/5' : 'text-brand-muted hover:text-brand-text hover:bg-white/5'; ?>">App VoltchZ</a>
                <a href="blog.php" class="text-[13.5px] font-medium px-3 py-1.5 rounded-lg transition-all duration-200 <?php echo $active_page === 'blog' ? 'text-brand-text bg-white/5' : 'text-brand-muted hover:text-brand-text hover:bg-white/5'; ?>">Blog</a>
                <a href="ferramentas.php" class="text-[13.5px] font-medium px-3 py-1.5 rounded-lg transition-all duration-200 <?php echo $active_page === 'ferramentas' ? 'text-brand-text bg-white/5' : 'text-brand-muted hover:text-brand-text hover:bg-white/5'; ?>">Encontre um Eletroposto</a>
                <a href="contato.php" class="text-[13.5px] font-medium px-3 py-1.5 rounded-lg transition-all duration-200 <?php echo $active_page === 'contato' ? 'text-brand-text bg-white/5' : 'text-brand-muted hover:text-brand-text hover:bg-white/5'; ?>">Contato</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer" class="hidden sm:flex items-center gap-2 bg-brand-green text-brand-bg text-[13.5px] font-bold px-[18px] py-2 rounded-[9px] hover:brightness-110 active:scale-95 transition-all whitespace-nowrap shadow-lg shadow-brand-green/10">
                    Conversar com atendente
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
                <button id="mobile-menu-btn" class="md:hidden p-2 text-brand-text hover:bg-white/5 rounded-lg" aria-label="Abrir Menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden fixed inset-0 top-[60px] z-40 bg-brand-bg/95 backdrop-blur-xl px-6 py-8 border-t border-white/5 overflow-y-auto">
            <div class="flex flex-col gap-4">
                <a href="index.php" class="text-2xl font-bold py-2 <?php echo $active_page === 'index' ? 'text-brand-green' : 'text-brand-muted hover:text-brand-green'; ?>">Início</a>
                <a href="sobre.php" class="text-2xl font-bold py-2 <?php echo $active_page === 'sobre' ? 'text-brand-green' : 'text-brand-muted hover:text-brand-green'; ?>">Sobre Nós</a>
                <a href="produtos.php" class="text-2xl font-bold py-2 <?php echo $active_page === 'produtos' ? 'text-brand-green' : 'text-brand-muted hover:text-brand-green'; ?>">Produtos</a>
                <a href="app.php" class="text-2xl font-bold py-2 <?php echo $active_page === 'app' ? 'text-brand-green' : 'text-brand-muted hover:text-brand-green'; ?>">App VoltchZ</a>
                <a href="blog.php" class="text-2xl font-bold py-2 <?php echo $active_page === 'blog' ? 'text-brand-green' : 'text-brand-muted hover:text-brand-green'; ?>">Blog</a>
                <a href="ferramentas.php" class="text-2xl font-bold py-2 <?php echo $active_page === 'ferramentas' ? 'text-brand-green' : 'text-brand-muted hover:text-brand-green'; ?>">Encontre um Eletroposto</a>
                <a href="contato.php" class="text-2xl font-bold py-2 <?php echo $active_page === 'contato' ? 'text-brand-green' : 'text-brand-muted hover:text-brand-green'; ?>">Contato</a>

                <div class="pt-8 border-t border-white/10 mt-4">
                    <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-3 bg-brand-green text-brand-bg font-bold py-4 rounded-2xl shadow-xl shadow-brand-green/20">
                        Falar com Especialista
                    </a>
                </div>
            </div>
        </div>
    </nav>
