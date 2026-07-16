<?php
$page_title = "VoltchZ Brasil | Engenharia para Mobilidade Elétrica";
$page_desc = "Infraestrutura de engenharia certificada (ITA/INATEL) para carregamento de veículos elétricos. Projetos, laudos e instalação com segurança absoluta em SJC e Vale do Paraíba.";
$current_page = "index";
include "includes/header.php";
?>
    <!-- HERO SECTION -->
    <!-- ──────────────────────────────────────────
       HERO SECTION (BANNER PRINCIPAL)
  ────────────────────────────────────────── -->
    <header id="hero-section" class="relative min-h-[92vh] overflow-hidden pt-[60px]">
        <div class="carousel-wrapper relative w-full h-full min-h-[92vh]">
            <?php 
            $banners = get_banners(true);
            foreach ($banners as $index => $b):
                $is_active = ($index === 0);
                $is_webp = (strtolower(pathinfo($b['image'], PATHINFO_EXTENSION)) === 'webp');
                $button_link = $b['button_link'];
                if ($button_link === 'contato') {
                    $button_link = 'contato';
                }
            ?>
            <!-- Slide <?php echo $index + 1; ?> -->
            <div class="carousel-slide <?php echo $is_active ? 'active' : ''; ?>" id="slide-<?php echo $index; ?>">
                <?php if ($is_webp): ?>
                    <picture class="carousel-slide-bg">
                        <source srcset="<?php echo htmlspecialchars($b['image']); ?>" type="image/webp">
                        <img src="<?php echo htmlspecialchars($b['image']); ?>" alt="<?php echo htmlspecialchars($b['title']); ?>" class="w-full h-full object-cover">
                    </picture>
                <?php else: ?>
                    <div class="carousel-slide-bg" style="background-image:url('<?php echo htmlspecialchars($b['image']); ?>')"></div>
                <?php endif; ?>
                <div class="absolute inset-0 bg-brand-bg/40"></div>
                <div class="orb w-[420px] h-[420px] -top-20 -right-20 bg-brand-green/20"></div>
                <div class="orb w-[300px] h-[300px] -bottom-20 -left-20 bg-brand-green/10"></div>

                <div class="hero-content">
                    <?php if ($index === 0): ?>
                        <div class="mb-8 flex justify-center observe">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono">
                                <span class="w-1.5 h-1.5 bg-brand-green rounded-full animate-pulse"></span> Engenharia Certificada
                            </span>
                        </div>
                    <?php else: ?>
                        <div class="mb-8 flex justify-center">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono">
                                Diferenciais VoltchZ
                            </span>
                        </div>
                    <?php endif; ?>
                    <h1 class="text-[clamp(34px,6vw,68px)] font-extrabold leading-[1.05] tracking-tight text-brand-text mb-8 <?php echo $index === 0 ? 'observe' : ''; ?>">
                        <?php echo $b['title']; ?>
                    </h1>
                    <p class="text-[clamp(16px,2vw,19px)] text-white/90 max-w-[620px] mb-10 leading-relaxed <?php echo $index === 0 ? 'observe' : ''; ?>">
                        <?php echo htmlspecialchars($b['subtitle']); ?>
                    </p>
                    <div class="flex items-center justify-center gap-4 flex-wrap mb-16 <?php echo $index === 0 ? 'observe' : ''; ?>">
                        <?php if (!empty($b['button_text'])): ?>
                            <a href="<?php echo htmlspecialchars($button_link); ?>" <?php echo (strpos($button_link, 'http') === 0) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?> class="bg-brand-green text-brand-bg font-bold py-4 px-10 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
                                <?php echo htmlspecialchars($b['button_text']); ?>
                            </a>
                        <?php endif; ?>
                        <?php if ($index === 0): ?>
                            <a href="sobre" class="border border-white/20 bg-white/5 backdrop-blur-sm text-brand-text py-4 px-10 rounded-2xl hover:bg-white/10 transition-all font-bold">
                                Saiba Mais
                            </a>
                        <?php endif; ?>
                    </div>

                        <!-- Stats -->
                        <div class="stats-container w-full max-w-[620px] mx-auto observe">
                            <div class="stats-grid w-full flex sm:grid sm:grid-cols-3 overflow-x-hidden sm:overflow-x-visible snap-x snap-mandatory scrollbar-hide bg-white/5 border border-white/10 rounded-3xl backdrop-blur-md">
                                <div class="w-full flex-shrink-0 snap-center p-6 text-center border-r border-white/5 sm:w-auto sm:flex-shrink">
                                    <div class="stat-num text-3xl font-extrabold text-brand-green tracking-tighter font-mono" data-target="300" data-prefix="+">+0</div>
                                    <div class="text-[10px] text-white/50 uppercase tracking-[0.1em] mt-1 font-bold text-balance">Clientes Atendidos</div>
                                </div>
                                <div class="w-full flex-shrink-0 snap-center p-6 text-center border-r border-white/5 sm:w-auto sm:flex-shrink">
                                    <div class="stat-num text-3xl font-extrabold text-brand-green tracking-tighter font-mono" data-target="500" data-prefix="+">+0</div>
                                    <div class="text-[10px] text-white/50 uppercase tracking-[0.1em] mt-1 font-bold text-balance">Instalações</div>
                                </div>
                                <div class="w-full flex-shrink-0 snap-center p-6 text-center sm:w-auto sm:flex-shrink">
                                    <div class="stat-num text-3xl font-extrabold text-brand-green tracking-tighter font-mono" data-target="22" data-prefix="">0</div>
                                    <div class="text-[10px] text-white/50 uppercase tracking-[0.1em] mt-1 font-bold text-balance">Anos de Experiência</div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Controls -->
            <button id="carousel-prev" class="absolute left-5 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full border border-brand-green/20 bg-brand-green/5 text-brand-green flex items-center justify-center hover:bg-brand-green/20 transition-all focus:outline-none focus:ring-2 focus:ring-brand-green" aria-label="Slide anterior">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
            </button>
            <button id="carousel-next" class="absolute right-5 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full border border-brand-green/20 bg-brand-green/5 text-brand-green flex items-center justify-center hover:bg-brand-green/20 transition-all focus:outline-none focus:ring-2 focus:ring-brand-green" aria-label="Próximo slide">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
            </button>

            <!-- Dots -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3 z-20" role="tablist" aria-label="Navegação do carrossel">
                <?php foreach ($banners as $index => $b): ?>
                    <button id="dot-<?php echo $index; ?>" class="carousel-dot <?php echo $index === 0 ? 'active' : ''; ?> w-3 h-3 rounded-full bg-white/40 border border-white/20 transition-all hover:bg-white/60 focus:outline-none focus:ring-2 focus:ring-brand-green" aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>" role="tab" aria-label="Ir para slide <?php echo $index + 1; ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
    </header>

    <!-- ──────────────────────────────────────────
       TRUST BAR (SELOS DE QUALIDADE)
   ────────────────────────────────────────── -->
    <div class="bg-brand-bg2/90 border-b border-white/5 flex overflow-x-auto md:flex-wrap md:justify-center md:overflow-x-visible snap-x snap-mandatory scrollbar-hide backdrop-blur-sm select-none py-2 md:py-0">
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg> NBR 5410 certificado
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
      </svg> NBR 17019
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
      </svg> IEC 61851-1
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
      </svg> NBR 15749, 7117, IEC 61643-1
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg> NR 10 certificado
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 14l9-5-9-5-9 5 9 5z" />
        <path d="M12 14l6.16-3.422A12.083 12.083 0 0122 19.5H2a12.083 12.083 0 013.84-8.922L12 14z" />
      </svg> Engenheiro Eletricista Responsável
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="4" width="18" height="16" rx="2" />
        <line x1="7" y1="8" x2="17" y2="8" />
        <line x1="7" y1="12" x2="13" y2="12" />
      </svg> CREA MG / SP
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
      </svg> PMP® certificado – PMI
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path
          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
      </svg> Projeto + ART incluso
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10" />
        <polyline points="12 6 12 12 16 14" />
      </svg> Resposta em 24h
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg> Vale do Paraíba
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg> Litoral Norte de São Paulo
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg> Sul de Minas Gerais
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 text-[12px] font-semibold text-brand-muted whitespace-nowrap snap-center shrink-0">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg> Estado de São Paulo
        </div>
    </div>

    <div class="voltage-line"></div>

    <!-- ──────────────────────────────────────────
       SERVICES SECTION (ESPECIALIDADES)
  ────────────────────────────────────────── -->
    <section id="servicos" class="bg-white py-24 px-6">
        <div class="max-w-[1200px] mx-auto">
            <div class="text-center mb-16 observe">
                <p class="text-[12px] font-mono font-bold uppercase tracking-[0.2em] text-brand-green mb-4">Especialidades</p>
                <h2 class="text-4xl font-extrabold text-[#1a1a24] tracking-tight mb-5">Cuidamos dos detalhes</h2>
                <p class="text-slate-600 max-w-xl mx-auto text-lg leading-relaxed font-medium">Do carregador à geração própria, somos o parceiro técnico ideal para sua transição.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 observe">
                <!-- Venda -->
                <div class="p-8 bg-[#f8fafc] border border-slate-200 rounded-[32px] hover:border-brand-green/40 hover:bg-white hover:shadow-2xl hover:shadow-brand-green/5 transition-all duration-500 group">
                    <div class="w-14 h-14 bg-brand-green/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="7" width="20" height="14" rx="2" />
              <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16" />
            </svg>
                    </div>
                    <span class="text-[11px] font-bold text-brand-green uppercase tracking-widest">Produtos</span>
                    <h3 class="text-xl font-bold text-[#1a1a24] mt-2 mb-3">Venda de Carregadores e Acessórios</h3>
                    <p class="text-slate-600 leading-relaxed text-[14.5px]">Curadoria de excelência com as marcas líderes do mercado.</p>
                    <a href="<?php echo htmlspecialchars(get_config('whatsapp_link', 'https://wa.me/5512981039845')); ?>" class="inline-flex items-center gap-2 mt-7 text-[13px] font-bold text-brand-green border border-brand-green/20 px-5 py-2 rounded-xl hover:bg-brand-green/5 transition-colors">
            Falar com Especialista
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
              <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
          </a>
                </div>

                <!-- Instalação -->
                <div class="p-8 bg-[#f8fafc] border border-slate-200 rounded-[32px] hover:border-brand-green/40 hover:bg-white hover:shadow-2xl hover:shadow-brand-green/5 transition-all duration-500 group">
                    <div class="w-14 h-14 bg-brand-green/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path
                d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z" />
            </svg>
                    </div>
                    <span class="text-[11px] font-bold text-brand-green uppercase tracking-widest">Execução</span>
                    <h3 class="text-xl font-bold text-[#1a1a24] mt-2 mb-3">Instalação e Manutenção</h3>
                    <p class="text-slate-600 leading-relaxed text-[14.5px]"><span class="font-bold">Metodologias
              especializadas</span> para <span class="font-bold">casas e condomínios</span>.</p>
                    <a href="<?php echo htmlspecialchars(get_config('whatsapp_link', 'https://wa.me/5512981039845')); ?>" class="inline-flex items-center gap-2 mt-7 text-[13px] font-bold text-brand-green border border-brand-green/20 px-5 py-2 rounded-xl hover:bg-brand-green/5 transition-colors">Solicitar
            Orçamento</a>
                </div>

                <!-- Laudos -->
                <div class="p-8 bg-[#f8fafc] border border-slate-200 rounded-[32px] hover:border-brand-green/40 hover:bg-white hover:shadow-2xl hover:shadow-brand-green/5 transition-all duration-500 group">
                    <div class="w-14 h-14 bg-brand-green/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
                    </div>
                    <span class="text-[11px] font-bold text-brand-green uppercase tracking-widest">Documentação</span>
                    <h3 class="text-xl font-bold text-[#1a1a24] mt-2 mb-3">Laudos e Relatórios</h3>
                    <p class="text-slate-600 leading-relaxed text-[14.5px]"><span class="font-bold">Conformidade técnica</span> detalhada para <span class="font-bold text-brand-green">uso seguro</span>.</p>
                    <a href="viabilidade" class="inline-flex items-center gap-2 mt-7 text-[13px] font-bold text-brand-green border border-brand-green/20 px-5 py-2 rounded-xl hover:bg-brand-green/5 transition-colors">Ver
            Mais</a>
                </div>

                <!-- Projetos -->
                <div class="p-8 bg-[#f8fafc] border border-slate-200 rounded-[32px] hover:border-brand-green/40 hover:bg-white hover:shadow-2xl hover:shadow-brand-green/5 transition-all duration-500 group">
                    <div class="w-14 h-14 bg-brand-green/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="3" />
              <path
                d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M4.93 19.07l1.41-1.41M19.07 19.07l-1.41-1.41M12 2v2M12 20v2M2 12h2M20 12h2" />
            </svg>
                    </div>
                    <span class="text-[11px] font-bold text-brand-green uppercase tracking-widest">Estratégia</span>
                    <h3 class="text-xl font-bold text-[#1a1a24] mt-2 mb-3">Projetos e Consultoria</h3>
                    <p class="text-slate-600 leading-relaxed text-[14.5px]"><span class="font-bold">Planejamento elétrico</span> focado em <span class="font-bold">escalabilidade</span>.</p>
                    <a href="<?php echo htmlspecialchars(get_config('whatsapp_link', 'https://wa.me/5512981039845')); ?>" class="inline-flex items-center gap-2 mt-7 text-[13px] font-bold text-brand-green border border-brand-green/20 px-5 py-2 rounded-xl hover:bg-brand-green/5 transition-colors">Consultoria</a>
                </div>

                <!-- Análise -->
                <div class="p-8 bg-[#f8fafc] border border-slate-200 rounded-[32px] hover:border-brand-green/40 hover:bg-white hover:shadow-2xl hover:shadow-brand-green/5 transition-all duration-500 group">
                    <div class="w-14 h-14 bg-brand-green/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
            </svg>
                    </div>
                    <span class="text-[11px] font-bold text-brand-green uppercase tracking-widest">Tecnologia</span>
                    <h3 class="text-xl font-bold text-[#1a1a24] mt-2 mb-3">Gestão de Cargas</h3>
                    <p class="text-slate-600 leading-relaxed text-[14.5px]"><span class="font-bold">Controle ativo</span> do <span class="font-bold">balanceamento</span> entre carregadores.</p>
                    <a href="<?php echo htmlspecialchars(get_config('whatsapp_link', 'https://wa.me/5512981039845')); ?>" class="inline-flex items-center gap-2 mt-7 text-[13px] font-bold text-brand-green border border-brand-green/20 px-5 py-2 rounded-xl hover:bg-brand-green/5 transition-colors">Saber
            Mais</a>
                </div>

                <!-- Solar -->
                <div class="p-8 bg-brand-green/5 border border-brand-green/20 rounded-[32px] hover:border-brand-green/50 hover:bg-white hover:shadow-2xl hover:shadow-brand-green/10 transition-all duration-500 group">
                    <div class="w-14 h-14 bg-brand-green/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="5" />
              <line x1="12" y1="1" x2="12" y2="3" />
              <line x1="12" y1="21" x2="12" y2="23" />
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
              <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
              <line x1="1" y1="12" x2="3" y2="12" />
              <line x1="21" y1="12" x2="23" y2="12" />
              <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
              <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
            </svg>
                    </div>
                    <span class="inline-block bg-brand-green/20 text-[10px] font-bold px-2.5 py-0.5 rounded-full text-brand-green mb-1 uppercase tracking-widest">Sustentável</span>
                    <h3 class="text-xl font-bold text-[#1a1a24] mt-2 mb-3">Energia Solar</h3>
                    <p class="text-slate-600 leading-relaxed text-[14.5px]"><span class="font-bold">Implementação</span> focado em
                        <span class="font-bold">mitigar o consumo</span> veicular.
                    </p>
                    <a href="<?php echo htmlspecialchars(get_config('whatsapp_link', 'https://wa.me/5512981039845')); ?>" class="inline-flex items-center gap-2 mt-7 text-[13px] font-bold text-brand-green border border-brand-green/20 px-5 py-2 rounded-xl hover:bg-brand-green/5 transition-colors">Orçamento</a>
                </div>
            </div>
        </div>
    </section>

    <div class="voltage-line"></div>

    <!-- ──────────────────────────────────────────
       DIFERENCIAIS (POR QUE A VOLTCHZ?)
  ────────────────────────────────────────── -->
    <section id="o-que-faz" class="bg-brand-bg py-28 px-6 relative overflow-hidden text-white">
        <div class="max-w-[1200px] mx-auto relative z-10">
            <div class="text-center mb-20 observe">
                <p class="text-[12px] font-mono font-bold uppercase tracking-[0.2em] text-brand-green mb-4">DIFERENCIAIS</p>
                <h2 class="text-4xl font-extrabold tracking-tight mb-5">Por que a VoltchZ?</h2>
                <p class="text-brand-muted max-w-xl mx-auto text-lg leading-relaxed">Nossos pilares de excelência técnica e rigor em engenharia.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 observe">
                <div class="p-8 bg-white/5 border border-white/10 rounded-[32px] hover:bg-white/10 transition-all group">
                    <div class="mb-5 text-brand-green group-hover:scale-110 transition-transform">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
              <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
                    </div>
                    <h4 class="text-lg font-bold mb-2">Máxima Segurança</h4>
                    <p class="text-brand-muted text-[14px]"><span class="font-bold text-white">Proteção integral</span> do seu imóvel e rede elétrica instalada.</p>
                </div>
                <div class="p-8 bg-white/5 border border-white/10 rounded-[32px] hover:bg-white/10 transition-all group">
                    <div class="mb-5 text-brand-green group-hover:scale-110 transition-transform">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="3" width="18" height="18" rx="2" />
              <path d="M9 3v18M3 9h6M3 15h6" />
            </svg>
                    </div>
                    <h4 class="text-lg font-bold mb-2">Escalabilidade</h4>
                    <p class="text-brand-muted text-[14px]"><span class="font-bold text-white">Sistemas prontos</span> para expansão futura de <span class="font-bold">frotas EVs</span>.</p>
                </div>
                <div class="p-8 bg-white/5 border border-white/10 rounded-[32px] hover:bg-white/10 transition-all group">
                    <div class="mb-5 text-brand-green group-hover:scale-110 transition-transform">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
            </svg>
                    </div>
                    <h4 class="text-lg font-bold mb-2">Suporte Remoto</h4>
                    <p class="text-brand-muted text-[14px]"><span class="font-bold text-white">Monitoramento</span> e <span class="font-bold">diagnóstico digital</span> de infraestrutura.</p>
                </div>
                <div class="p-8 bg-white/5 border border-white/10 rounded-[32px] hover:bg-white/10 transition-all group">
                    <div class="mb-5 text-brand-green group-hover:scale-110 transition-transform">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
            </svg>
                    </div>
                    <h4 class="text-lg font-bold mb-2">NBR 5410</h4>
                    <p class="text-brand-muted text-[14px]"><span class="font-bold text-white">Instalações seguras</span> em baixa tensão com rigoroso controle normativo.</p>
                </div>
                <div class="p-8 bg-white/5 border border-white/10 rounded-[32px] hover:bg-white/10 transition-all group">
                    <div class="mb-5 text-brand-green group-hover:scale-110 transition-transform">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
            </svg>
                    </div>
                    <h4 class="text-lg font-bold mb-2">NBR 17019</h4>
                    <p class="text-brand-muted text-[14px]"><span class="font-bold text-white">Infraestrutura dedicada</span> para a alimentação de veículos elétricos (VE).</p>
                </div>
                <div class="p-8 bg-white/5 border border-white/10 rounded-[32px] hover:bg-white/10 transition-all group">
                    <div class="mb-5 text-brand-green group-hover:scale-110 transition-transform">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            </svg>
                    </div>
                    <h4 class="text-lg font-bold mb-2">NBR IEC 61851-1</h4>
                    <p class="text-brand-muted text-[14px]"><span class="font-bold text-white">Segurança de recarga</span> condutiva e interoperabilidade global.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────────
       CONSTRUTORAS (PARCERIA ESTRATÉGICA)
  ────────────────────────────────────────── -->
    <section id="construtoras" class="bg-[#f8fafc] py-16 sm:py-24 lg:py-32 px-6 overflow-hidden">
        <div class="max-w-[1200px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Text Content -->
                <div class="observe order-2 lg:order-1">
                    <span class="text-brand-green font-mono font-bold text-[12px] sm:text-[13px] uppercase tracking-[0.3em] mb-4 sm:mb-6 block">Parceria
            Estratégica</span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#1a1a24] mb-6 sm:mb-8 leading-[1.1] tracking-tight">
                        Energia preparada para o <span class="text-brand-green">futuro do seu empreendimento</span>
                    </h2>
                    <div class="space-y-4 sm:space-y-6 text-slate-600 text-base sm:text-lg leading-relaxed mb-8 sm:mb-10">
                        <p>
                            Planejar a infraestrutura para carregadores de carros elétricos ainda na fase de construção evita adaptações caras no futuro e valoriza o empreendimento desde a entrega.
                        </p>
                        <p>
                            A Voltchz atua junto às construtoras e equipes de engenharia elétrica no desenvolvimento do planejamento ideal para instalação de carregadores em estacionamentos residenciais e comerciais, garantindo mais eficiência, segurança e escalabilidade para o
                            projeto.
                        </p>
                    </div>

                    <ul class="space-y-3 sm:space-y-4 mb-10 sm:mb-12">
                        <li class="flex items-start gap-3 text-slate-700 text-sm sm:text-base font-medium">
                            <div class="mt-1 w-5 h-5 rounded-full bg-brand-green/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4">
                  <polyline points="20 6 9 17 4 12" />
                </svg>
                            </div>
                            Planejamento elétrico inteligente
                        </li>
                        <li class="flex items-start gap-3 text-slate-700 text-sm sm:text-base font-medium">
                            <div class="mt-1 w-5 h-5 rounded-full bg-brand-green/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4">
                  <polyline points="20 6 9 17 4 12" />
                </svg>
                            </div>
                            Infraestrutura preparada para expansão futura
                        </li>
                        <li class="flex items-start gap-3 text-slate-700 text-sm sm:text-base font-medium">
                            <div class="mt-1 w-5 h-5 rounded-full bg-brand-green/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4">
                  <polyline points="20 6 9 17 4 12" />
                </svg>
                            </div>
                            Mais valorização para o empreendimento
                        </li>
                        <li class="flex items-start gap-3 text-slate-700 text-sm sm:text-base font-medium">
                            <div class="mt-1 w-5 h-5 rounded-full bg-brand-green/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4">
                  <polyline points="20 6 9 17 4 12" />
                </svg>
                            </div>
                            Adequação às novas demandas do mercado
                        </li>
                        <li class="flex items-start gap-3 text-slate-700 text-sm sm:text-base font-medium">
                            <div class="mt-1 w-5 h-5 rounded-full bg-brand-green/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4">
                  <polyline points="20 6 9 17 4 12" />
                </svg>
                            </div>
                            Suporte técnico especializado para construtoras e engenheiros
                        </li>
                    </ul>

                    <div class="p-6 sm:p-8 bg-white border border-slate-200 rounded-3xl shadow-xl shadow-brand-green/5">
                        <h3 class="text-lg sm:text-xl font-extrabold text-[#1a1a24] mb-3 sm:mb-4">Seu empreendimento pronto para a nova mobilidade</h3>
                        <p class="text-slate-600 text-sm sm:text-base mb-6">Entre em contato com a Voltchz e desenvolva um projeto preparado para o crescimento dos veículos elétricos.</p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="<?php echo htmlspecialchars(get_config('whatsapp_link', 'https://wa.me/5512981039845')); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-3 bg-brand-green text-brand-bg font-bold py-4 px-8 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-brand-green/20 w-full sm:w-auto">
                                Solicitar Planejamento
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                    <polyline points="12 5 19 12 12 19" />
                                </svg>
                            </a>
                            <a href="construtora.php" class="inline-flex items-center justify-center gap-3 border border-slate-300 hover:border-slate-400 bg-transparent text-slate-800 font-bold py-4 px-8 rounded-2xl hover:bg-slate-50 transition-all w-full sm:w-auto">
                                Soluções & Portfólio
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Image Content -->
                <div class="relative group observe order-1 lg:order-2">
                    <div class="absolute -inset-4 bg-brand-green/10 rounded-[40px] sm:rounded-[56px] blur-2xl group-hover:bg-brand-green/20 transition-all duration-700">
                    </div>
                    <div class="relative bg-slate-200 aspect-square sm:aspect-[4/5] rounded-[32px] sm:rounded-[48px] overflow-hidden shadow-2xl border border-white/50">
                        <img src="static/carregador-predio-estacionamento2.webp" alt="Infraestrutura para Construtoras" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">

                        <!-- Overlay decorativo -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>

                        <div class="absolute bottom-4 left-4 right-4 sm:bottom-8 sm:left-8 sm:right-8 p-4 sm:p-6 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl sm:rounded-3xl">
                            <p class="text-white font-bold text-base sm:text-lg mb-0.5 sm:mb-1">Engenharia VoltchZ</p>
                            <p class="text-white/80 text-xs sm:text-sm">Consultoria técnica para grandes obras</p>
                        </div>
                    </div>

                    <!-- Badge flutuante -->
                    <div class="absolute -top-4 -right-4 sm:-top-8 sm:-right-8 bg-brand-bg p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-white/10 shadow-2xl scale-90 sm:scale-100 origin-bottom-right">
                        <div class="text-brand-green text-2xl sm:text-3xl font-black mb-0.5 sm:mb-1">+VALOR</div>
                        <div class="text-[9px] sm:text-[10px] text-brand-muted uppercase font-mono tracking-widest">Para seu projeto
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────────
       VIABILIDADE ELÉTRICA (TEASER)
  ────────────────────────────────────────── -->
    <section id="viabilidade-eletrica" class="relative bg-brand-bg2 py-20 px-6 overflow-hidden border-y border-white/5">
        <div class="absolute inset-0 bg-[linear-gradient(rgba(34,197,94,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(34,197,94,0.03)_1px,transparent_1px)] bg-[size:40px_40px]"></div>
        <div class="max-w-[1200px] mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center observe">

                <!-- Left: Chart preview -->
                <!-- Load Curve Chart (SVG) -->
                <div class="relative p-6 sm:p-8 bg-[#0a0a0f] border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                    <!-- Chart header -->
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-widest text-brand-green mb-1">Monitoramento Ativo</p>
                            <h4 class="text-white font-bold text-2xl">Curva de Carga</h4>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 border border-brand-green/30 rounded-full bg-brand-green/5">
                            <span class="w-2 h-2 rounded-full bg-brand-green animate-pulse"></span>
                            <span class="text-[12px] font-bold text-brand-green tracking-wide">LIVE</span>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="flex flex-wrap gap-x-8 gap-y-3 mb-6">
                        <div class="flex items-center gap-2 text-[13px] text-white font-medium">
                            <div class="w-6 h-0.5 bg-brand-green rounded-full"></div>Demanda Medida
                        </div>
                        <div class="flex items-center gap-2 text-[13px] text-white font-medium">
                            <div class="w-6 h-0.5 border-t-2 border-dashed border-orange-500 rounded-full"></div>Potência Limite
                        </div>
                        <div class="flex items-center gap-2 text-[13px] text-white font-medium">
                            <div class="w-6 h-0.5 bg-blue-500 rounded-full"></div>Capacidade Disponível
                        </div>
                    </div>

                    <!-- Mobile drag hint -->
                    <div class="flex sm:hidden items-center justify-center gap-2 bg-brand-green/15 border border-brand-green/40 text-brand-green rounded-full px-4 py-2.5 mb-3 text-[13px] font-bold">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="swipe-hint-icon shrink-0">
                            <path d="M9 6l-6 6 6 6M15 6l6 6-6 6" />
                        </svg>
                        Arraste para o lado para ver o gráfico completo
                    </div>

              <!-- Limit box on right -->
              <rect x="670" y="50" width="80" height="28" rx="6" fill="#0a0a0f" stroke="#f97316" stroke-width="1"/>
              <text x="710" y="69" text-anchor="middle" font-size="12" font-weight="bold" fill="#f97316">152,40 kVA</text>

              <!-- Peak Annotation Box -->
              <!-- Peak is at x=378.9, y=249.2 -->
              <line x1="378.9" y1="249.2" x2="378.9" y2="200" stroke="#22c55e" stroke-width="1"/>
              <rect x="303.9" y="140" width="150" height="60" rx="8" fill="#0a0a0f" stroke="#22c55e" stroke-width="1"/>
              <text x="378.9" y="165" text-anchor="middle" font-size="16" font-weight="bold" fill="#22c55e">53,74 kVA</text>
              <text x="378.9" y="185" text-anchor="middle" font-size="11" fill="#e4e4e7">Maior potência atingida</text>

              <!-- Capacity Arrow & Annotation -->
              <path d="M 580,75 L 585,85 L 575,85 Z" fill="#3b82f6"/>
              <line x1="580" y1="85" x2="580" y2="245" stroke="#3b82f6" stroke-width="2"/>
              <path d="M 580,255 L 575,245 L 585,245 Z" fill="#3b82f6"/>
              
              <rect x="595" y="130" width="110" height="80" rx="8" fill="#0a0a0f" stroke="#3b82f6" stroke-width="1"/>
              <text x="650" y="155" text-anchor="middle" font-size="16" font-weight="bold" fill="#3b82f6">98,66 kVA</text>
              <text x="650" y="175" text-anchor="middle" font-size="12" fill="#e4e4e7">Capacidade</text>
              <text x="650" y="193" text-anchor="middle" font-size="12" fill="#e4e4e7">disponível</text>

            </svg>
                    </div>

                    <!-- Chart footer metrics -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mt-6 sm:mt-8">
                        <!-- Potencia Limite -->
                        <div class="flex flex-col items-center justify-center text-center gap-2 sm:gap-3 p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-orange-500/30 bg-[#0a0a0f]">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-orange-500/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                  <polygon points="12 7 8 13 11.5 13 11 17 16 11 12 11 12 7" fill="currentColor" stroke="none"/>
                </svg>
                            </div>
                            <div>
                                <div class="text-orange-500 font-bold text-[15px] sm:text-2xl leading-none mb-1">152,40<span class="text-[9px] sm:text-base text-orange-500/80 ml-1">kVA</span></div>
                                <div class="text-[9px] sm:text-[13px] text-white/90 leading-tight">Potência Limite</div>
                            </div>
                        </div>

                        <!-- Maior Potencia Atingida -->
                        <div class="flex flex-col items-center justify-center text-center gap-2 sm:gap-3 p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-brand-green/30 bg-[#0a0a0f]">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-brand-green/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
                            </div>
                            <div>
                                <div class="text-brand-green font-bold text-[15px] sm:text-2xl leading-none mb-1">53,74<span class="text-[9px] sm:text-base text-brand-green/80 ml-1">kVA</span></div>
                                <div class="text-[9px] sm:text-[13px] text-white/90 leading-tight">Maior Potência Atingida</div>
                            </div>
                        </div>

                        <!-- Capacidade Disponivel -->
                        <div class="flex flex-col items-center justify-center text-center gap-2 sm:gap-3 p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-blue-500/30 bg-[#0a0a0f]">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12" />
                  <path d="M12 12l4-4" />
                  <circle cx="12" cy="12" r="2" />
                </svg>
                            </div>
                            <div>
                                <div class="text-blue-500 font-bold text-[15px] sm:text-2xl leading-none mb-1">98,66<span class="text-[9px] sm:text-base text-blue-500/80 ml-1">kVA</span></div>
                                <div class="text-[9px] sm:text-[13px] text-white/90 leading-tight">Capacidade Disponível</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Text content -->
                <div>
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono mb-6">
            <span class="w-1.5 h-1.5 bg-brand-green rounded-full animate-pulse"></span> Engenharia de Dados Elétricos
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.1] mb-6">
                        Estudo de Viabilidade<br>
                        <span class="text-brand-green">e Curva de Carga</span>
                    </h2>
                    <p class="text-brand-muted text-lg leading-relaxed mb-8">
                        Antes de qualquer projeto corporativo ou industrial, realizamos análise técnica completa da infraestrutura existente — com medições certificadas pelo <span class="font-bold text-white">ICC</span> e relatórios de engenharia.
                    </p>
                    <ul class="space-y-3 mb-10">
                        <li class="flex items-center gap-3 text-brand-muted text-[15px]">
                            <div class="w-5 h-5 rounded-full bg-brand-green/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            Estudo de viabilidade elétrica completo
                        </li>
                        <li class="flex items-center gap-3 text-brand-muted text-[15px]">
                            <div class="w-5 h-5 rounded-full bg-brand-green/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            Análise detalhada de demanda e consumo
                        </li>
                        <li class="flex items-center gap-3 text-brand-muted text-[15px]">
                            <div class="w-5 h-5 rounded-full bg-brand-green/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            Monitoramento contínuo de curva de carga
                        </li>
                        <li class="flex items-center gap-3 text-brand-muted text-[15px]">
                            <div class="w-5 h-5 rounded-full bg-brand-green/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            Medições com equipamentos certificados — ICC
                        </li>
                    </ul>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="viabilidade" class="inline-flex items-center justify-center gap-2.5 bg-brand-green text-brand-bg font-bold py-3.5 px-7 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-brand-green/20 text-[14px]">
              Ver Estudo Completo
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
                        <a href="<?php echo htmlspecialchars(get_config('whatsapp_link', 'https://wa.me/5512981039845')); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2.5 border border-white/15 bg-white/5 text-brand-text font-bold py-3.5 px-7 rounded-2xl hover:bg-white/10 transition-all text-[14px]">
              Solicitar Orçamento
            </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="voltage-line"></div>

    <!-- ──────────────────────────────────────────
       SPDA SECTION (SISTEMA DE PROTEÇÃO CONTRA DESCARGAS ATMOSFÉRICAS)
    ────────────────────────────────────────── -->
    <section id="spda" class="relative bg-brand-bg py-20 px-6 overflow-hidden border-b border-white/5">
        <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,0.02)_1px,transparent_1px)] [background-size:24px_24px] opacity-60"></div>
        <div class="max-w-[1200px] mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center observe">
                
                <!-- Left: Text and scope -->
                <div>
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono mb-6">
                        <span class="w-1.5 h-1.5 bg-brand-green rounded-full"></span> Engenharia de Proteção Ativa
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.1] mb-6">
                        Projeto e Inspeção de<br>
                        <span class="text-brand-green">Sistemas SPDA</span>
                    </h2>
                    <p class="text-brand-muted text-lg leading-relaxed mb-8">
                        Garantimos a segurança absoluta de condomínios, indústrias e infraestruturas de recarga antes e durante toda a operação, avaliando a conformidade normativa dos sistemas de proteção contra raios e aterramento.
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">
                        <div class="p-5 bg-white/5 border border-white/5 rounded-2xl">
                            <h4 class="text-white font-bold mb-2 flex items-center gap-2 text-sm sm:text-base">
                                <svg class="w-5 h-5 text-brand-green flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                Escopo de Inspeção
                            </h4>
                            <p class="text-[13px] text-brand-muted leading-relaxed">
                                Avaliação rigorosa dos subsistemas de captação, descida e aterramento, com identificação precisa e indicação em planta baixa de todos os pontos medidos.
                            </p>
                        </div>
                        <div class="p-5 bg-white/5 border border-white/5 rounded-2xl">
                            <h4 class="text-white font-bold mb-2 flex items-center gap-2 text-sm sm:text-base">
                                <svg class="w-5 h-5 text-brand-green flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4"/></svg>
                                Relatório Técnico e ART
                            </h4>
                            <p class="text-[13px] text-brand-muted leading-relaxed">
                                Elaboração de Relatório Técnico detalhado, contendo tabela com valores das medições, fotografias de não-conformidades e fornecimento da ART.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="<?php echo htmlspecialchars(get_config('whatsapp_link', 'https://wa.me/5512981039845')); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2.5 bg-brand-green text-brand-bg font-bold py-3.5 px-7 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-brand-green/20 text-[14px]">
                            Agendar Diagnóstico Técnico
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Right: Norms and checklist -->
                <div class="p-6 sm:p-8 bg-[#0a0a0f] border border-white/5 rounded-3xl overflow-hidden shadow-2xl relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-brand-green/5 rounded-full blur-2xl"></div>
                    
                    <h4 class="text-white font-extrabold text-xl mb-6">Referências Normativas e Ensaios</h4>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-start gap-3">
                            <span class="px-2 py-0.5 rounded bg-brand-green/10 text-brand-green text-[10px] font-mono font-bold mt-1 uppercase">NBR 5419</span>
                            <div>
                                <h5 class="text-white text-[14px] font-semibold">Proteção contra descargas atmosféricas</h5>
                                <p class="text-[12px] text-brand-muted">Vistoria de integridade física dos captores e condutores de descida.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="px-2 py-0.5 rounded bg-brand-green/10 text-brand-green text-[10px] font-mono font-bold mt-1 uppercase">NBR 15749</span>
                            <div>
                                <h5 class="text-white text-[14px] font-semibold">Medição de resistência de aterramento</h5>
                                <p class="text-[12px] text-brand-muted">Ensaio de impedância da malha com equipamentos certificados de alta precisão.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="px-2 py-0.5 rounded bg-brand-green/10 text-brand-green text-[10px] font-mono font-bold mt-1 uppercase">NBR 7117</span>
                            <div>
                                <h5 class="text-white text-[14px] font-semibold">Resistividade e estratificação do solo</h5>
                                <p class="text-[12px] text-brand-muted">Análise geológica para dimensionamento e adequação de malhas de aterramento.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="px-2 py-0.5 rounded bg-brand-green/10 text-brand-green text-[10px] font-mono font-bold mt-1 uppercase">IEC 61643-1</span>
                            <div>
                                <h5 class="text-white text-[14px] font-semibold">Dispositivos de Proteção contra Surtos (DPS)</h5>
                                <p class="text-[12px] text-brand-muted">Verificação e dimensionamento da coordenação de DPS na baixa tensão.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="px-2 py-0.5 rounded bg-brand-green/10 text-brand-green text-[10px] font-mono font-bold mt-1 uppercase">NR 10</span>
                            <div>
                                <h5 class="text-white text-[14px] font-semibold">Segurança em instalações e serviços em eletricidade</h5>
                                <p class="text-[12px] text-brand-muted">Conformidade e procedimentos de segurança elétrica de acordo com o MTE.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-brand-green/5 border border-brand-green/10 rounded-2xl">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-brand-green animate-pulse"></span>
                            <span class="text-[13px] font-bold text-brand-green uppercase tracking-wider">Metodologia VoltchZ</span>
                        </div>
                        <p class="text-[12px] text-brand-muted leading-relaxed">
                            Nossa entrega inclui reunião técnica de apresentação de resultados com equipe de segurança do trabalho do contratante, além da entrega de diagramas unifilares atualizados e mapeamento georreferenciado das medições.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="voltage-line"></div>

    <!-- ──────────────────────────────────────────
       CLIENTS SLIDER (PORTFÓLIO DE INSTALAÇÕES)
  ────────────────────────────────────────── -->
    <section id="clientes" class="bg-brand-bg py-24 sm:py-32 px-6 relative overflow-hidden text-white">
        <!-- Decorative background elements -->
        <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,0.05)_1px,transparent_1px)] [background-size:32px_32px] opacity-40">
        </div>
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-brand-bg to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-brand-bg to-transparent"></div>

        <div class="max-w-[1200px] mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">

                <!-- Text Content -->
                <div class="observe order-2 lg:order-2">
                    <span class="text-brand-green font-mono font-bold text-[12px] uppercase tracking-[0.2em] mb-4 block">PORTFÓLIO
            REAL VOLTCHZ</span>
                    <h2 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight mb-8 leading-[1.1]">
                        Projetos que unem <br><span class="text-brand-green">engenharia, segurança e patrimônio</span>
                    </h2>

                    <div class="space-y-6 text-brand-muted text-lg leading-relaxed mb-12">
                        <p>
                            Na VoltchZ, cada instalação é tratada como infraestrutura crítica. Desenvolvemos soluções de recarga para veículos elétricos com foco em estabilidade energética, segurança operacional e valorização do empreendimento.
                        </p>
                        <p>
                            Nossa metodologia combina análise técnica, planejamento de capacidade elétrica e engenharia normativa para garantir que condomínios e empresas estejam preparados para o avanço da mobilidade elétrica com máxima confiabilidade.
                        </p>
                        <p class="text-base text-white/50 italic">
                            O resultado são projetos elegantes, eficientes e construídos para operar com desempenho contínuo no longo prazo.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div class="flex items-start gap-4 group">
                            <div class="w-12 h-12 rounded-2xl bg-brand-green/10 flex items-center justify-center shrink-0 group-hover:bg-brand-green group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-lg">Rigor Técnico</h4>
                                <p class="text-[14px] text-brand-muted leading-snug">Engenharia aplicada com foco em segurança e performance.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 group">
                            <div class="w-12 h-12 rounded-2xl bg-brand-green/10 flex items-center justify-center shrink-0 group-hover:bg-brand-green group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10" />
                  <polyline points="12 6 12 12 16 14" />
                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-lg">Gestão Avançada</h4>
                                <p class="text-[14px] text-brand-muted leading-snug">Monitoramento inteligente e distribuição eficiente de energia.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex flex-wrap gap-4">
                        <a href="<?php echo htmlspecialchars(get_config('whatsapp_link', 'https://wa.me/5512981039845')); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-3 bg-brand-green text-brand-bg font-bold py-4 px-8 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
                            Falar com Engenheiro
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="5" y1="12" x2="19" y2="12" />
                                <polyline points="12 5 19 12 12 19" />
                            </svg>
                        </a>
                        <a href="portfolio.php" class="inline-flex items-center gap-3 border border-white/20 bg-white/5 backdrop-blur-sm text-brand-text py-4 px-6 rounded-2xl hover:bg-white/10 transition-all font-bold text-xs sm:text-sm">
                            Portfólio Residencial
                        </a>
                        <a href="condominio.php" class="inline-flex items-center gap-3 border border-white/20 bg-white/5 backdrop-blur-sm text-brand-text py-4 px-6 rounded-2xl hover:bg-white/10 transition-all font-bold text-xs sm:text-sm">
                            Portfólio Condomínio
                        </a>
                    </div>
                </div>

                <!-- Vertical Slider Content -->
                <div class="order-1 lg:order-1 relative">
                    <!-- Decorative elements -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand-green/5 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-brand-green/10 rounded-full blur-3xl"></div>

                    <div id="clients-slider-wrapper" class="relative group mx-auto max-w-[480px]">
                        <div id="clients-slider" class="relative aspect-[3/4] w-full rounded-[40px] md:rounded-[56px] overflow-hidden cursor-pointer shadow-[0_32px_64px_-16px_rgba(0,0,0,0.15)] border border-slate-100">
                            <!-- Client Slides will be injected by JS -->
                        </div>

                        <!-- Arrows -->
                        <button id="client-prev" class="absolute -left-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full border border-slate-200 bg-white/90 backdrop-blur-md text-black flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-brand-green hover:text-white hover:border-brand-green shadow-xl active:scale-90"
                            aria-label="Anterior">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="15 18 9 12 15 6" />
              </svg>
            </button>
                        <button id="client-next" class="absolute -right-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full border border-slate-200 bg-white/90 backdrop-blur-md text-black flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-brand-green hover:text-white hover:border-brand-green shadow-xl active:scale-90"
                            aria-label="Próximo">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="9 18 15 12 9 6" />
              </svg>
            </button>

                        <!-- Dots disabled (too many slides) -->

                        <!-- Float Badge -->
                        <div class="absolute top-8 left-8 z-20 pointer-events-none">
                            <div class="bg-white/90 backdrop-blur-md border border-white/20 px-4 py-2 rounded-2xl shadow-xl flex items-center gap-2">
                                <span class="w-2 h-2 bg-brand-green rounded-full animate-pulse"></span>
                                <span class="text-[11px] font-extrabold text-[#1a1a24] uppercase tracking-wider">Portfolio Real</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- SOBRE -->
    <section id="sobre" class="bg-white py-28 px-6 text-slate-900">
        <div class="max-w-[1200px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center observe">
                <div class="relative group mb-8 sm:mb-20 lg:mb-0">
                    <div class="rounded-[48px] overflow-hidden shadow-2xl shadow-brand-green/20">
                        <img src="static/bruno.webp" alt="Bruno, Fundador da VoltchZ" class="w-full transform group-hover:scale-105 transition-transform duration-700" loading="lazy" width="600" height="800">
                    </div>
                    <div class="mt-4 sm:mt-0 sm:absolute sm:-bottom-6 sm:-right-2 lg:-bottom-8 lg:-right-8 bg-slate-50 p-6 lg:p-8 rounded-3xl border border-slate-200 shadow-2xl sm:backdrop-blur-xl sm:max-w-[240px] lg:max-w-[280px]">
                        <h4 class="text-brand-green font-extrabold text-xl mb-1">Bruno, CEO</h4>
                        <p class="text-[12px] text-slate-600 mb-4 font-mono font-semibold uppercase tracking-widest">ITA / INATEL / UNIFESP
                        </p>
                        <div class="flex gap-2 flex-wrap text-brand-text">
                            <span class="text-[10px] font-bold px-3 py-1 bg-brand-green/10 border border-brand-green/20 rounded-full text-slate-600">MESTRE
                UNIFESP</span>
                            <span class="text-[10px] font-bold px-3 py-1 bg-brand-green/10 border border-brand-green/20 rounded-full text-slate-600">DOC
                ITA</span>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="text-brand-green font-mono font-bold text-[13px] uppercase tracking-[0.3em] mb-6 block">Nossa
            História</span>
                    <h2 class="text-4xl sm:text-5xl font-extrabold mb-8 leading-[1.1] tracking-tight text-[#1a1a24]">Fusão entre Ciência e <span class="text-brand-green">Mobilidade</span></h2>
                    <p class="text-slate-600 text-lg mb-8 leading-relaxed">
                        A VoltchZ nasceu da visão estratégica do Bruno, <span class="font-bold text-[#1a1a24]">Engenheiro
              (ITA/INATEL)</span>, <span class="font-bold text-[#1a1a24]">Mestre (UNIFESP)</span> e <span class="font-bold text-[#1a1a24]">Doutorando pelo ITA</span>. Trazemos o <span class="font-bold text-brand-green">rigor técnico</span> de instituições
                        de elite para a execução prática no mercado de mobilidade.
                    </p>
                    <div class="space-y-6 text-slate-600 leading-relaxed text-base mb-10">
                        <p>Atendemos desde projetos domésticos premium até complexas redes de <span class="font-bold">frotas
                corporativas</span>, sempre com <span class="font-bold text-brand-green">ART e documentação
                técnica</span> completa.</p>
                    </div>
                    <a href="sobre" class="inline-flex items-center gap-2 bg-brand-green text-brand-bg font-bold py-4 px-10 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20 mb-10">
            Saiba Mais
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="9 18 15 12 9 6" />
            </svg>
          </a>
                    <div class="p-8 bg-brand-green/5 border-l-[6px] border-brand-green rounded-r-3xl italic text-brand-green font-bold text-lg leading-relaxed shadow-lg shadow-brand-green/5">
                        "Não instalamos apenas carregadores. Projetamos a viabilidade de um futuro mais limpo com segurança técnica absoluta."
                    </div>
                </div>
            </div>
        </div>
    </section>

     <!-- ──────────────────────────────────────────
       DEPOIMENTOS (CLIENT REVIEWS)
  ────────────────────────────────────────── -->
    <section id="depoimentos" class="bg-brand-bg py-24 px-6 relative overflow-hidden">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-brand-green/5 rounded-full blur-3xl"></div>
        <div class="max-w-[1200px] mx-auto relative z-10 text-center observe">
            <span class="text-brand-green font-mono font-bold text-[12px] uppercase tracking-[0.2em] mb-4 block">Feedback</span>
            <h2 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight mb-16 leading-tight">
                O que dizem os <span class="text-brand-green">nossos clientes</span>
            </h2>

            <?php 
            $depoimentos_ativos = get_depoimentos(true);
            if (empty($depoimentos_ativos)): 
            ?>
                <p class="text-brand-muted italic">Em breve, mais depoimentos de nossos clientes parceiros.</p>
            <?php else: 
                // Define as classes de grid dinâmicas com base no número de itens para manter harmonia visual
                $count = count($depoimentos_ativos);
                $grid_cols = "lg:grid-cols-3";
                if ($count === 1) {
                    $grid_cols = "max-w-md mx-auto";
                } elseif ($count === 2) {
                    $grid_cols = "md:grid-cols-2 max-w-3xl mx-auto";
                } else {
                    $grid_cols = "md:grid-cols-2 lg:grid-cols-3";
                }
            ?>
                <div class="grid grid-cols-1 <?php echo $grid_cols; ?> gap-8 text-left mx-auto">
                    <?php foreach ($depoimentos_ativos as $dep): ?>
                        <div class="group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[32px] p-8 backdrop-blur-xl relative overflow-hidden transition-all duration-300 hover:-translate-y-1">
                            <span class="absolute top-4 right-6 text-6xl font-serif text-brand-green opacity-10 select-none pointer-events-none">“</span>
                            <p class="text-brand-text/90 text-[14.5px] italic leading-relaxed mb-8 relative z-10">
                                <?php echo htmlspecialchars($dep['testimonial']); ?>
                            </p>
                            <div class="flex items-center gap-4 pt-4 border-t border-white/5">
                                <?php if (!empty($dep['image_avatar'])): ?>
                                    <img src="<?php echo htmlspecialchars($dep['image_avatar']); ?>" alt="<?php echo htmlspecialchars($dep['name']); ?>" class="w-11 h-11 rounded-full object-cover shrink-0">
                                <?php else: ?>
                                    <div class="w-11 h-11 rounded-full bg-brand-green/10 border border-brand-green/25 text-brand-green font-bold text-xs uppercase flex items-center justify-center shrink-0">
                                        <?php echo htmlspecialchars(substr($dep['name'], 0, 2)); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="min-w-0">
                                    <h4 class="text-white font-bold text-[14.5px] truncate"><?php echo htmlspecialchars($dep['name']); ?></h4>
                                    <p class="text-brand-muted text-xs truncate"><?php echo htmlspecialchars($dep['role_condo']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ──────────────────────────────────────────
       FAQ & LEAD RÁPIDO
  ────────────────────────────────────────── -->
    <section id="duvidas" class="bg-brand-bg2 py-28 px-6">
        <div class="max-w-[1200px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 observe">
                <!-- FAQ Accordion -->
                <div>
                    <span class="text-brand-green font-mono font-bold text-[12px] mb-4 uppercase tracking-[0.2em] block">Dúvidas</span>
                    <h2 class="text-4xl font-extrabold text-white mb-10 tracking-tight">Perguntas Frequentes</h2>
                    <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                        <?php 
                        $faq_items = get_faq(true);
                        foreach ($faq_items as $f_item):
                        ?>
                        <div class="faq-item border border-white/5 rounded-3xl overflow-hidden transition-all bg-white/[0.02] hover:border-white/10">
                            <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-6 text-left group">
                                <span class="font-bold text-lg text-white"><?php echo htmlspecialchars($f_item['question']); ?></span>
                                <svg class="w-6 h-6 text-brand-green transition-transform duration-300" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2.5">
                                  <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </button>
                            <div class="faq-answer px-6 pb-6 text-[15px] text-brand-muted leading-relaxed">
                                <?php 
                                echo nl2br(preg_replace(
                                    '/(\*\*(.*?)\*\*)/', 
                                    '<span class="font-bold text-white">$2</span>', 
                                    preg_replace(
                                        '/(\*(.*?)\*)/', 
                                        '<span class="font-bold text-brand-green">$2</span>', 
                                        htmlspecialchars($f_item['answer'])
                                    )
                                )); 
                                ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Lead Rápido Card -->
                <div class="flex flex-col h-full">
                    <div class="bg-gradient-to-br from-brand-green/15 to-transparent border border-brand-green/20 rounded-[48px] p-8 sm:p-10 lg:p-12 flex-grow text-left flex flex-col justify-center shadow-2xl shadow-brand-green/5 relative overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand-green/10 rounded-full blur-3xl"></div>
                        <h3 class="text-3xl font-extrabold text-white mb-4">Contato rápido no WhatsApp</h3>
                        <p class="text-brand-muted mb-8 text-lg leading-relaxed font-medium">
                            Preencha os dados essenciais para receber um retorno rápido da equipe comercial.
                        </p>
                        <form id="quick-lead-form" class="grid grid-cols-1 gap-4 mb-8">
                            <input type="hidden" name="form_time" value="<?php echo time(); ?>">
                            <div style="display:none !important;">
                                <label for="sobrenome_confirm">Não preencha este campo se for humano:</label>
                                <input type="text" id="sobrenome_confirm" name="sobrenome_confirm" tabindex="-1" autocomplete="off">
                            </div>
                            <input type="text" name="nome" placeholder="Nome completo" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder:text-white/30 focus:outline-none focus:border-brand-green/50 transition-all">
                            <input type="tel" name="telefone" placeholder="Telefone / WhatsApp" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder:text-white/30 focus:outline-none focus:border-brand-green/50 transition-all">
                            <select name="tipo" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-brand-green/50 transition-all">
                <option value="" class="text-black">Tipo de projeto</option>
                <option value="Residencial" class="text-black">Residencial</option>
                <option value="Comercial" class="text-black">Comercial</option>
                <option value="Condomínio" class="text-black">Condomínio</option>
                <option value="Frota" class="text-black">Frota</option>
              </select>
                            <textarea name="mensagem" rows="3" placeholder="Mensagem rápida (opcional)" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder:text-white/30 focus:outline-none focus:border-brand-green/50 transition-all resize-y"></textarea>
                            <button type="submit" class="bg-brand-green text-brand-bg font-extrabold py-4 px-8 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20 text-base sm:text-lg">
                Enviar no WhatsApp
              </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


<?php
// Escaneia as pastas dinamicamente para detectar todas as imagens de instalações físicas existentes e normaliza barras no Windows
$raw_images = array_merge(
    glob('static/clientes/*.{webp,png,jpg,jpeg,gif}', GLOB_BRACE) ?: [],
    glob('static/uploads/*.{webp,png,jpg,jpeg,gif}', GLOB_BRACE) ?: []
);

if ($raw_images) {
    $dir_images = array_map(function($path) {
        return str_replace('\\', '/', $path);
    }, $raw_images);
    natsort($dir_images);
    $client_images = array_values($dir_images);
} else {
    $client_images = [];
}
?>
<script>
    window.VOLTCHZ_CLIENTS = <?php echo json_encode($client_images); ?>;
</script>

<?php
include "includes/footer.php";
?>
