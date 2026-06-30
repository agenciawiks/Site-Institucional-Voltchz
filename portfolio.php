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
  <main class="py-12 px-6 bg-brand-bg relative min-h-[60vh] z-10 font-outfit">
    <div class="max-w-[1200px] mx-auto">

      <!-- Master Tabs Navigation -->
      <div class="flex justify-center border-b border-white/5 mb-16 max-w-xl mx-auto">
        <button id="master-tab-veiculos" onclick="switchMasterTab('veiculos')" class="flex-1 pb-4 text-center font-bold text-sm tracking-wider uppercase border-b-2 border-brand-green text-white transition-all focus:outline-none">
          Por Montadora (Veículos)
        </button>
        <button id="master-tab-condominios" onclick="switchMasterTab('condominios')" class="flex-1 pb-4 text-center font-bold text-sm tracking-wider uppercase border-b-2 border-transparent text-brand-muted hover:text-white transition-all focus:outline-none">
          Em Condomínios (Infraestrutura)
        </button>
      </div>

      <!-- SEÇÃO MONTADORAS (VEÍCULOS) -->
      <div id="section-veiculos" class="space-y-12">
        <!-- Logos Grid: Marcas com Eletromobilidade Homologada -->
        <div class="mb-16 observe">
          <p class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green/60 text-center mb-8">Compatibilidade e Homologação Garantida</p>
          
          <style>
          @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
          }
          .marquee-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            padding: 1.5rem 0;
          }
          /* Mask gradient fade on sides to look premium */
          .marquee-container::before,
          .marquee-container::after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            width: 120px;
            z-index: 10;
            pointer-events: none;
          }
          .marquee-container::before {
            left: 0;
            background: linear-gradient(to right, #090D14 10%, transparent 100%);
          }
          .marquee-container::after {
            right: 0;
            background: linear-gradient(to left, #090D14 10%, transparent 100%);
          }
          .marquee-track {
            display: flex;
            gap: 1.5rem; /* gap-6 */
            width: max-content;
            animation: marquee 90s linear infinite;
          }
          .marquee-track:hover {
            animation-play-state: paused;
          }
          </style>

          <?php
          $marcas_json_path = 'static/logos-marcas/marcas.json';
          $valid_marcas = [];
          if (file_exists($marcas_json_path)) {
              $marcas_data = json_decode(file_get_contents($marcas_json_path), true);
              if (is_array($marcas_data)) {
                  foreach ($marcas_data as $marca) {
                      $file_path = 'static/logos-marcas/' . $marca['arquivo'];
                      if (file_exists($file_path)) {
                          $valid_marcas[] = $marca;
                      }
                  }
              }
          }
          ?>

          <div class="marquee-container">
            <div class="marquee-track">
              <?php
              if (!empty($valid_marcas)) {
                  // Print twice for seamless infinite scrolling loop
                  for ($loop = 0; $loop < 2; $loop++) {
                      foreach ($valid_marcas as $marca) {
                          $nome = htmlspecialchars($marca['nome']);
                          $arquivo = htmlspecialchars($marca['arquivo']);
                          $file_path = 'static/logos-marcas/' . $arquivo;
                          ?>
                          <div class="relative shrink-0 w-44 h-28 rounded-2xl bg-white/[0.02] border border-white/5 flex flex-col items-center justify-center hover:border-brand-green/30 hover:bg-white/[0.04] transition-all group overflow-hidden" title="<?php echo $nome; ?>">
                            <img src="<?php echo $file_path; ?>" class="h-10 w-auto max-w-[80%] object-contain opacity-70 group-hover:opacity-100 group-hover:-translate-y-2 transition-all duration-300 filter invert brightness-200" alt="<?php echo $nome; ?>">
                            <span class="absolute bottom-3 left-2 right-2 text-[10px] font-bold tracking-wider uppercase text-brand-green opacity-0 group-hover:opacity-100 translate-y-1 group-hover:translate-y-0 transition-all duration-300 text-center truncate"><?php echo $nome; ?></span>
                          </div>
                          <?php
                      }
                  }
              }
              ?>
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

      <!-- SEÇÃO CONDOMÍNIOS -->
      <div id="section-condominios" class="hidden space-y-12">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <h2 class="text-3xl font-extrabold text-white mb-3">Infraestrutura Coletiva em Edifícios</h2>
          <p class="text-sm text-brand-muted">Projetos elétricos condomíniais homologados, adequação técnica de prumadas elétricas, barramentos blindados e recarga inteligente com balanceamento de carga.</p>
        </div>

        <!-- Condominios Grid -->
        <div id="condominios-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 observe">
          <!-- Injetado dinamicamente via JS -->
        </div>
      </div>

    </div>
  </main>

  <script>
      function switchMasterTab(type) {
          const btnVeiculos = document.getElementById('master-tab-veiculos');
          const btnCondos = document.getElementById('master-tab-condominios');
          const secVeiculos = document.getElementById('section-veiculos');
          const secCondos = document.getElementById('section-condominios');
          
          if (type === 'veiculos') {
              btnVeiculos.classList.add('border-brand-green', 'text-white');
              btnVeiculos.classList.remove('border-transparent', 'text-brand-muted');
              btnCondos.classList.remove('border-brand-green', 'text-white');
              btnCondos.classList.add('border-transparent', 'text-brand-muted');
              
              secVeiculos.classList.remove('hidden');
              secCondos.classList.add('hidden');
          } else {
              btnCondos.classList.add('border-brand-green', 'text-white');
              btnCondos.classList.remove('border-transparent', 'text-brand-muted');
              btnVeiculos.classList.remove('border-brand-green', 'text-white');
              btnVeiculos.classList.add('border-transparent', 'text-brand-muted');
              
              secCondos.classList.remove('hidden');
              secVeiculos.classList.add('hidden');
          }
      }
  </script>

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
// Escaneia as pastas de clientes e uploads dinamicamente e normaliza barras no Windows
$raw_images = array_merge(
    glob('static/clientes/*.{webp,png,jpg,jpeg,gif}', GLOB_BRACE) ?: [],
    glob('static/uploads/*.{webp,png,jpg,jpeg,gif}', GLOB_BRACE) ?: []
);
$existing_images = array_map(function($path) {
    return str_replace('\\', '/', $path);
}, $raw_images);
?>
<script>
    window.VOLTCHZ_EXISTING_IMAGES = <?php echo json_encode($existing_images); ?>;
    window.VOLTCHZ_PORTFOLIO_DB_DATA = <?php echo json_encode(get_portfolio_items()); ?>;
</script>

<?php
include "includes/footer.php";
?>
