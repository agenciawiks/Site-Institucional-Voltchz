<?php
require_once "includes/db.php";
$page_title = "Instalações de Carregadores Residenciais — VoltchZ Brasil";
$page_desc = "Veja nosso portfólio de instalações de carregadores residenciais de carros elétricos. Homologados para BYD, GWM, Volvo, Porsche, Tesla e mais.";
$current_page = "portfolio";
include "includes/header.php";
?>

  <!-- ──────────────────────────────────────────
       HERO PORTFÓLIO RESIDENCIAL
  ────────────────────────────────────────── -->
  <header class="relative pt-32 pb-16 overflow-hidden bg-brand-bg2">
    <div class="absolute inset-0 opacity-20">
      <div class="orb w-[500px] h-[500px] -top-30 -right-30 bg-brand-green/20"></div>
    </div>
    <div class="max-w-[1200px] mx-auto px-6 relative z-10 text-center">
      <span
        class="inline-block px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono mb-5">
        Carregamento Residencial VoltchZ
      </span>
      <h1 class="text-[clamp(34px,7vw,64px)] font-extrabold leading-tight tracking-tighter mb-6">
        Instalações Homologadas<br>
        <span class="text-brand-green">por Montadora</span>
      </h1>
      <p class="text-lg text-brand-muted max-w-3xl mx-auto leading-relaxed">
        Explore nossa galeria de instalações residenciais de carregadores e quadros de segurança feitas para cada montadora, garantindo compatibilidade absoluta e engenharia de alto padrão.
      </p>
    </div>
  </header>

  <!-- ──────────────────────────────────────────
       CORPO PRINCIPAL (LOGOS, FILTROS E GRID)
  ────────────────────────────────────────── -->
  <main class="py-12 px-6 bg-brand-bg relative min-h-[60vh] z-10 font-outfit">
    <div class="max-w-[1200px] mx-auto">

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
                      $arquivo = $marca['arquivo'];
                      $file_path = (strpos($arquivo, '/') !== false) ? $arquivo : 'static/logos-marcas/' . $arquivo;
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
                          $file_path = (strpos($arquivo, '/') !== false) ? $arquivo : 'static/logos-marcas/' . $arquivo;
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
          <?php 
          $portfolio_items = get_portfolio_items();
          if (empty($portfolio_items)) {
              $portfolio_items = [
                  [
                      'id' => 1,
                      'tipo' => 'veiculo',
                      'brand' => 'byd',
                      'model' => 'BYD Dolphin',
                      'location' => 'Condomínio Alphaville, São José dos Campos',
                      'description' => 'Instalação de Wallbox de 7.4 kW com Quadro de Proteção E-Wolf e infraestrutura dedicada.',
                      'image' => 'static/clientes/cliente-5.webp'
                  ],
                  [
                      'id' => 2,
                      'tipo' => 'veiculo',
                      'brand' => 'byd',
                      'model' => 'BYD Song Plus',
                      'location' => 'Residencial Jardim Aquarius, SJC',
                      'description' => 'Recarga inteligente AC com balanceamento local de carga e proteção contra surtos.',
                      'image' => 'static/clientes/cliente-12.webp'
                  ],
                  [
                      'id' => 3,
                      'tipo' => 'veiculo',
                      'brand' => 'byd',
                      'model' => 'BYD Seal',
                      'location' => 'Condomínio Urbanova, SJC',
                      'description' => 'Instalação de carregador de alta performance de 22 kW trifásico E-Wolf.',
                      'image' => 'static/clientes/cliente-20.webp'
                  ],
                  [
                      'id' => 4,
                      'tipo' => 'veiculo',
                      'brand' => 'gwm',
                      'model' => 'GWM Ora 03',
                      'location' => 'Condomínio Esplanada, SJC',
                      'description' => 'Infraestrutura executada com cabeamento blindado de alta bitola e proteção DR Tipo A.',
                      'image' => 'static/clientes/cliente-11.webp'
                  ],
                  [
                      'id' => 5,
                      'tipo' => 'veiculo',
                      'brand' => 'gwm',
                      'model' => 'GWM Haval H6',
                      'location' => 'Taubaté, SP',
                      'description' => 'Quadro de proteção E-Wolf 7.2 kW instalado integrado com Wallbox original GWM.',
                      'image' => 'static/clientes/cliente-15.webp'
                  ],
                  [
                      'id' => 6,
                      'tipo' => 'veiculo',
                      'brand' => 'volvo',
                      'model' => 'Volvo XC40 Recharge',
                      'location' => 'Condomínio Bosque Imperial, SJC',
                      'description' => 'Recarga rápida e segura de 11 kW com dispositivo DR Tipo A de segurança e aterramento dedicado.',
                      'image' => 'static/clientes/cliente-25.webp'
                  ],
                  [
                      'id' => 7,
                      'tipo' => 'veiculo',
                      'brand' => 'volvo',
                      'model' => 'Volvo EX30',
                      'location' => 'Residencial Altos da Serra, SJC',
                      'description' => 'Compacto e eficiente, carregador instalado em pedestal de alumínio VoltchZ.',
                      'image' => 'static/clientes/cliente-32.webp'
                  ],
                  [
                      'id' => 8,
                      'tipo' => 'veiculo',
                      'brand' => 'geely',
                      'model' => 'Zeekr 001 (Geely Group)',
                      'location' => 'Condomínio Quinta das Flores, SJC',
                      'description' => 'Instalação homologada premium para o esportivo da Zeekr, utilizando quadro trifásico E-Wolf.',
                      'image' => 'static/clientes/cliente-40.webp'
                  ],
                  [
                      'id' => 9,
                      'tipo' => 'veiculo',
                      'brand' => 'geely',
                      'model' => 'Volvo C40 (Geely Group)',
                      'location' => 'Alphaville Industrial, Barueri',
                      'description' => 'Instalação de carregamento integrado ao sistema de automação residencial e geração solar.',
                      'image' => 'static/clientes/cliente-46.webp'
                  ],
                  [
                      'id' => 10,
                      'tipo' => 'veiculo',
                      'brand' => 'geely',
                      'model' => 'Zeekr X (Geely Group)',
                      'location' => 'São Paulo, SP',
                      'description' => 'Carregador Wallbox inteligente de 22 kW com leitor NFC e cabeamento embutido.',
                      'image' => 'static/clientes/cliente-55.webp'
                  ],
                  [
                      'id' => 11,
                      'tipo' => 'veiculo',
                      'brand' => 'porsche',
                      'model' => 'Porsche Taycan',
                      'location' => 'Condomínio Mônaco, Jacareí',
                      'description' => 'Instalação trifásica premium de 22 kW com dupla proteção de aterramento e DPS classe II.',
                      'image' => 'static/clientes/cliente-10.webp'
                  ],
                  [
                      'id' => 12,
                      'tipo' => 'veiculo',
                      'brand' => 'tesla',
                      'model' => 'Tesla Model Y',
                      'location' => 'Jardim das Colinas, SJC',
                      'description' => 'Carregador original Tesla Wall Connector integrado com proteção avançada E-Wolf.',
                      'image' => 'static/clientes/cliente-2.webp'
                  ],
                  [
                      'id' => 13,
                      'tipo' => 'veiculo',
                      'brand' => 'bmw',
                      'model' => 'BMW iX',
                      'location' => 'Valinhos, SP',
                      'description' => 'Recarga trifásica de alta potência, com quadro de segurança tetrapolar e DR Tipo A.',
                      'image' => 'static/clientes/cliente-18.webp'
                  ],
                  [
                      'id' => 14,
                      'tipo' => 'veiculo',
                      'brand' => 'audi',
                      'model' => 'Audi e-tron',
                      'location' => 'Jardim Aquarius, SJC',
                      'description' => 'Infraestrutura completa de recarga rápida instalada em vaga privativa de condomínio vertical.',
                      'image' => 'static/clientes/cliente-30.webp'
                  ],
                  [
                      'id' => 15,
                      'tipo' => 'condominio',
                      'brand' => 'condominio',
                      'model' => 'Infraestrutura Coletiva',
                      'location' => 'Condomínio Aquarius, SJC',
                      'description' => 'Instalação de barramento blindado e quadros de medição individualizada para 20 vagas de garagem.',
                      'image' => 'static/carregador-predio-estacionamento.webp'
                  ],
                  [
                      'id' => 16,
                      'tipo' => 'condominio',
                      'brand' => 'condominio',
                      'model' => 'Adequação Elétrica Coletiva',
                      'location' => 'Edifício Esplanada, SJC',
                      'description' => 'Projeto executivo e instalação de proteção contra incêndio e DPS tetrapolar para recarga coletiva.',
                      'image' => 'static/carregador-predio-estacionamento2.webp'
                  ]
              ];
          }

          foreach ($portfolio_items as $item): 
            $tipo = trim($item['tipo'] ?? '');
            if ($tipo === '') {
                $tipo = 'veiculo';
            }
            $tipo = strtolower($tipo);
            if ($tipo !== 'veiculo') continue;

            $imgs = array_filter(array_map('trim', explode(',', $item['image'] ?? '')));
            $hasMultiple = count($imgs) > 1;
            $firstImg = reset($imgs) ?: '';
            $brand = strtolower($item['brand']);
          ?>
            <div class="portfolio-card fade-item group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[24px] overflow-hidden flex flex-col p-4 shadow-2xl transition-all duration-300 hover:-translate-y-1.5"
                 data-brand="<?php echo htmlspecialchars($brand); ?>"
                 data-tipo="<?php echo htmlspecialchars($tipo); ?>">
              
              <?php if ($hasMultiple): ?>
                <!-- Carrossel de Imagens -->
                <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden bg-brand-bg mb-4 border border-white/5 group/carousel">
                    <div class="carousel-images-container w-full h-full flex transition-transform duration-300">
                        <?php foreach ($imgs as $i => $src): ?>
                            <div class="w-full h-full flex-shrink-0 cursor-pointer relative btn-open-lightbox" data-src="<?php echo htmlspecialchars($src); ?>">
                                <img src="<?php echo htmlspecialchars($src); ?>" onerror="this.src='static/logo.webp'; this.classList.add('object-contain', 'p-6')" alt="Instalação <?php echo htmlspecialchars($item['model']); ?> - Foto <?php echo $i+1; ?>" class="w-full h-full object-cover" loading="eager">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Setas de navegação -->
                    <button type="button" class="carousel-prev-btn absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/60 hover:bg-black/80 text-white flex items-center justify-center border border-white/10 opacity-0 group-hover/carousel:opacity-100 transition-opacity z-20 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"></path></svg>
                    </button>
                    <button type="button" class="carousel-next-btn absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/60 hover:bg-black/80 text-white flex items-center justify-center border border-white/10 opacity-0 group-hover/carousel:opacity-100 transition-opacity z-20 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path></svg>
                    </button>

                    <!-- Indicadores (bullets) -->
                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 z-20 bg-black/30 px-2 py-1 rounded-full backdrop-blur-md border border-white/5">
                        <?php foreach ($imgs as $i => $_): ?>
                            <span class="carousel-indicator w-1.5 h-1.5 rounded-full bg-white/45 transition-all <?php echo $i === 0 ? 'bg-brand-green w-3' : ''; ?>"></span>
                        <?php endforeach; ?>
                    </div>
                </div>
              <?php else: ?>
                <!-- Imagem Única -->
                <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden bg-brand-bg mb-4 border border-white/5 flex items-center justify-center cursor-pointer btn-open-lightbox" data-src="<?php echo htmlspecialchars($firstImg); ?>">
                    <img src="<?php echo htmlspecialchars($firstImg); ?>" onerror="this.src='static/logo.webp'; this.classList.add('object-contain', 'p-6')" alt="Instalação <?php echo htmlspecialchars($item['model']); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="eager">
                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="bg-white/90 text-black text-xs font-bold px-4 py-2 rounded-xl shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-transform">Ampliar Foto</span>
                    </div>
                </div>
              <?php endif; ?>

              <!-- Conteúdo -->
              <div class="flex-grow flex flex-col">
                  <div class="flex items-center justify-between gap-4 mb-2">
                      <span class="text-[9px] font-mono font-black uppercase tracking-[0.2em] text-brand-green">
                          <?php 
                            if ($tipo === 'condominio') {
                                echo 'CONDOMÍNIO';
                            } elseif ($tipo === 'construtora') {
                                echo 'CONSTRUTORA';
                            } else {
                                echo $brand === 'geely' ? 'GRUPO GEELY' : strtoupper($brand);
                            }
                          ?>
                      </span>
                      <span class="text-[9px] font-mono text-white/45 truncate max-w-[150px]">
                          <?php 
                            $loc_parts = explode(',', $item['location']);
                            echo htmlspecialchars(trim(reset($loc_parts))); 
                          ?>
                      </span>
                  </div>
                  
                  <h3 class="text-base font-bold text-white mb-2 leading-snug group-hover:text-brand-green transition-colors">
                      <?php echo htmlspecialchars($item['model']); ?>
                  </h3>
                  
                  <p class="text-brand-muted text-[12px] leading-relaxed mb-2 flex-grow">
                      <?php echo htmlspecialchars($item['description']); ?>
                  </p>
                  
                  <div class="text-[10px] text-white/40 flex items-center gap-1.5 mt-auto pt-2 border-t border-white/5">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                          <circle cx="12" cy="10" r="3" />
                      </svg>
                      <span class="truncate"><?php echo htmlspecialchars($item['location']); ?></span>
                  </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
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
include "includes/footer.php";
?>
