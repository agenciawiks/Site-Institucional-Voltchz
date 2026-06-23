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
        Explore nossa galeria de instalações de carregadores e quadros de segurança feitas para cada fabricante, certificando compatibilidade absoluta e engenharia de alto padrão.
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
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 max-w-6xl mx-auto">
          <!-- BYD -->
          <div class="px-5 py-6 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-3 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group min-h-[140px]">
            <img src="static/logos-marcas/byd.webp" class="h-14 w-auto max-w-[90%] object-contain opacity-85 group-hover:opacity-100 transition-opacity" alt="BYD">
            <span class="text-[10px] font-bold tracking-wider uppercase text-white/50 group-hover:text-brand-green transition-colors">BYD</span>
          </div>

          <!-- BMW -->
          <div class="px-5 py-6 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-3 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group min-h-[140px]">
            <img src="static/logos-marcas/bmw.webp" class="h-14 w-auto max-w-[90%] object-contain opacity-85 group-hover:opacity-100 transition-opacity" alt="BMW">
            <span class="text-[10px] font-bold tracking-wider uppercase text-white/50 group-hover:text-brand-green transition-colors">BMW</span>
          </div>


          <!-- Tesla -->
          <div class="px-5 py-6 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-3 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group min-h-[140px]">
            <img src="static/logos-marcas/tesla.webp" class="h-12 w-auto max-w-[90%] object-contain opacity-85 group-hover:opacity-100 transition-opacity" alt="Tesla">
            <span class="text-[10px] font-bold tracking-wider uppercase text-white/50 group-hover:text-brand-green transition-colors">Tesla</span>
          </div>

          <!-- Volvo -->
          <div class="px-5 py-6 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-3 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group min-h-[140px]">
            <img src="static/logos-marcas/volvo.webp" class="h-12 w-auto max-w-[90%] object-contain opacity-85 group-hover:opacity-100 transition-opacity" alt="Volvo">
            <span class="text-[10px] font-bold tracking-wider uppercase text-white/50 group-hover:text-brand-green transition-colors">Volvo</span>
          </div>

          <!-- Geely -->
          <div class="px-5 py-6 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-3 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group min-h-[140px]">
            <img src="static/logos-marcas/geely.webp" class="h-12 w-auto max-w-[90%] object-contain opacity-85 group-hover:opacity-100 transition-opacity" alt="Geely">
            <span class="text-[10px] font-bold tracking-wider uppercase text-white/50 group-hover:text-brand-green transition-colors">Geely</span>
          </div>

          <!-- Porsche -->
          <div class="px-5 py-6 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-3 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group min-h-[140px]">
            <img src="static/logos-marcas/porsche.webp" class="h-12 w-auto max-w-[90%] object-contain opacity-85 group-hover:opacity-100 transition-opacity" alt="Porsche">
            <span class="text-[10px] font-bold tracking-wider uppercase text-white/50 group-hover:text-brand-green transition-colors">Porsche</span>
          </div>

          <!-- Audi -->
          <div class="px-5 py-6 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center gap-3 hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group min-h-[140px]">
            <img src="static/logos-marcas/audi.webp" class="h-12 w-auto max-w-[90%] object-contain opacity-85 group-hover:opacity-100 transition-opacity" alt="Audi">
            <span class="text-[10px] font-bold tracking-wider uppercase text-white/50 group-hover:text-brand-green transition-colors">Audi</span>
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
      <a href="<?php echo htmlspecialchars(get_config('whatsapp_link', 'https://wa.me/5512981039845')); ?>" target="_blank" rel="noopener noreferrer"
        class="inline-flex items-center gap-2 bg-brand-green text-brand-bg font-extrabold px-8 py-4 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
        Conversar no WhatsApp
      </a>
    </div>
  </section>

<?php
// Escaneia as pastas de clientes e uploads dinamicamente
$existing_images = array_merge(
    glob('static/clientes/*.{webp,png,jpg,jpeg,gif}', GLOB_BRACE) ?: [],
    glob('static/uploads/*.{webp,png,jpg,jpeg,gif}', GLOB_BRACE) ?: []
);
?>
<script>
    window.VOLTCHZ_EXISTING_IMAGES = <?php echo json_encode($existing_images); ?>;
    window.VOLTCHZ_PORTFOLIO_DB_DATA = <?php echo json_encode(get_portfolio_items()); ?>;
</script>

<?php
include "includes/footer.php";
?>
