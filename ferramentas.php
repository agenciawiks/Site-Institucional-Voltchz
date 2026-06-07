<?php
$page_title = "Encontre um Eletroposto — VoltchZ Brasil";
$page_desc = "Encontre eletropostos próximos com a ferramenta da VoltchZ e planeje sua recarga com praticidade.";
$current_page = "ferramentas";
include "includes/header.php";
?>

  <header class="pt-32 pb-14 px-6 bg-brand-bg2 border-b border-white/5">
    <div class="max-w-[1200px] mx-auto text-center observe">
      <p class="text-[12px] font-mono font-bold uppercase tracking-[0.2em] text-brand-green mb-4">Encontre um Eletroposto</p>
      <h1 class="text-[clamp(34px,7vw,64px)] font-extrabold tracking-tight mb-6">Encontre um carregador</h1>
      <p class="text-brand-muted max-w-3xl mx-auto text-lg leading-relaxed">
        Localize pontos de recarga em tempo real utilizando dados abertos e geolocalização precisa.
      </p>
    </div>
  </header>

  <main class="py-20 px-6 bg-brand-bg">
    <div class="max-w-[900px] mx-auto">
      <section class="bg-white/[0.03] border border-white/10 rounded-[32px] p-6 md:p-8 backdrop-blur-xl shadow-2xl shadow-brand-green/5 observe">
        <div class="mb-6">
          <h3 class="text-xl font-bold mb-2">Mapa de Eletropostos</h3>
          <p class="text-brand-muted text-sm md:text-base max-w-md">
            Visualize os pontos de recarga próximos de você através da plataforma PlugShare.
          </p>
        </div>

        <div class="relative w-full aspect-video md:h-[650px] rounded-2xl overflow-hidden border border-white/10 bg-brand-bg3 shadow-2xl my-8">
          <iframe src="https://www.plugshare.com/widget2.html?plugs=1,2,3,4,5,6,42,13,7,8,9,10,11,12,14,15,16,17"
            width="100%" height="100%" style="border:0;" allow="geolocation" title="Mapa PlugShare">
          </iframe>
        </div>

        <div id="charger-status" class="mt-4 text-[10px] text-brand-muted font-mono uppercase tracking-[0.2em] text-center">
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
              <span class="block text-white font-bold mb-1">Abrir PlugShare</span>
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
              <span class="block text-white font-bold mb-1">Google Maps</span>
              <span class="text-xs text-brand-muted">Utilize a navegação nativa do Google para chegar ao destino.</span>
            </div>
          </a>
        </div>
      </section>
    </div>
  </main>

<?php
include "includes/footer.php";
?>
