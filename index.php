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
            <!-- Slide 1 -->
            <div class="carousel-slide active" id="slide-0">
                <picture class="carousel-slide-bg">
                    <source srcset="static/banner-rotativo-01webp.webp" type="image/webp">
                    <img src="static/banner-rotativo-01webp.webp" alt="Carregamento de Veículo Elétrico" class="w-full h-full object-cover">
                </picture>
                <div class="absolute inset-0 bg-brand-bg/40"></div>
                <div class="orb w-[420px] h-[420px] -top-20 -right-20 bg-brand-green/20"></div>
                <div class="orb w-[300px] h-[300px] -bottom-20 -left-20 bg-brand-green/10"></div>

                <div class="hero-content">
                    <div class="mb-8 flex justify-center observe">
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono">
              <span class="w-1.5 h-1.5 bg-brand-green rounded-full animate-pulse"></span> Engenharia Certificada
                        </span>
                    </div>
                    <h1 class="text-[clamp(34px,6vw,68px)] font-extrabold leading-[1.05] tracking-tight text-brand-text mb-8 observe">
                        Energia para o futuro,<br>
                        <span class="text-brand-green">segurança no agora</span>
                    </h1>
                    <p class="text-[clamp(16px,2vw,19px)] text-white/90 max-w-[620px] mb-10 leading-relaxed observe">
                        A VoltchZ entrega a infraestrutura completa de carregamento elétrico com rigor técnico e suporte de engenharia.
                    </p>
                    <div class="flex items-center justify-center gap-4 flex-wrap mb-16 observe">
                        <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer" class="bg-brand-green text-brand-bg font-bold py-4 px-10 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
              Solicitar Orçamento
            </a>
                        <a href="sobre.php" class="border border-white/20 bg-white/5 backdrop-blur-sm text-brand-text py-4 px-10 rounded-2xl hover:bg-white/10 transition-all font-bold">
              Saiba Mais
            </a>
                    </div>

                    <!-- Stats -->
                    <div class="stats-grid grid grid-cols-1 sm:grid-cols-3 bg-white/5 border border-white/10 rounded-3xl overflow-hidden max-w-[620px] backdrop-blur-md observe">
                        <div class="p-6 text-center border-b sm:border-b-0 sm:border-r border-white/5">
                            <div class="stat-num text-3xl font-extrabold text-brand-green tracking-tighter font-mono" data-target="300" data-prefix="+">+0</div>
                            <div class="text-[10px] text-white/50 uppercase tracking-[0.1em] mt-1 font-bold">Clientes Atendidos</div>
                        </div>
                        <div class="p-6 text-center border-r border-white/5">
                            <div class="stat-num text-3xl font-extrabold text-brand-green tracking-tighter font-mono" data-target="500" data-prefix="+">+0</div>
                            <div class="text-[10px] text-white/50 uppercase tracking-[0.1em] mt-1 font-bold">Instalações</div>
                        </div>
                        <div class="p-6 text-center">
                            <div class="stat-num text-3xl font-extrabold text-brand-green tracking-tighter font-mono" data-target="22" data-prefix="">0</div>
                            <div class="text-[10px] text-white/50 uppercase tracking-[0.1em] mt-1 font-bold">Anos de Experiência</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-slide" id="slide-1">
                <div class="carousel-slide-bg" style="background-image:url('static/banner-rotativo-02.webp')">
                </div>
                <div class="absolute inset-0 bg-brand-bg/30"></div>
                <div class="orb w-[300px] h-[300px] top-1/4 -right-20 bg-brand-green/15"></div>
                <div class="hero-content">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono mb-8">
            Setor Corporativo
          </span>
                    <h1 class="text-[clamp(34px,6vw,68px)] font-extrabold leading-[1.05] tracking-tight text-brand-text mb-8">
                        Infraestrutura para frotas<br>
                        <span class="text-brand-green">e condomínios</span>
                    </h1>
                    <p class="text-[clamp(16px,2vw,19px)] text-white/90 max-w-[620px] mb-10 leading-relaxed">
                        Gestão balanceada de carga e telemetria para empreendimentos de grande porte.
                    </p>
                    <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer" class="bg-brand-green text-brand-bg font-bold py-4 px-10 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
            Falar com Engenheiro
          </a>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-slide" id="slide-2">
                <div class="carousel-slide-bg" style="background-image:url('static/banner-rotativo-03.webp')">
                </div>
                <div class="absolute inset-0 bg-brand-bg/30"></div>
                <div class="orb w-[350px] h-[350px] bottom-0 -left-20 bg-brand-green/10"></div>
                <div class="hero-content">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono mb-8">
            Engenharia Legal
          </span>
                    <h1 class="text-[clamp(34px,6vw,68px)] font-extrabold leading-[1.05] tracking-tight text-brand-text mb-8">
                        Projetos elétricos com<br>
                        <span class="text-brand-green">engenharia, normas e segurança.</span>
                    </h1>
                    <p class="text-[clamp(16px,2vw,19px)] text-white/90 max-w-[620px] mb-10 leading-relaxed">
                        Nossas instalações seguem todas as normas técnicas (NBR 5410, 17019 e IEC 61851-1), para você carregar seu veículo com total confiança.
                    </p>
                    <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer" class="bg-brand-green text-brand-bg font-bold py-4 px-10 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
            Solicitar Orçamento
          </a>
                </div>
            </div>

            <!-- Slide 4 -->
            <div class="carousel-slide" id="slide-3">
                <picture class="carousel-slide-bg">
                    <source srcset="static/banner-rotativo-04.webp" type="image/webp">
                    <img src="static/banner-rotativo-04.webp" alt="Estações Comerciais" class="w-full h-full object-cover">
                </picture>
                <div class="absolute inset-0 bg-brand-bg/35"></div>
                <div class="orb w-[400px] h-[400px] -top-20 right-1/4 bg-brand-green/10"></div>
                <div class="hero-content">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono mb-8">
            Estações Comerciais
          </span>
                    <h1 class="text-[clamp(34px,6vw,68px)] font-extrabold leading-[1.05] tracking-tight text-brand-text mb-8">
                        Estruture seu negócio com<br>
                        <span class="text-brand-green">recarga de alta performance</span>
                    </h1>
                    <p class="text-[clamp(16px,2vw,19px)] text-white/90 max-w-[700px] mb-10 leading-relaxed">
                        Projetamos infraestrutura rápida e escalável para redes comerciais, eletropostos e operações corporativas, com inteligência de carga, gestão contínua e experiência premium para seus clientes.
                    </p>
                    <a href="contato.php" class="bg-brand-green text-brand-bg font-bold py-4 px-10 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
            Planejar Estação Comercial
          </a>
                </div>
            </div>

            <!-- Controls -->
            <button id="carousel-prev" class="absolute left-5 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full border border-brand-green/20 bg-brand-green/5 text-brand-green flex items-center justify-center hover:bg-brand-green/20 transition-all focus:outline-none focus:ring-2 focus:ring-brand-green"
                aria-label="Slide anterior">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <polyline points="15 18 9 12 15 6" />
        </svg>
      </button>
            <button id="carousel-next" class="absolute right-5 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full border border-brand-green/20 bg-brand-green/5 text-brand-green flex items-center justify-center hover:bg-brand-green/20 transition-all focus:outline-none focus:ring-2 focus:ring-brand-green"
                aria-label="Próximo slide">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <polyline points="9 18 15 12 9 6" />
        </svg>
      </button>

            <!-- Dots -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3 z-20" role="tablist" aria-label="Navegação do carrossel">
                <button id="dot-0" class="carousel-dot active w-3 h-3 rounded-full bg-white/40 border border-white/20 transition-all hover:bg-white/60 focus:outline-none focus:ring-2 focus:ring-brand-green" aria-selected="true" role="tab" aria-label="Ir para slide 1"></button>
                <button id="dot-1" class="carousel-dot w-3 h-3 rounded-full bg-white/40 border border-white/20 transition-all hover:bg-white/60 focus:outline-none focus:ring-2 focus:ring-brand-green" aria-selected="false" role="tab" aria-label="Ir para slide 2"></button>
                <button id="dot-2" class="carousel-dot w-3 h-3 rounded-full bg-white/40 border border-white/20 transition-all hover:bg-white/60 focus:outline-none focus:ring-2 focus:ring-brand-green" aria-selected="false" role="tab" aria-label="Ir para slide 3"></button>
                <button id="dot-3" class="carousel-dot w-3 h-3 rounded-full bg-white/40 border border-white/20 transition-all hover:bg-white/60 focus:outline-none focus:ring-2 focus:ring-brand-green" aria-selected="false" role="tab" aria-label="Ir para slide 4"></button>
            </div>
        </div>
    </header>

    <!-- ──────────────────────────────────────────
       TRUST BAR (SELOS DE QUALIDADE)
  ────────────────────────────────────────── -->
    <div class="bg-brand-bg2/90 border-b border-white/5 flex flex-wrap justify-center backdrop-blur-sm overflow-hidden">
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg> NBR 5410 certificado
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
      </svg> NBR 17019
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
      </svg> IEC 61851-1
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 14l9-5-9-5-9 5 9 5z" />
        <path d="M12 14l6.16-3.422A12.083 12.083 0 0122 19.5H2a12.083 12.083 0 013.84-8.922L12 14z" />
      </svg> Eng. Elétrico Responsável
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path
          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
      </svg> Projeto + ART incluso
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10" />
        <polyline points="12 6 12 12 16 14" />
      </svg> Resposta em 24h
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg> Vale do Paraíba
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg> Litoral Norte de São Paulo
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 border-r border-white/5 text-[12px] font-semibold text-brand-muted whitespace-nowrap">
            <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg> Sul de Minas Gerais
        </div>
        <div class="flex items-center gap-2.5 px-7 py-4 text-[12px] font-semibold text-brand-muted whitespace-nowrap">
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
                    <p class="text-slate-600 leading-relaxed text-[14.5px]">Curadoria de excelência <span class="font-bold text-brand-green">Intelbras</span>, <span class="font-bold text-brand-green">E-Wolf</span> e <span class="font-bold text-brand-green">Incharge</span>.</p>
                    <a href="https://wa.me/5512981039845" class="inline-flex items-center gap-2 mt-7 text-[13px] font-bold text-brand-green border border-brand-green/20 px-5 py-2 rounded-xl hover:bg-brand-green/5 transition-colors">
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
                    <a href="https://wa.me/5512981039845" class="inline-flex items-center gap-2 mt-7 text-[13px] font-bold text-brand-green border border-brand-green/20 px-5 py-2 rounded-xl hover:bg-brand-green/5 transition-colors">Solicitar
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
                    <a href="viabilidade.php" class="inline-flex items-center gap-2 mt-7 text-[13px] font-bold text-brand-green border border-brand-green/20 px-5 py-2 rounded-xl hover:bg-brand-green/5 transition-colors">Ver
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
                    <a href="https://wa.me/5512981039845" class="inline-flex items-center gap-2 mt-7 text-[13px] font-bold text-brand-green border border-brand-green/20 px-5 py-2 rounded-xl hover:bg-brand-green/5 transition-colors">Consultoria</a>
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
                    <a href="https://wa.me/5512981039845" class="inline-flex items-center gap-2 mt-7 text-[13px] font-bold text-brand-green border border-brand-green/20 px-5 py-2 rounded-xl hover:bg-brand-green/5 transition-colors">Saber
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
                    <a href="https://wa.me/5512981039845" class="inline-flex items-center gap-2 mt-7 text-[13px] font-bold text-brand-green border border-brand-green/20 px-5 py-2 rounded-xl hover:bg-brand-green/5 transition-colors">Orçamento</a>
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
                        <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-3 bg-brand-green text-brand-bg font-bold py-4 px-8 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-brand-green/20 w-full sm:w-auto">
              Solicitar Planejamento
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="5" y1="12" x2="19" y2="12" />
                <polyline points="12 5 19 12 12 19" />
              </svg>
            </a>
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

                    <!-- SVG Chart -->
                    <div class="w-full relative rounded-2xl bg-[#0a0a0f] border border-white/5 pb-2 pt-4 overflow-x-auto scrollbar-hide">
                        <svg viewBox="0 0 800 400" preserveAspectRatio="xMidYMid meet" class="w-full h-auto min-w-[650px] sm:min-w-full min-h-[200px] sm:min-h-[280px]" role="img" aria-label="Gráfico de curva de carga elétrica">
              <defs>
                <linearGradient id="greenFillNew" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stop-color="#22c55e" stop-opacity="0.25"/>
                  <stop offset="100%" stop-color="#22c55e" stop-opacity="0"/>
                </linearGradient>
              </defs>

              <!-- Y-axis labels -->
              <text x="35" y="15" text-anchor="end" font-size="12" fill="#a1a1aa">kVA</text>
              <text x="35" y="55" text-anchor="end" font-size="12" fill="#a1a1aa">160</text>
              <text x="35" y="130" text-anchor="end" font-size="12" fill="#a1a1aa">120</text>
              <text x="35" y="205" text-anchor="end" font-size="12" fill="#a1a1aa">80</text>
              <text x="35" y="280" text-anchor="end" font-size="12" fill="#a1a1aa">40</text>
              <text x="35" y="355" text-anchor="end" font-size="12" fill="#a1a1aa">0</text>

              <!-- Grid lines (horizontal) -->
              <g stroke="rgba(255,255,255,0.03)" stroke-width="1">
                <line x1="50" y1="50" x2="750" y2="50"/>
                <line x1="50" y1="125" x2="750" y2="125"/>
                <line x1="50" y1="200" x2="750" y2="200"/>
                <line x1="50" y1="275" x2="750" y2="275"/>
                <line x1="50" y1="350" x2="750" y2="350"/>
              </g>

              <!-- X-axis labels -->
              <g font-size="12" fill="#a1a1aa" text-anchor="middle">
                <text x="60" y="380">13/03</text><text x="60" y="395">00:00</text>
                <text x="128" y="380">14/03</text><text x="128" y="395">00:00</text>
                <text x="196" y="380">15/03</text><text x="196" y="395">00:00</text>
                <text x="264" y="380">16/03</text><text x="264" y="395">00:00</text>
                <text x="332" y="380">17/03</text><text x="332" y="395">00:00</text>
                <text x="400" y="380">18/03</text><text x="400" y="395">00:00</text>
                <text x="468" y="380">19/03</text><text x="468" y="395">00:00</text>
                <text x="536" y="380">20/03</text><text x="536" y="395">00:00</text>
                <text x="604" y="380">21/03</text><text x="604" y="395">00:00</text>
                <text x="672" y="380">22/03</text><text x="672" y="395">00:00</text>
                <text x="740" y="380">23/03</text><text x="740" y="395">00:00</text>
              </g>

              <!-- Green fill area -->
              <path d="M 60.0,320.9 L 61.4,320.2 L 62.7,314.2 L 64.1,318.5 L 65.5,298.2 L 66.8,316.0 L 68.2,297.2 L 69.5,290.0 L 70.9,268.0 L 72.3,267.5 L 73.6,250.2 L 75.0,264.8 L 76.4,279.9 L 77.7,296.7 L 79.1,299.4 L 80.4,315.4 L 81.8,304.2 L 83.2,319.4 L 84.5,315.4 L 85.9,310.9 L 87.3,299.4 L 88.6,311.0 L 90.0,315.3 L 91.3,298.6 L 92.7,307.9 L 94.1,286.3 L 95.4,298.1 L 96.8,308.9 L 98.2,302.7 L 99.5,298.7 L 100.9,310.2 L 102.2,304.5 L 103.6,317.6 L 105.0,310.1 L 106.3,310.2 L 107.7,302.9 L 109.1,309.8 L 110.4,305.5 L 111.8,304.8 L 113.1,306.2 L 114.5,300.0 L 115.9,304.4 L 117.2,307.2 L 118.6,296.7 L 120.0,307.0 L 121.3,305.9 L 122.7,313.3 L 124.0,321.0 L 125.4,307.7 L 126.8,318.5 L 128.1,306.5 L 129.5,304.7 L 130.9,309.5 L 132.2,317.4 L 133.6,310.0 L 134.9,312.4 L 136.3,311.1 L 137.7,295.5 L 139.0,284.1 L 140.4,278.3 L 141.8,272.8 L 143.1,285.5 L 144.5,285.3 L 145.9,306.0 L 147.2,307.7 L 148.6,317.0 L 149.9,307.5 L 151.3,307.7 L 152.7,303.9 L 154.0,306.1 L 155.4,295.4 L 156.8,300.5 L 158.1,301.2 L 159.5,302.4 L 160.8,290.9 L 162.2,291.5 L 163.6,283.5 L 164.9,300.4 L 166.3,300.6 L 167.7,319.3 L 169.0,312.8 L 170.4,315.4 L 171.7,316.7 L 173.1,313.1 L 174.5,308.3 L 175.8,306.0 L 177.2,295.7 L 178.6,289.5 L 179.9,277.0 L 181.3,256.8 L 182.6,251.9 L 184.0,260.8 L 185.4,283.0 L 186.7,286.0 L 188.1,306.2 L 189.5,304.5 L 190.8,308.4 L 192.2,302.7 L 193.5,317.0 L 194.9,313.0 L 196.3,307.8 L 197.6,315.6 L 199.0,315.3 L 200.4,309.3 L 201.7,301.7 L 203.1,301.2 L 204.4,307.5 L 205.8,299.1 L 207.2,306.0 L 208.5,308.4 L 209.9,308.9 L 211.3,315.4 L 212.6,303.7 L 214.0,312.7 L 215.4,306.7 L 216.7,308.7 L 218.1,317.8 L 219.4,309.5 L 220.8,303.0 L 222.2,301.0 L 223.5,311.5 L 224.9,309.1 L 226.3,284.7 L 227.6,283.8 L 229.0,271.4 L 230.3,262.8 L 231.7,281.2 L 233.1,297.2 L 234.4,304.8 L 235.8,302.7 L 237.2,306.1 L 238.5,301.8 L 239.9,307.7 L 241.2,303.2 L 242.6,308.3 L 244.0,314.1 L 245.3,303.7 L 246.7,316.6 L 248.1,305.8 L 249.4,297.5 L 250.8,303.4 L 252.1,312.2 L 253.5,307.1 L 254.9,307.7 L 256.2,312.3 L 257.6,303.6 L 259.0,314.9 L 260.3,316.7 L 261.7,312.4 L 263.0,318.1 L 264.4,315.8 L 265.8,314.4 L 267.1,304.3 L 268.5,318.1 L 269.9,310.4 L 271.2,312.5 L 272.6,288.8 L 273.9,280.8 L 275.3,282.8 L 276.7,263.8 L 278.0,268.2 L 279.4,276.3 L 280.8,287.2 L 282.1,293.9 L 283.5,295.8 L 284.8,305.9 L 286.2,307.8 L 287.6,306.9 L 288.9,311.4 L 290.3,303.6 L 291.7,298.6 L 293.0,312.7 L 294.4,296.2 L 295.8,294.6 L 297.1,289.4 L 298.5,288.9 L 299.8,299.2 L 301.2,300.5 L 302.6,313.5 L 303.9,309.2 L 305.3,299.3 L 306.7,304.8 L 308.0,310.4 L 309.4,310.4 L 310.7,301.8 L 312.1,315.6 L 313.5,309.4 L 314.8,285.6 L 316.2,285.5 L 317.6,269.3 L 318.9,271.3 L 320.3,283.1 L 321.6,285.1 L 323.0,302.0 L 324.4,302.1 L 325.7,298.1 L 327.1,315.3 L 328.5,303.5 L 329.8,320.7 L 331.2,314.1 L 332.5,312.5 L 333.9,306.3 L 335.3,318.6 L 336.6,310.2 L 338.0,311.4 L 339.4,297.8 L 340.7,318.4 L 342.1,311.4 L 343.4,296.2 L 344.8,300.3 L 346.2,287.8 L 347.5,309.8 L 348.9,308.3 L 350.3,318.0 L 351.6,303.8 L 353.0,299.7 L 354.3,314.3 L 355.7,309.7 L 357.1,314.2 L 358.4,305.5 L 359.8,305.3 L 361.2,303.0 L 362.5,285.2 L 363.9,278.2 L 365.3,259.1 L 366.6,269.7 L 368.0,268.6 L 369.3,293.7 L 370.7,306.4 L 372.1,302.9 L 373.4,299.5 L 374.8,294.4 L 376.2,291.3 L 377.5,261.0 L 378.9,249.2 L 380.2,249.0 L 381.6,262.2 L 383.0,287.3 L 384.3,286.5 L 385.7,304.0 L 387.1,304.2 L 388.4,301.6 L 389.8,307.4 L 391.1,315.6 L 392.5,308.4 L 393.9,298.8 L 395.2,308.6 L 396.6,313.8 L 398.0,304.9 L 399.3,313.2 L 400.7,309.6 L 402.0,314.7 L 403.4,313.3 L 404.8,306.6 L 406.1,305.8 L 407.5,310.0 L 408.9,317.9 L 410.2,321.0 L 411.6,309.2 L 412.9,299.7 L 414.3,299.5 L 415.7,293.4 L 417.0,294.7 L 418.4,274.5 L 419.8,271.5 L 421.1,275.6 L 422.5,289.6 L 423.8,292.7 L 425.2,299.4 L 426.6,312.1 L 427.9,310.7 L 429.3,301.7 L 430.7,320.6 L 432.0,304.3 L 433.4,314.3 L 434.7,307.0 L 436.1,319.8 L 437.5,311.2 L 438.8,305.1 L 440.2,307.0 L 441.6,312.3 L 442.9,303.3 L 444.3,301.6 L 445.7,293.2 L 447.0,283.8 L 448.4,288.9 L 449.7,281.3 L 451.1,304.9 L 452.5,296.1 L 453.8,319.7 L 455.2,303.5 L 456.6,309.6 L 457.9,321.0 L 459.3,300.8 L 460.6,299.1 L 462.0,298.4 L 463.4,298.1 L 464.7,291.1 L 466.1,282.4 L 467.5,272.2 L 468.8,264.1 L 470.2,272.7 L 471.5,294.7 L 472.9,307.6 L 474.3,309.7 L 475.6,308.3 L 477.0,296.6 L 478.4,284.8 L 479.7,263.6 L 481.1,253.7 L 482.4,254.9 L 483.8,271.9 L 485.2,273.5 L 486.5,294.1 L 487.9,312.7 L 489.3,309.9 L 490.6,305.2 L 492.0,304.7 L 493.3,317.9 L 494.7,309.0 L 496.1,298.1 L 497.4,309.4 L 498.8,314.9 L 500.2,300.6 L 501.5,299.7 L 502.9,302.7 L 504.2,294.3 L 505.6,314.7 L 507.0,305.4 L 508.3,301.2 L 509.7,307.3 L 511.1,314.7 L 512.4,320.1 L 513.8,305.1 L 515.2,302.5 L 516.5,308.8 L 517.9,300.1 L 519.2,282.6 L 520.6,263.4 L 522.0,266.2 L 523.3,256.3 L 524.7,282.2 L 526.1,295.0 L 527.4,303.4 L 528.8,306.8 L 530.1,296.1 L 531.5,307.0 L 532.9,320.8 L 534.2,319.0 L 535.6,313.2 L 537.0,320.2 L 538.3,309.3 L 539.7,315.1 L 541.0,302.7 L 542.4,303.5 L 543.8,301.3 L 545.1,309.6 L 546.5,312.3 L 547.9,304.5 L 549.2,311.9 L 550.6,315.0 L 551.9,312.4 L 553.3,314.2 L 554.7,300.4 L 556.0,302.4 L 557.4,318.6 L 558.8,320.1 L 560.1,304.2 L 561.5,312.3 L 562.8,318.8 L 564.2,298.8 L 565.6,290.2 L 566.9,283.7 L 568.3,269.8 L 569.7,256.3 L 571.0,262.4 L 572.4,284.8 L 573.7,292.2 L 575.1,291.0 L 576.5,310.7 L 577.8,303.2 L 579.2,304.1 L 580.6,304.9 L 581.9,305.4 L 583.3,312.2 L 584.6,296.7 L 586.0,298.9 L 587.4,280.4 L 588.7,259.6 L 590.1,256.2 L 591.5,266.2 L 592.8,267.9 L 594.2,282.4 L 595.6,296.8 L 596.9,313.0 L 598.3,302.5 L 599.6,305.7 L 601.0,318.1 L 602.4,310.0 L 603.7,320.6 L 605.1,318.0 L 606.5,315.2 L 607.8,307.1 L 609.2,314.5 L 610.5,300.4 L 611.9,295.2 L 613.3,315.9 L 614.6,314.0 L 616.0,295.8 L 617.4,289.8 L 618.7,290.7 L 620.1,300.1 L 621.4,302.8 L 622.8,314.8 L 624.2,314.0 L 625.5,300.2 L 626.9,309.8 L 628.3,316.1 L 629.6,299.9 L 631.0,317.8 L 632.3,309.6 L 633.7,295.9 L 635.1,287.1 L 636.4,269.5 L 637.8,252.3 L 639.2,263.6 L 640.5,275.6 L 641.9,295.2 L 643.2,297.7 L 644.6,298.5 L 646.0,308.6 L 647.3,305.2 L 648.7,309.2 L 650.1,302.8 L 651.4,307.9 L 652.8,304.4 L 654.1,299.3 L 655.5,291.9 L 656.9,280.6 L 658.2,269.0 L 659.6,265.6 L 661.0,275.5 L 662.3,286.1 L 663.7,294.0 L 665.1,311.8 L 666.4,303.1 L 667.8,305.1 L 669.1,319.4 L 670.5,321.9 L 671.9,317.9 L 673.2,304.7 L 674.6,306.7 L 676.0,318.6 L 677.3,300.7 L 678.7,316.0 L 680.0,306.1 L 681.4,298.5 L 682.8,274.4 L 684.1,263.8 L 685.5,265.5 L 686.9,276.9 L 688.2,274.3 L 689.6,292.6 L 690.9,299.0 L 692.3,306.1 L 693.7,305.4 L 695.0,317.0 L 696.4,315.7 L 697.8,308.3 L 699.1,302.0 L 700.5,306.8 L 701.8,318.0 L 703.2,311.1 L 704.6,303.5 L 705.9,285.4 L 707.3,300.3 L 708.7,304.0 L 710.0,310.1 L 711.4,296.5 L 712.7,301.3 L 714.1,316.4 L 715.5,308.8 L 716.8,310.8 L 718.2,301.0 L 719.6,311.8 L 720.9,305.6 L 722.3,306.1 L 723.6,291.3 L 725.0,278.3 L 726.4,276.4 L 727.7,283.2 L 729.1,294.8 L 730.5,291.6 L 731.8,300.1 L 733.2,311.1 L 734.5,316.8 L 735.9,311.0 L 737.3,316.0 L 738.6,321.3 L 740.0,309.2 L 740,350 L 60,350 Z" fill="url(#greenFillNew)"/>
              <!-- Green line -->
              <path d="M 60.0,320.9 L 61.4,320.2 L 62.7,314.2 L 64.1,318.5 L 65.5,298.2 L 66.8,316.0 L 68.2,297.2 L 69.5,290.0 L 70.9,268.0 L 72.3,267.5 L 73.6,250.2 L 75.0,264.8 L 76.4,279.9 L 77.7,296.7 L 79.1,299.4 L 80.4,315.4 L 81.8,304.2 L 83.2,319.4 L 84.5,315.4 L 85.9,310.9 L 87.3,299.4 L 88.6,311.0 L 90.0,315.3 L 91.3,298.6 L 92.7,307.9 L 94.1,286.3 L 95.4,298.1 L 96.8,308.9 L 98.2,302.7 L 99.5,298.7 L 100.9,310.2 L 102.2,304.5 L 103.6,317.6 L 105.0,310.1 L 106.3,310.2 L 107.7,302.9 L 109.1,309.8 L 110.4,305.5 L 111.8,304.8 L 113.1,306.2 L 114.5,300.0 L 115.9,304.4 L 117.2,307.2 L 118.6,296.7 L 120.0,307.0 L 121.3,305.9 L 122.7,313.3 L 124.0,321.0 L 125.4,307.7 L 126.8,318.5 L 128.1,306.5 L 129.5,304.7 L 130.9,309.5 L 132.2,317.4 L 133.6,310.0 L 134.9,312.4 L 136.3,311.1 L 137.7,295.5 L 139.0,284.1 L 140.4,278.3 L 141.8,272.8 L 143.1,285.5 L 144.5,285.3 L 145.9,306.0 L 147.2,307.7 L 148.6,317.0 L 149.9,307.5 L 151.3,307.7 L 152.7,303.9 L 154.0,306.1 L 155.4,295.4 L 156.8,300.5 L 158.1,301.2 L 159.5,302.4 L 160.8,290.9 L 162.2,291.5 L 163.6,283.5 L 164.9,300.4 L 166.3,300.6 L 167.7,319.3 L 169.0,312.8 L 170.4,315.4 L 171.7,316.7 L 173.1,313.1 L 174.5,308.3 L 175.8,306.0 L 177.2,295.7 L 178.6,289.5 L 179.9,277.0 L 181.3,256.8 L 182.6,251.9 L 184.0,260.8 L 185.4,283.0 L 186.7,286.0 L 188.1,306.2 L 189.5,304.5 L 190.8,308.4 L 192.2,302.7 L 193.5,317.0 L 194.9,313.0 L 196.3,307.8 L 197.6,315.6 L 199.0,315.3 L 200.4,309.3 L 201.7,301.7 L 203.1,301.2 L 204.4,307.5 L 205.8,299.1 L 207.2,306.0 L 208.5,308.4 L 209.9,308.9 L 211.3,315.4 L 212.6,303.7 L 214.0,312.7 L 215.4,306.7 L 216.7,308.7 L 218.1,317.8 L 219.4,309.5 L 220.8,303.0 L 222.2,301.0 L 223.5,311.5 L 224.9,309.1 L 226.3,284.7 L 227.6,283.8 L 229.0,271.4 L 230.3,262.8 L 231.7,281.2 L 233.1,297.2 L 234.4,304.8 L 235.8,302.7 L 237.2,306.1 L 238.5,301.8 L 239.9,307.7 L 241.2,303.2 L 242.6,308.3 L 244.0,314.1 L 245.3,303.7 L 246.7,316.6 L 248.1,305.8 L 249.4,297.5 L 250.8,303.4 L 252.1,312.2 L 253.5,307.1 L 254.9,307.7 L 256.2,312.3 L 257.6,303.6 L 259.0,314.9 L 260.3,316.7 L 261.7,312.4 L 263.0,318.1 L 264.4,315.8 L 265.8,314.4 L 267.1,304.3 L 268.5,318.1 L 269.9,310.4 L 271.2,312.5 L 272.6,288.8 L 273.9,280.8 L 275.3,282.8 L 276.7,263.8 L 278.0,268.2 L 279.4,276.3 L 280.8,287.2 L 282.1,293.9 L 283.5,295.8 L 284.8,305.9 L 286.2,307.8 L 287.6,306.9 L 288.9,311.4 L 290.3,303.6 L 291.7,298.6 L 293.0,312.7 L 294.4,296.2 L 295.8,294.6 L 297.1,289.4 L 298.5,288.9 L 299.8,299.2 L 301.2,300.5 L 302.6,313.5 L 303.9,309.2 L 305.3,299.3 L 306.7,304.8 L 308.0,310.4 L 309.4,310.4 L 310.7,301.8 L 312.1,315.6 L 313.5,309.4 L 314.8,285.6 L 316.2,285.5 L 317.6,269.3 L 318.9,271.3 L 320.3,283.1 L 321.6,285.1 L 323.0,302.0 L 324.4,302.1 L 325.7,298.1 L 327.1,315.3 L 328.5,303.5 L 329.8,320.7 L 331.2,314.1 L 332.5,312.5 L 333.9,306.3 L 335.3,318.6 L 336.6,310.2 L 338.0,311.4 L 339.4,297.8 L 340.7,318.4 L 342.1,311.4 L 343.4,296.2 L 344.8,300.3 L 346.2,287.8 L 347.5,309.8 L 348.9,308.3 L 350.3,318.0 L 351.6,303.8 L 353.0,299.7 L 354.3,314.3 L 355.7,309.7 L 357.1,314.2 L 358.4,305.5 L 359.8,305.3 L 361.2,303.0 L 362.5,285.2 L 363.9,278.2 L 365.3,259.1 L 366.6,269.7 L 368.0,268.6 L 369.3,293.7 L 370.7,306.4 L 372.1,302.9 L 373.4,299.5 L 374.8,294.4 L 376.2,291.3 L 377.5,261.0 L 378.9,249.2 L 380.2,249.0 L 381.6,262.2 L 383.0,287.3 L 384.3,286.5 L 385.7,304.0 L 387.1,304.2 L 388.4,301.6 L 389.8,307.4 L 391.1,315.6 L 392.5,308.4 L 393.9,298.8 L 395.2,308.6 L 396.6,313.8 L 398.0,304.9 L 399.3,313.2 L 400.7,309.6 L 402.0,314.7 L 403.4,313.3 L 404.8,306.6 L 406.1,305.8 L 407.5,310.0 L 408.9,317.9 L 410.2,321.0 L 411.6,309.2 L 412.9,299.7 L 414.3,299.5 L 415.7,293.4 L 417.0,294.7 L 418.4,274.5 L 419.8,271.5 L 421.1,275.6 L 422.5,289.6 L 423.8,292.7 L 425.2,299.4 L 426.6,312.1 L 427.9,310.7 L 429.3,301.7 L 430.7,320.6 L 432.0,304.3 L 433.4,314.3 L 434.7,307.0 L 436.1,319.8 L 437.5,311.2 L 438.8,305.1 L 440.2,307.0 L 441.6,312.3 L 442.9,303.3 L 444.3,301.6 L 445.7,293.2 L 447.0,283.8 L 448.4,288.9 L 449.7,281.3 L 451.1,304.9 L 452.5,296.1 L 453.8,319.7 L 455.2,303.5 L 456.6,309.6 L 457.9,321.0 L 459.3,300.8 L 460.6,299.1 L 462.0,298.4 L 463.4,298.1 L 464.7,291.1 L 466.1,282.4 L 467.5,272.2 L 468.8,264.1 L 470.2,272.7 L 471.5,294.7 L 472.9,307.6 L 474.3,309.7 L 475.6,308.3 L 477.0,296.6 L 478.4,284.8 L 479.7,263.6 L 481.1,253.7 L 482.4,254.9 L 483.8,271.9 L 485.2,273.5 L 486.5,294.1 L 487.9,312.7 L 489.3,309.9 L 490.6,305.2 L 492.0,304.7 L 493.3,317.9 L 494.7,309.0 L 496.1,298.1 L 497.4,309.4 L 498.8,314.9 L 500.2,300.6 L 501.5,299.7 L 502.9,302.7 L 504.2,294.3 L 505.6,314.7 L 507.0,305.4 L 508.3,301.2 L 509.7,307.3 L 511.1,314.7 L 512.4,320.1 L 513.8,305.1 L 515.2,302.5 L 516.5,308.8 L 517.9,300.1 L 519.2,282.6 L 520.6,263.4 L 522.0,266.2 L 523.3,256.3 L 524.7,282.2 L 526.1,295.0 L 527.4,303.4 L 528.8,306.8 L 530.1,296.1 L 531.5,307.0 L 532.9,320.8 L 534.2,319.0 L 535.6,313.2 L 537.0,320.2 L 538.3,309.3 L 539.7,315.1 L 541.0,302.7 L 542.4,303.5 L 543.8,301.3 L 545.1,309.6 L 546.5,312.3 L 547.9,304.5 L 549.2,311.9 L 550.6,315.0 L 551.9,312.4 L 553.3,314.2 L 554.7,300.4 L 556.0,302.4 L 557.4,318.6 L 558.8,320.1 L 560.1,304.2 L 561.5,312.3 L 562.8,318.8 L 564.2,298.8 L 565.6,290.2 L 566.9,283.7 L 568.3,269.8 L 569.7,256.3 L 571.0,262.4 L 572.4,284.8 L 573.7,292.2 L 575.1,291.0 L 576.5,310.7 L 577.8,303.2 L 579.2,304.1 L 580.6,304.9 L 581.9,305.4 L 583.3,312.2 L 584.6,296.7 L 586.0,298.9 L 587.4,280.4 L 588.7,259.6 L 590.1,256.2 L 591.5,266.2 L 592.8,267.9 L 594.2,282.4 L 595.6,296.8 L 596.9,313.0 L 598.3,302.5 L 599.6,305.7 L 601.0,318.1 L 602.4,310.0 L 603.7,320.6 L 605.1,318.0 L 606.5,315.2 L 607.8,307.1 L 609.2,314.5 L 610.5,300.4 L 611.9,295.2 L 613.3,315.9 L 614.6,314.0 L 616.0,295.8 L 617.4,289.8 L 618.7,290.7 L 620.1,300.1 L 621.4,302.8 L 622.8,314.8 L 624.2,314.0 L 625.5,300.2 L 626.9,309.8 L 628.3,316.1 L 629.6,299.9 L 631.0,317.8 L 632.3,309.6 L 633.7,295.9 L 635.1,287.1 L 636.4,269.5 L 637.8,252.3 L 639.2,263.6 L 640.5,275.6 L 641.9,295.2 L 643.2,297.7 L 644.6,298.5 L 646.0,308.6 L 647.3,305.2 L 648.7,309.2 L 650.1,302.8 L 651.4,307.9 L 652.8,304.4 L 654.1,299.3 L 655.5,291.9 L 656.9,280.6 L 658.2,269.0 L 659.6,265.6 L 661.0,275.5 L 662.3,286.1 L 663.7,294.0 L 665.1,311.8 L 666.4,303.1 L 667.8,305.1 L 669.1,319.4 L 670.5,321.9 L 671.9,317.9 L 673.2,304.7 L 674.6,306.7 L 676.0,318.6 L 677.3,300.7 L 678.7,316.0 L 680.0,306.1 L 681.4,298.5 L 682.8,274.4 L 684.1,263.8 L 685.5,265.5 L 686.9,276.9 L 688.2,274.3 L 689.6,292.6 L 690.9,299.0 L 692.3,306.1 L 693.7,305.4 L 695.0,317.0 L 696.4,315.7 L 697.8,308.3 L 699.1,302.0 L 700.5,306.8 L 701.8,318.0 L 703.2,311.1 L 704.6,303.5 L 705.9,285.4 L 707.3,300.3 L 708.7,304.0 L 710.0,310.1 L 711.4,296.5 L 712.7,301.3 L 714.1,316.4 L 715.5,308.8 L 716.8,310.8 L 718.2,301.0 L 719.6,311.8 L 720.9,305.6 L 722.3,306.1 L 723.6,291.3 L 725.0,278.3 L 726.4,276.4 L 727.7,283.2 L 729.1,294.8 L 730.5,291.6 L 731.8,300.1 L 733.2,311.1 L 734.5,316.8 L 735.9,311.0 L 737.3,316.0 L 738.6,321.3 L 740.0,309.2" fill="none" stroke="#22c55e" stroke-width="1.5" stroke-linejoin="round"/>

              <!-- Orange dashed limit line at ~152.4 kVA (y=64.25) -->
              <line x1="50" y1="64.25" x2="750" y2="64.25" stroke="#f97316" stroke-width="2" stroke-dasharray="8,6"/>
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
                    <div class="grid grid-cols-3 gap-2 sm:gap-6 mt-6 sm:mt-8">
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
                        <a href="viabilidade.php" class="inline-flex items-center justify-center gap-2.5 bg-brand-green text-brand-bg font-bold py-3.5 px-7 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-brand-green/20 text-[14px]">
              Ver Estudo Completo
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
                        <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2.5 border border-white/15 bg-white/5 text-brand-text font-bold py-3.5 px-7 rounded-2xl hover:bg-white/10 transition-all text-[14px]">
              Solicitar Orçamento
            </a>
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

                    <div class="mt-12">
                        <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-3 bg-brand-green text-brand-bg font-bold py-4 px-8 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
              Falar com Engenheiro
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="5" y1="12" x2="19" y2="12" />
                <polyline points="12 5 19 12 12 19" />
              </svg>
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

                        <!-- Dots -->
                        <div id="client-dots" class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3 z-20">
                            <!-- Dots will be injected by JS -->
                        </div>

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
                <div class="relative group mb-20 lg:mb-0">
                    <div class="rounded-[48px] overflow-hidden shadow-2xl shadow-brand-green/20">
                        <img src="static/bruno.webp" alt="Bruno, Fundador da VoltchZ" class="w-full transform group-hover:scale-105 transition-transform duration-700" loading="lazy" width="600" height="800">
                    </div>
                    <div class="absolute -bottom-6 -right-2 lg:-bottom-8 lg:-right-8 bg-slate-50 p-6 lg:p-8 rounded-3xl border border-slate-200 shadow-2xl backdrop-blur-xl max-w-[240px] lg:max-w-[280px]">
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
                    <a href="sobre.php" class="inline-flex items-center gap-2 bg-brand-green text-brand-bg font-bold py-4 px-10 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20 mb-10">
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
       LIGHTBOX (VISUALIZAÇÃO DE FOTOS)
  ────────────────────────────────────────── -->
    <div id="lightbox" class="fixed inset-0 z-[100] bg-brand-bg/95 backdrop-blur-xl hidden flex-col items-center justify-center p-6">
        <button class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors">
      <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>
        <img id="lightbox-img" src="" alt="Client Photo" class="max-w-full max-h-[80vh] rounded-3xl shadow-2xl">
    </div>

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
                        <div class="faq-item border border-white/5 rounded-3xl overflow-hidden transition-all bg-white/[0.02] hover:border-white/10">
                            <button class="w-full flex items-center justify-between p-6 text-left group">
                <span class="font-bold text-lg text-white">1. Qual a potência ideal de carregador para uso
                  residencial?</span>
                <svg class="w-6 h-6 text-brand-green transition-transform duration-300" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2.5">
                  <polyline points="6 9 12 15 18 9" />
                </svg>
              </button>
                            <div class="faq-answer px-6 pb-6 text-[15px] text-brand-muted leading-relaxed">
                                A maioria dos usuários utiliza carregadores a partir de <span class="font-bold text-white">7 kW</span>, que já oferecem boa velocidade. Em alguns casos, é possível usar <span class="font-bold text-white">11
                  kW ou 22 kW</span>, dependendo do veículo e da estrutura elétrica disponível.
                            </div>
                        </div>

                        <div class="faq-item border border-white/5 rounded-3xl overflow-hidden transition-all bg-white/[0.02] hover:border-white/10">
                            <button class="w-full flex items-center justify-between p-6 text-left group">
                <span class="font-bold text-lg text-white">2. Qual o impacto do carregador na conta de energia?</span>
                <svg class="w-6 h-6 text-brand-green transition-transform duration-300" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2.5">
                  <polyline points="6 9 12 15 18 9" />
                </svg>
              </button>
                            <div class="faq-answer px-6 pb-6 text-[15px] text-brand-muted leading-relaxed">
                                O impacto depende da potência do carregador e da frequência de uso. Em condomínios, é possível fazer
                                <span class="font-bold text-white">medição individualizada</span> para que cada usuário pague apenas o que consome de forma justa.
                            </div>
                        </div>

                        <div class="faq-item border border-white/5 rounded-3xl overflow-hidden transition-all bg-white/[0.02] hover:border-white/10">
                            <button class="w-full flex items-center justify-between p-6 text-left group">
                <span class="font-bold text-lg text-white">3. Posso usar a tomada comum da garagem para carregar?</span>
                <svg class="w-6 h-6 text-brand-green transition-transform duration-300" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2.5">
                  <polyline points="6 9 12 15 18 9" />
                </svg>
              </button>
                            <div class="faq-answer px-6 pb-6 text-[15px] text-brand-muted leading-relaxed">
                                Até é possível, mas <span class="font-bold text-white">não é recomendado</span>. Tomadas comuns não suportam uso contínuo de alta carga, o que pode causar aquecimento e riscos. O ideal é um <span class="font-bold text-brand-green">carregador dedicado (Wallbox)</span>.
                            </div>
                        </div>

                        <div class="faq-item border border-white/5 rounded-3xl overflow-hidden transition-all bg-white/[0.02] hover:border-white/10">
                            <button class="w-full flex items-center justify-between p-6 text-left group">
                <span class="font-bold text-lg text-white">4. Quais normas técnicas preciso atender na
                  instalação?</span>
                <svg class="w-6 h-6 text-brand-green transition-transform duration-300" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2.5">
                  <polyline points="6 9 12 15 18 9" />
                </svg>
              </button>
                            <div class="faq-answer px-6 pb-6 text-[15px] text-brand-muted leading-relaxed">
                                As principais são: <span class="font-bold text-white">NBR 17019, NBR 5410, NBR IEC 61851-1</span> e normas de segurança contra incêndio do Corpo de Bombeiros. Segui-las garante uma instalação segura e adequada.
                            </div>
                        </div>

                        <div class="faq-item border border-white/5 rounded-3xl overflow-hidden transition-all bg-white/[0.02] hover:border-white/10">
                            <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-6 text-left group">
                <span class="font-bold text-lg text-white">5. Qual a diferença entre carregador portátil e fixo?</span>
                <svg class="w-6 h-6 text-brand-green transition-transform duration-300" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2.5">
                  <polyline points="6 9 12 15 18 9" />
                </svg>
              </button>
                            <div class="faq-answer px-6 pb-6 text-[15px] text-brand-muted leading-relaxed">
                                O portátil é indicado para emergências ou uso ocasional, com menor potência. Já o <span class="font-bold text-white">Wallbox</span> é fixo, mais seguro e oferece maior desempenho para o carregamento diário.
                            </div>
                        </div>

                        <div class="faq-item border border-white/5 rounded-3xl overflow-hidden transition-all bg-white/[0.02] hover:border-white/10">
                            <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-6 text-left group">
                <span class="font-bold text-lg text-white">6. O que acontece se eu não seguir as normas técnicas?</span>
                <svg class="w-6 h-6 text-brand-green transition-transform duration-300" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2.5">
                  <polyline points="6 9 12 15 18 9" />
                </svg>
              </button>
                            <div class="faq-answer px-6 pb-6 text-[15px] text-brand-muted leading-relaxed">
                                Pode gerar riscos como <span class="font-bold text-white">choques elétricos, incêndios</span> e até perda de garantia do veículo ou equipamento. Seguir as normas é essencial para a <span class="font-bold text-brand-green">segurança e durabilidade</span>.
                            </div>
                        </div>

                        <div class="faq-item border border-white/5 rounded-3xl overflow-hidden transition-all bg-white/[0.02] hover:border-white/10">
                            <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-6 text-left group">
                <span class="font-bold text-lg text-white">7. Preciso de autorização para instalar no condomínio?</span>
                <svg class="w-6 h-6 text-brand-green transition-transform duration-300" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2.5">
                  <polyline points="6 9 12 15 18 9" />
                </svg>
              </button>
                            <div class="faq-answer px-6 pb-6 text-[15px] text-brand-muted leading-relaxed">
                                <span class="font-bold text-white">Sim</span>. Normalmente é necessário comunicar o síndico e, em alguns casos, aprovação em assembleia, além de um <span class="font-bold text-brand-green">estudo da capacidade
                  elétrica</span> do local.
                            </div>
                        </div>

                        <div class="faq-item border border-white/5 rounded-3xl overflow-hidden transition-all bg-white/[0.02] hover:border-white/10">
                            <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-6 text-left group">
                <span class="font-bold text-lg text-white">8. Posso instalar um carregador rápido DC no
                  condomínio?</span>
                <svg class="w-6 h-6 text-brand-green transition-transform duration-300" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2.5">
                  <polyline points="6 9 12 15 18 9" />
                </svg>
              </button>
                            <div class="faq-answer px-6 pb-6 text-[15px] text-brand-muted leading-relaxed">
                                Sim, mas exige <span class="font-bold text-white">infraestrutura elétrica robusta</span> (geralmente 380V trifásico), além de um projeto técnico específico de engenharia.
                            </div>
                        </div>

                        <div class="faq-item border border-white/5 rounded-3xl overflow-hidden transition-all bg-white/[0.02] hover:border-white/10">
                            <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-6 text-left group">
                <span class="font-bold text-lg text-white">9. O carregador pode ser compartilhado no condomínio?</span>
                <svg class="w-6 h-6 text-brand-green transition-transform duration-300" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2.5">
                  <polyline points="6 9 12 15 18 9" />
                </svg>
              </button>
                            <div class="faq-answer px-6 pb-6 text-[15px] text-brand-muted leading-relaxed">
                                <span class="font-bold text-white">Sim</span>. É uma solução econômica, desde que haja controle de consumo e gestão adequada para garantir a divisão justa da energia entre os moradores.
                            </div>
                        </div>

                        <div class="faq-item border border-white/5 rounded-3xl overflow-hidden transition-all bg-white/[0.02] hover:border-white/10">
                            <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-6 text-left group">
                <span class="font-bold text-lg text-white">10. Preciso contratar apenas empresas da montadora?</span>
                <svg class="w-6 h-6 text-brand-green transition-transform duration-300" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2.5">
                  <polyline points="6 9 12 15 18 9" />
                </svg>
              </button>
                            <div class="faq-answer px-6 pb-6 text-[15px] text-brand-muted leading-relaxed">
                                <span class="font-bold text-white">Não</span>. O mais importante é que a instalação siga as <span class="font-bold text-brand-green">normas técnicas</span>. Isso garante segurança, independentemente da empresa ou marca
                                do carregador.
                            </div>
                        </div>
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
include "includes/footer.php";
?>
