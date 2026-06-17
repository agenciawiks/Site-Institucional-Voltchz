<?php
require_once "includes/db.php";
$page_title = "Portfólio de Instalações Homologadas — VoltchZ Brasil";
$page_desc = "Veja nosso portfólio real de infraestruturas de recarga e proteções instaladas para carros BYD, GWM, Geely, Volvo, Tesla, Porsche e mais.";
$current_page = "portfolio";
include "includes/header.php";
?>

  <!-- ──────────────────────────────────────────
       HERO PORTFÓLIO
  ────────────────────────────────────────── -->
  <header class="relative pt-32 pb-16 overflow-hidden bg-brand-bg2">
    <div class="absolute inset-0 opacity-20">
      <div class="orb w-[500px] h-[500px] -top-30 -right-30 bg-brand-green/20"></div>
    </div>
    <div class="max-w-[1200px] mx-auto px-6 relative z-10 text-center">
      <span
        class="inline-block px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono mb-5">
        Projetos Reais VoltchZ
      </span>
      <h1 class="text-[clamp(34px,7vw,64px)] font-extrabold leading-tight tracking-tighter mb-6">
        Galeria de Instalações Reais<br>
        <span class="text-brand-green">por Montadora</span>
      </h1>
      <p class="text-lg text-brand-muted max-w-3xl mx-auto leading-relaxed">
        Explore nossa galeria de instalações de carregadores e quadros de segurança E-Wolf feitas para cada fabricante, certificando compatibilidade absoluta e engenharia de alto padrão.
      </p>
    </div>
  </header>

  <!-- ──────────────────────────────────────────
       CORPO PRINCIPAL (LOGOS, FILTROS E GRID)
  ────────────────────────────────────────── -->
  <main class="py-12 px-6 bg-brand-bg relative min-h-[60vh] z-10">
    <div class="max-w-[1200px] mx-auto">

      <!-- Logos Grid: Marcas com Eletromobilidade Homologada -->
      <div class="mb-16 observe">
        <p class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green/60 text-center mb-8">Compatibilidade e Homologação Garantida</p>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 max-w-5xl mx-auto">
          <!-- Tesla -->
          <div class="px-5 py-4 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-2 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group">
            <svg class="h-8 w-8 text-white group-hover:text-brand-green transition-colors" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2C11.38 3.5 9.77 5.6 7 6.4c2 1.3 3.8 3 5 5 1.2-2 3-3.7 5-5-2.77-.8-4.38-2.9-5-4.4zm0 11.2c-1.8-1.5-4-2.5-6.5-2.8 1.5 3 4 5.3 7 6.3 3-1 5.5-3.3 7-6.3-2.5.3-4.7 1.3-6.5 2.8z"/>
            </svg>
            <span class="text-xs font-bold tracking-wider uppercase text-white/70">Tesla</span>
          </div>

          <!-- BYD -->
          <div class="px-5 py-4 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-2 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group">
            <svg class="h-8 w-8 text-white group-hover:text-brand-green transition-colors" viewBox="0 0 24 24" fill="currentColor">
              <path d="M2 9h4c1.5 0 2.5.5 2.5 1.8 0 1-.7 1.5-1.7 1.6 1.2.1 2 .7 2 1.8 0 1.3-1 1.8-2.6 1.8H2V9zm2.2 2.2v1.1h1.5c.5 0 .8-.2.8-.5 0-.4-.3-.6-.8-.6H4.2zm0 2.2v1.2h1.7c.5 0 .8-.2.8-.6s-.3-.6-.8-.6H4.2zM9.5 9l2 3.2L13.5 9h2.5L13.2 12.8v3.2h-2.2v-3.2L8.2 9h1.3zm7 0h3c1.8 0 3.2 1.2 3.2 3.5s-1.4 3.5-3.2 3.5h-3V9zm2.2 2.2v2.6h.8c.8 0 1.2-.4 1.2-1.3s-.4-1.3-1.2-1.3h-.8z"/>
            </svg>
            <span class="text-xs font-bold tracking-wider uppercase text-white/70">BYD</span>
          </div>

          <!-- GWM -->
          <div class="px-5 py-4 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-2 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group">
            <svg class="h-8 w-8 text-white group-hover:text-brand-green transition-colors" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2L2 9h4v6H2l10 7 10-7h-4V9h4L12 2zm-2.5 9.5h5v2h-5v-2z"/>
            </svg>
            <span class="text-xs font-bold tracking-wider uppercase text-white/70">GWM</span>
          </div>

          <!-- Volvo -->
          <div class="px-5 py-4 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-2 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group">
            <svg class="h-8 w-8 text-white group-hover:text-brand-green transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="13" r="6"/>
              <line x1="15" y1="9" x2="20" y2="4"/>
              <polyline points="15 4 20 4 20 9"/>
            </svg>
            <span class="text-xs font-bold tracking-wider uppercase text-white/70">Volvo</span>
          </div>

          <!-- Geely -->
          <div class="px-5 py-4 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-2 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group">
            <svg class="h-8 w-8 text-white group-hover:text-brand-green transition-colors" viewBox="0 0 24 24" fill="currentColor">
              <path d="M3 5h8v6H3V5zm10 0h8v6h-8V5zM3 13h8v6H3v-6zm10 0h8v6h-8v-6z"/>
            </svg>
            <span class="text-xs font-bold tracking-wider uppercase text-white/70">Geely / Zeekr</span>
          </div>

          <!-- Porsche -->
          <div class="px-5 py-4 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-2 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group">
            <svg class="h-8 w-8 text-white group-hover:text-brand-green transition-colors" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 17v-4c-2.76 0-5-2.24-5-5h5V6l6 6-6 6z"/>
            </svg>
            <span class="text-xs font-bold tracking-wider uppercase text-white/70">Porsche</span>
          </div>

          <!-- BMW -->
          <div class="px-5 py-4 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-2 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group">
            <svg class="h-8 w-8 text-white group-hover:text-brand-green transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="9"/>
              <path d="M12 3v18M3 12h18"/>
            </svg>
            <span class="text-xs font-bold tracking-wider uppercase text-white/70">BMW</span>
          </div>

          <!-- Audi -->
          <div class="px-5 py-4 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-2 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group">
            <svg class="h-8 w-12 text-white group-hover:text-brand-green transition-colors" viewBox="0 0 24 12" fill="none" stroke="currentColor" stroke-width="1.8">
              <circle cx="4" cy="6" r="3.5"/>
              <circle cx="9.3" cy="6" r="3.5"/>
              <circle cx="14.6" cy="6" r="3.5"/>
              <circle cx="20" cy="6" r="3.5"/>
            </svg>
            <span class="text-xs font-bold tracking-wider uppercase text-white/70">Audi</span>
          </div>

          <!-- Mercedes-Benz -->
          <div class="px-5 py-4 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-2 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group">
            <svg class="h-8 w-8 text-white group-hover:text-brand-green transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="9"/>
              <path d="M12 3v9M12 12l6 6M12 12l-6 6"/>
            </svg>
            <span class="text-xs font-bold tracking-wider uppercase text-white/70">Mercedes-Benz</span>
          </div>

          <!-- Chevrolet -->
          <div class="px-5 py-4 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-2 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group">
            <svg class="h-8 w-8 text-white group-hover:text-brand-green transition-colors" viewBox="0 0 24 24" fill="currentColor">
              <path d="M7 10h3V7h4v3h3v4h-3v3h-4v-3H7v-4z"/>
            </svg>
            <span class="text-xs font-bold tracking-wider uppercase text-white/70">Chevrolet</span>
          </div>
        </div>
      </div>

      <!-- Filtros (Tabs) -->
      <div id="portfolio-tabs-expandido" class="flex flex-wrap items-center justify-center gap-2 mb-10 observe">
        <button data-filter="all" class="portfolio-tab-btn px-4 py-2.5 text-xs font-bold rounded-xl border border-brand-green bg-brand-green text-brand-bg transition-all uppercase tracking-wider">
          Todos
        </button>
        <button data-filter="byd" class="portfolio-tab-btn px-4 py-2.5 text-xs font-bold rounded-xl border border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">
          BYD
        </button>
        <button data-filter="gwm" class="portfolio-tab-btn px-4 py-2.5 text-xs font-bold rounded-xl border border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">
          GWM
        </button>
        <button data-filter="volvo" class="portfolio-tab-btn px-4 py-2.5 text-xs font-bold rounded-xl border border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">
          Volvo
        </button>
        <button data-filter="geely" class="portfolio-tab-btn px-4 py-2.5 text-xs font-bold rounded-xl border border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">
          Geely (Zeekr/Volvo)
        </button>
        <button data-filter="porsche" class="portfolio-tab-btn px-4 py-2.5 text-xs font-bold rounded-xl border border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">
          Porsche
        </button>
        <button data-filter="tesla" class="portfolio-tab-btn px-4 py-2.5 text-xs font-bold rounded-xl border border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">
          Tesla
        </button>
        <button data-filter="bmw" class="portfolio-tab-btn px-4 py-2.5 text-xs font-bold rounded-xl border border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">
          BMW
        </button>
        <button data-filter="audi" class="portfolio-tab-btn px-4 py-2.5 text-xs font-bold rounded-xl border border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">
          Audi & Outras
        </button>
      </div>

      <!-- Portfolio Grid -->
      <div id="portfolio-grid-expandido" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 observe">
        <!-- Injetado dinamicamente via JS -->
      </div>

    </div>
  </main>

  <!-- CTA ÁREA -->
  <section class="relative bg-brand-bg3 py-20 px-6 border-t border-white/5 overflow-hidden observe">
    <div class="max-w-[800px] mx-auto text-center relative z-10">
      <h2 class="text-3xl font-extrabold tracking-tight mb-6">
        Precisa homologar um carregador para sua montadora?
      </h2>
      <p class="text-brand-muted text-base leading-relaxed mb-8">
        Fale com nosso time de engenharia para realizar a instalação segura do carregador na sua residência ou condomínio, com documentação completa.
      </p>
      <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer"
        class="inline-flex items-center gap-2 bg-brand-green text-brand-bg font-extrabold px-8 py-4 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
        Conversar no WhatsApp
      </a>
    </div>
  </section>

<?php
include "includes/footer.php";
?>
