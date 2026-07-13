<?php
require_once "includes/db.php";
$page_title = "Estações de Recarga Comercial e Eletropostos — VoltchZ Brasil";
$page_desc = "Implementação de carregadores rápidos comerciais, carregamento pago (monetização) e soluções para frotas corporativas, comércios, shoppings e hotéis.";
$current_page = "eletroposto";
include "includes/header.php";
?>

  <!-- HERO ELETROPOSTOS -->
  <header class="relative pt-32 pb-20 overflow-hidden bg-brand-bg2">
    <div class="absolute inset-0 opacity-20">
      <div class="orb w-[500px] h-[500px] -top-30 -right-30 bg-brand-green/20"></div>
    </div>
    <div class="max-w-[1200px] mx-auto px-6 relative z-10 text-center">
      <span class="inline-block px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono mb-5">
        Negócios & Mobilidade Urbana
      </span>
      <h1 class="text-[clamp(32px,5.5vw,56px)] font-extrabold leading-tight tracking-tighter mb-6 text-white">
        Estações de Recarga Comercial<br>
        <span class="text-brand-green">e Eletropostos Rápidos</span>
      </h1>
      <p class="text-lg text-brand-muted max-w-3xl mx-auto leading-relaxed">
        Carregamento público, corporativo e comercial. Atraia clientes de alto padrão para o seu negócio, crie uma nova fonte de receita monetizando as recargas ou eletrifique sua frota com máxima eficiência.
      </p>
    </div>
  </header>

  <!-- PILARES DE NEGÓCIOS -->
  <section class="py-20 px-6 bg-brand-bg relative z-10 border-t border-white/5">
    <div class="max-w-[1200px] mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- CARD 1 -->
        <div class="bg-white/[0.02] border border-white/5 p-8 rounded-3xl hover:border-brand-green/20 transition-all duration-300">
          <div class="w-12 h-12 rounded-2xl bg-brand-green/10 flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-brand-green" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          </div>
          <h3 class="text-lg font-bold text-white mb-3">Monetização por Aplicativo</h3>
          <p class="text-sm text-brand-muted leading-relaxed">
            Transforme suas vagas em fonte de receita recorrente. Oferecemos integração com sistemas de bilhetagem e pagamento, permitindo cobrar pela energia consumida diretamente via app.
          </p>
        </div>

        <!-- CARD 2 -->
        <div class="bg-white/[0.02] border border-white/5 p-8 rounded-3xl hover:border-brand-green/20 transition-all duration-300">
          <div class="w-12 h-12 rounded-2xl bg-brand-green/10 flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-brand-green" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
          </div>
          <h3 class="text-lg font-bold text-white mb-3">Fidelização e Atração</h3>
          <p class="text-sm text-brand-muted leading-relaxed">
            Motoristas de veículos elétricos preferem estabelecimentos comerciais que disponibilizam pontos de recarga de confiança. Aumente o ticket médio e o tempo de permanência de clientes qualificados.
          </p>
        </div>

        <!-- CARD 3 -->
        <div class="bg-white/[0.02] border border-white/5 p-8 rounded-3xl hover:border-brand-green/20 transition-all duration-300">
          <div class="w-12 h-12 rounded-2xl bg-brand-green/10 flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-brand-green" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10M21 16V10a2 2 0 00-2-2h-3V5M16 8h3.293a1 1 0 01.707.293L21 9.293"></path></svg>
          </div>
          <h3 class="text-lg font-bold text-white mb-3">Eletrificação de Frotas</h3>
          <p class="text-sm text-brand-muted leading-relaxed">
            Infraestrutura de recarga AC e DC dimensionada especificamente para frotas corporativas. Sistemas de gerenciamento com controle de acesso (RFID/App) para máxima economia.
          </p>
        </div>

      </div>
    </div>
  </section>

  <!-- PORTFÓLIO DE ELETROPOSTOS -->
  <section class="py-16 px-6 bg-brand-bg relative z-10 border-t border-white/5">
    <div class="max-w-[1200px] mx-auto">
      <div class="text-center max-w-2xl mx-auto mb-16">
        <span class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green/60 block mb-2">Projetos Executados</span>
        <h2 class="text-3xl font-extrabold text-white">Nossas Instalações Comerciais</h2>
        <p class="text-sm text-brand-muted mt-3">Confira os eletropostos e recargas corporativas homologadas pela VoltchZ Brasil.</p>
      </div>

      <!-- Grid de Projetos -->
      <div id="eletropostos-grid-page" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Injetado via JS -->
      </div>
    </div>
  </section>

  <!-- ENCONTRE UM ELETROPOSTO (MAPA INTERATIVO) -->
  <section class="py-16 px-6 bg-brand-bg2 relative z-10 border-t border-white/5">
    <div class="max-w-[1000px] mx-auto">
      <div class="text-center max-w-2xl mx-auto mb-12">
        <span class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green/60 block mb-2">Mobilidade em Tempo Real</span>
        <h2 class="text-3xl font-extrabold text-white">Encontre um Eletroposto Próximo</h2>
        <p class="text-sm text-brand-muted mt-3">Localize pontos de recarga em tempo real utilizando o mapa interativo integrado abaixo.</p>
      </div>

      <div class="bg-white/[0.03] border border-white/10 rounded-[32px] p-4 md:p-6 backdrop-blur-xl shadow-2xl shadow-brand-green/5">
        <div class="relative w-full aspect-video md:h-[550px] rounded-2xl overflow-hidden border border-white/10 bg-brand-bg3 shadow-2xl">
          <iframe src="https://www.plugshare.com/widget2.html?plugs=1,2,3,4,5,6,42,13,7,8,9,10,11,12,14,15,16,17"
            width="100%" height="100%" style="border:0;" allow="geolocation" title="Mapa PlugShare">
          </iframe>
        </div>

        <div class="mt-4 text-[10px] text-brand-muted font-mono uppercase tracking-[0.2em] text-center">
          Mapa interativo alimentado por PlugShare™
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
          <a href="https://www.plugshare.com/" target="_blank" rel="noopener noreferrer"
            class="group p-4 rounded-2xl border border-white/5 bg-white/[0.01] hover:bg-white/[0.04] transition-all flex items-start gap-4">
            <div class="p-2 rounded-lg bg-brand-green/10 text-brand-green group-hover:bg-brand-green group-hover:text-brand-bg transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
              </svg>
            </div>
            <div>
              <span class="block text-white font-bold mb-1 text-sm">Abrir PlugShare</span>
              <span class="text-xs text-brand-muted">Acesse a plataforma completa com filtros avançados e avaliações.</span>
            </div>
          </a>
          <a href="https://www.google.com/maps/search/eletroposto/" target="_blank" rel="noopener noreferrer"
            class="group p-4 rounded-2xl border border-white/5 bg-white/[0.01] hover:bg-white/[0.04] transition-all flex items-start gap-4">
            <div class="p-2 rounded-lg bg-blue-500/10 text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <div>
              <span class="block text-white font-bold mb-1 text-sm">Google Maps</span>
              <span class="text-xs text-brand-muted">Utilize a navegação nativa do Google para chegar ao eletroposto mais próximo.</span>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA ÁREA -->
  <section class="relative bg-brand-bg3 py-20 px-6 border-t border-white/5 overflow-hidden z-10">
    <div class="max-w-[800px] mx-auto text-center relative z-10">
      <h2 class="text-3xl font-extrabold tracking-tight mb-6">
        Quer implantar um eletroposto no seu negócio?
      </h2>
      <p class="text-brand-muted text-base leading-relaxed mb-8 font-normal">
        A VoltchZ Brasil cuida de todo o processo: desde o dimensionamento elétrico da vaga, escolha de carregador rápido (DC) ou semirrápido (AC), homologação comercial e gerenciamento de software.
      </p>
      <a href="<?php echo htmlspecialchars(get_config('whatsapp_link', 'https://wa.me/5512981039845?text=Ola!%20Gostaria%20de%20um%20projeto%20de%20recarga%20veicular%20para%20minha%20empresa%20/%20eletroposto.')); ?>" target="_blank" rel="noopener noreferrer"
        class="inline-flex items-center gap-2 bg-brand-green text-brand-bg font-extrabold px-8 py-4 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
        Desenhar Eletroposto Comercial
      </a>
    </div>
  </section>

<?php
$raw_images = array_merge(
    glob('static/clientes/*.{webp,png,jpg,jpeg,gif}', GLOB_BRACE) ?: [],
    glob('static/uploads/*.{webp,png,jpg,jpeg,gif}', GLOB_BRACE) ?: []
);
$existing_images = array_map(function($path) {
    return str_replace('\\', '/', $path);
}, $raw_images);
?>

<script>
    const EXISTING_IMAGES = <?php echo json_encode($existing_images); ?>;
    const DB_PORTFOLIO = <?php echo json_encode(get_portfolio_items()); ?>;

    document.addEventListener("DOMContentLoaded", () => {
        const grid = document.getElementById("eletropostos-grid-page");
        if (!grid) return;

        const portfolioData = DB_PORTFOLIO.map(item => ({
            tipo: item.tipo || (item.brand === 'condominio' ? 'condominio' : 'veiculo'),
            brand: item.brand,
            model: item.model,
            location: item.location,
            desc: item.description,
            image: item.image
        }));

        const filtered = portfolioData.filter(item => {
            return item.tipo === 'eletroposto' && item.image;
        });

        if (filtered.length === 0) {
            grid.innerHTML = `
                <div class="col-span-full text-center py-16 bg-white/[0.02] border border-white/5 border-dashed rounded-3xl">
                    <p class="text-brand-muted text-sm italic">Nenhum projeto de eletroposto cadastrado no momento.</p>
                </div>
            `;
            return;
        }

        filtered.forEach(item => {
            const card = document.createElement('div');
            card.className = 'group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[24px] overflow-hidden flex flex-col p-4 backdrop-blur-xl shadow-2xl transition-all duration-300 hover:-translate-y-1.5';
            
            const imgs = item.image.split(',').map(s => s.trim()).filter(Boolean);
            const hasMultiple = imgs.length > 1;
            const firstImg = imgs[0] || '';

            let imageHtml = '';
            if (hasMultiple) {
                imageHtml = `
                <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden bg-brand-bg mb-4 border border-white/5 group/carousel">
                    <div class="carousel-images-container w-full h-full flex transition-transform duration-300">
                        ${imgs.map((src, i) => `
                            <div class="w-full h-full flex-shrink-0 cursor-pointer relative" onclick="window.dispatchEvent(new CustomEvent('open-lightbox', { detail: { src: '${src}' } }))">
                                <img src="${src}" onerror="this.src='static/logo.webp'; this.classList.add('object-contain', 'p-6')" alt="Instalação ${item.model} - Foto ${i+1}" class="w-full h-full object-cover">
                            </div>
                        `).join('')}
                    </div>
                    <button type="button" class="carousel-prev-btn absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/60 hover:bg-black/80 text-white flex items-center justify-center border border-white/10 opacity-0 group-hover/carousel:opacity-100 transition-opacity z-20 cursor-pointer" onclick="event.stopPropagation();">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"></path></svg>
                    </button>
                    <button type="button" class="carousel-next-btn absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/60 hover:bg-black/80 text-white flex items-center justify-center border border-white/10 opacity-0 group-hover/carousel:opacity-100 transition-opacity z-20 cursor-pointer" onclick="event.stopPropagation();">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path></svg>
                    </button>
                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 z-20 bg-black/30 px-2 py-1 rounded-full backdrop-blur-md border border-white/5">
                        ${imgs.map((_, i) => `
                            <span class="carousel-indicator w-1.5 h-1.5 rounded-full bg-white/45 transition-all ${i === 0 ? 'bg-brand-green w-3' : ''}"></span>
                        `).join('')}
                    </div>
                </div>
                `;
            } else {
                imageHtml = `
                <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden bg-brand-bg mb-4 border border-white/5 flex items-center justify-center cursor-pointer" onclick="window.dispatchEvent(new CustomEvent('open-lightbox', { detail: { src: '${firstImg}' } }))">
                    <img src="${firstImg}" onerror="this.src='static/logo.webp'; this.classList.add('object-contain', 'p-6')" alt="Instalação ${item.model}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="bg-white/90 text-black text-xs font-bold px-4 py-2 rounded-xl shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-transform">Ampliar Foto</span>
                    </div>
                </div>
                `;
            }

            card.innerHTML = `
                ${imageHtml}
                <div class="flex-grow flex flex-col">
                    <div class="flex items-center justify-between gap-4 mb-2">
                        <span class="text-[9px] font-mono font-black uppercase tracking-[0.2em] text-brand-green">ELETROPOSTO</span>
                        <span class="text-[9px] font-mono text-white/45 truncate max-w-[150px]">${item.location.split(',')[0]}</span>
                    </div>
                    <h3 class="text-base font-bold text-white mb-2 leading-snug group-hover:text-brand-green transition-colors">${item.model}</h3>
                    <p class="text-brand-muted text-[12px] leading-relaxed mb-2 flex-grow">${item.desc}</p>
                    <div class="text-[10px] text-white/40 flex items-center gap-1.5 mt-auto pt-2 border-t border-white/5">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" /><circle cx="12" cy="10" r="3" /></svg>
                        <span class="truncate">${item.location}</span>
                    </div>
                </div>
            `;

            grid.appendChild(card);

            if (hasMultiple) {
                let activeIdx = 0;
                const container = card.querySelector('.carousel-images-container');
                const indicators = card.querySelectorAll('.carousel-indicator');
                const prevBtn = card.querySelector('.carousel-prev-btn');
                const nextBtn = card.querySelector('.carousel-next-btn');

                const updateCarousel = () => {
                    container.style.transform = `translateX(-${activeIdx * 100}%)`;
                    indicators.forEach((ind, i) => {
                        if (i === activeIdx) {
                            ind.classList.add('bg-brand-green', 'w-3');
                            ind.classList.remove('bg-white/40');
                        } else {
                            ind.classList.remove('bg-brand-green', 'w-3');
                            ind.classList.add('bg-white/40');
                        }
                    });
                };

                prevBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    activeIdx = (activeIdx === 0) ? imgs.length - 1 : activeIdx - 1;
                    updateCarousel();
                });

                nextBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    activeIdx = (activeIdx === imgs.length - 1) ? 0 : activeIdx + 1;
                    updateCarousel();
                });
            }
        });
    });
</script>

<?php
include "includes/footer.php";
?>
