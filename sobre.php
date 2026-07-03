<?php
$page_title = "Sobre Nós — VoltchZ Brasil";
$page_desc = "Conheça a história, missão e os diferenciais da VoltchZ Brasil, líder em infraestrutura de recarga para veículos elétricos.";
$current_page = "sobre";
$additional_head = '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">';
include "includes/header.php";
?>
  <!-- ──────────────────────────────────────────
       HERO SOBRE (TÍTULO DA PÁGINA)
  ────────────────────────────────────────── -->
  <header class="relative pt-32 pb-20 overflow-hidden bg-brand-bg2">
    <div class="absolute inset-0 opacity-20">
      <div class="orb w-[600px] h-[600px] -top-40 -left-40 bg-brand-green/30"></div>
    </div>
    <div class="max-w-[1200px] mx-auto px-6 relative z-10 text-center">
      <span
        class="inline-block px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono mb-6 observe">Conheça
        a VoltchZ</span>
      <h1 class="text-[clamp(40px,8vw,72px)] font-extrabold leading-tight tracking-tighter mb-8 observe">Nossa Jornada
        pela <br><span class="text-brand-green">Eletromobilidade</span></h1>
      <p class="text-xl text-brand-muted max-w-2xl mx-auto leading-relaxed observe">
        Uma fusão de excelência acadêmica e rigor técnico para entregar o futuro da energia hoje.
      </p>
    </div>
  </header>

  <!-- ──────────────────────────────────────────
       HISTÓRIA (NOSSA TRAJETÓRIA)
  ────────────────────────────────────────── -->
  <section id="historia" class="py-24 px-6 bg-white text-slate-900">
    <div class="max-w-[1200px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
      <div class="observe">
        <h2 class="text-3xl font-extrabold mb-6">Nossa História</h2>
        <div class="space-y-6 text-slate-600 text-lg leading-relaxed">
          <p>
            A VoltchZ Brasil nasceu da necessidade de <span class="font-bold">elevar o padrão técnico</span> das
            instalações de infraestrutura para veículos elétricos no <span class="font-bold">Vale do Paraíba</span>.
            Fundada por especialistas com passagens por instituições de renome como <span
              class="font-bold text-brand-green">ITA e Inatel</span>, a empresa trouxe o <span class="font-bold">rigor
              científico</span> para o mercado prático.
          </p>
          <p>
            Desde o primeiro projeto, nosso foco nunca foi apenas "instalar carregadores", mas sim projetar a <span
              class="font-bold text-brand-green">viabilidade energética</span> e a <span class="font-bold">segurança
              patrimonial</span> de nossos clientes, garantindo que a transição para o elétrico fosse livre de
            preocupações.
          </p>
        </div>
      </div>
      <div class="relative observe mt-12 lg:mt-0 mb-8 lg:mb-0">
        <img src="static/bruno.webp" alt="Bruno, Fundador da VoltchZ"
          class="rounded-[40px] shadow-2xl border border-white/5 w-full" loading="lazy" width="600" height="800">
        <div
          class="absolute -bottom-4 left-4 sm:-left-6 lg:-bottom-6 bg-brand-green p-4 lg:p-6 rounded-2xl font-bold text-brand-bg shadow-xl">
          Fundada em 2020
        </div>
      </div>
    </div>
  </section>

  <!-- ──────────────────────────────────────────
       MISSÃO VISÃO VALORES (PROPÓSITO)
  ────────────────────────────────────────── -->
  <section id="proposito" class="py-24 px-6 bg-brand-bg2 border-y border-white/5">
    <div class="max-w-[1200px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Missão -->
      <div
        class="p-10 bg-white/5 border border-white/10 rounded-[32px] hover:border-brand-green/40 transition-all observe">
        <div class="w-12 h-12 bg-brand-green/20 rounded-xl flex items-center justify-center mb-6 text-brand-green">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-4">Missão</h3>
        <p class="text-brand-muted leading-relaxed">Prover <span class="font-bold text-white">infraestrutura de recarga
            segura</span>, eficiente e normativa, facilitando a adoção global da <span
            class="font-bold text-brand-green">mobilidade elétrica</span>.</p>
      </div>
      <!-- Visão -->
      <div
        class="p-10 bg-white/5 border border-white/10 rounded-[32px] hover:border-brand-green/40 transition-all observe">
        <div class="w-12 h-12 bg-brand-green/20 rounded-xl flex items-center justify-center mb-6 text-brand-green">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4l3 3" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-4">Visão</h3>
        <p class="text-brand-muted leading-relaxed">Ser a <span class="font-bold text-white">principal referência
            técnica</span> em engenharia para eletromobilidade no Brasil até <span
            class="font-bold text-brand-green">2030</span>.</p>
      </div>
      <!-- Valores -->
      <div
        class="p-10 bg-white/5 border border-white/10 rounded-[32px] hover:border-brand-green/40 transition-all observe">
        <div class="w-12 h-12 bg-brand-green/20 rounded-xl flex items-center justify-center mb-6 text-brand-green">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path
              d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-4">Valores</h3>
        <p class="text-brand-muted leading-relaxed"><span class="font-bold text-white">Rigor técnico</span>,
          transparência normativa, <span class="font-bold text-brand-green">sustentabilidade prática</span> e
          compromisso com a vida.</p>
      </div>
    </div>
  </section>

  <!-- ──────────────────────────────────────────
       NOSSA PRESENÇA (CIDADES + MAPA)
  ────────────────────────────────────────── -->
  <section id="presenca" class="py-24 px-6 bg-white text-slate-900">
    <div class="max-w-[1200px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
      <div class="observe">
        <h2 class="text-3xl lg:text-4xl font-extrabold mb-6 tracking-tight">Nossa presença</h2>
        <p class="text-slate-600 text-lg leading-relaxed mb-8">
          A VoltchZ está presente em diversas regiões de São Paulo e Minas Gerais, com instalações nas
          principais cidades do <span class="font-bold">Vale do Paraíba</span>, <span class="font-bold">Litoral
            Norte</span> e <span class="font-bold">sul mineiro</span>, garantindo cobertura regional confiável.
        </p>
        <h3 class="text-xl font-bold mb-3">Mapa das cidades principais atendidas</h3>
        <p class="text-sm text-slate-500 font-mono uppercase tracking-wider mb-4">Brasil — cidades principais</p>
        <p class="text-slate-600 leading-relaxed">
          <span class="font-semibold text-slate-800">Cidades principais atendidas:</span>
          Arujá (SP), Atibaia (SP), Bragança Paulista (SP), Cachoeira Paulista (SP), Caçapava (SP),
          Caraguatatuba (SP), Cerquilho (SP), Guararema (SP), Guarulhos (SP), Itajubá (MG), Jambeiro (SP),
          Jacareí (SP), Mogi das Cruzes (SP), Pindamonhangaba (SP), Pouso Alegre (MG), Santa Rita do Sapucaí (MG),
          Santo Antônio do Pinhal (SP), São Bento do Sapucaí (SP), São Francisco Xavier (SP), São José dos Campos (SP),
          Taubaté (SP), Ubatuba (SP).
        </p>
      </div>
      <div class="observe lg:sticky lg:top-24">
        <div
          class="rounded-[24px] overflow-hidden border border-slate-200 shadow-xl shadow-slate-200/60 min-h-[360px] lg:min-h-[480px]">
          <div id="map-presenca" role="img" aria-label="Mapa das cidades onde a VoltchZ já atuou"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ──────────────────────────────────────────
       DIFERENCIAIS TABLE (COMPARATIVO)
  ────────────────────────────────────────── -->
  <section id="diferenciais" class="py-24 px-6 bg-slate-50">
    <div
      class="max-w-[1000px] mx-auto overflow-hidden rounded-[40px] border border-slate-200 bg-white shadow-2xl shadow-slate-200/50 observe">
      <table class="w-full text-left border-collapse block md:table">
        <thead class="hidden md:table-header-group bg-brand-green/10">
          <tr class="md:table-row">
            <th class="p-8 text-xl font-bold border-b border-slate-200 text-slate-900">Diferencial</th>
            <th class="p-8 text-xl font-bold border-b border-slate-200 text-brand-green">VoltchZ</th>
            <th class="p-8 text-xl font-bold border-b border-slate-200 text-slate-400">Mercado Comum</th>
          </tr>
        </thead>
        <tbody class="block md:table-row-group text-slate-700">
          <tr class="block md:table-row border-b border-slate-100 hover:bg-slate-50 transition-colors">
            <td class="block md:table-cell p-5 md:p-8 font-medium">
              <span class="md:hidden block text-[11px] font-mono uppercase tracking-wider text-slate-400 mb-1">Diferencial</span>
              Responsável Técnico
            </td>
            <td class="block md:table-cell p-5 md:p-8 pt-0 md:pt-8 text-brand-green font-bold">
              <span class="md:hidden block text-[11px] font-mono uppercase tracking-wider text-slate-400 mb-1">VoltchZ</span>
              Engenheiro especializado (ITA/Inatel/UNIFESP)
            </td>
            <td class="block md:table-cell p-5 md:p-8 pt-0 md:pt-8 pb-6 md:pb-8 text-slate-400">
              <span class="md:hidden block text-[11px] font-mono uppercase tracking-wider text-slate-400 mb-1">Mercado Comum</span>
              Mão de obra sem especialização
            </td>
          </tr>

          <tr class="block md:table-row border-b border-slate-100 hover:bg-slate-50 transition-colors">
            <td class="block md:table-cell p-5 md:p-8 font-medium">
              <span class="md:hidden block text-[11px] font-mono uppercase tracking-wider text-slate-400 mb-1">Diferencial</span>
              Documentação ART
            </td>
            <td class="block md:table-cell p-5 md:p-8 pt-0 md:pt-8 text-brand-green font-bold">
              <span class="md:hidden block text-[11px] font-mono uppercase tracking-wider text-slate-400 mb-1">VoltchZ</span>
              Disponível conforme necessidade do projeto
            </td>
            <td class="block md:table-cell p-5 md:p-8 pt-0 md:pt-8 pb-6 md:pb-8 text-slate-400">
              <span class="md:hidden block text-[11px] font-mono uppercase tracking-wider text-slate-400 mb-1">Mercado Comum</span>
              Pouco utilizada
            </td>
          </tr>

          <tr class="block md:table-row border-b border-slate-100 hover:bg-slate-50 transition-colors">
            <td class="block md:table-cell p-5 md:p-8 font-medium">
              <span class="md:hidden block text-[11px] font-mono uppercase tracking-wider text-slate-400 mb-1">Diferencial</span>
              Norma NBR 5410
            </td>
            <td class="block md:table-cell p-5 md:p-8 pt-0 md:pt-8 text-brand-green font-bold">
              <span class="md:hidden block text-[11px] font-mono uppercase tracking-wider text-slate-400 mb-1">VoltchZ</span>
              Projeto dentro das normas técnicas
            </td>
            <td class="block md:table-cell p-5 md:p-8 pt-0 md:pt-8 pb-6 md:pb-8 text-slate-400">
              <span class="md:hidden block text-[11px] font-mono uppercase tracking-wider text-slate-400 mb-1">Mercado Comum</span>
              Execução sem padronização
            </td>
          </tr>

          <tr class="block md:table-row hover:bg-slate-50 transition-colors">
            <td class="block md:table-cell p-5 md:p-8 font-medium">
              <span class="md:hidden block text-[11px] font-mono uppercase tracking-wider text-slate-400 mb-1">Diferencial</span>
              Pós-Venda
            </td>
            <td class="block md:table-cell p-5 md:p-8 pt-0 md:pt-8 text-brand-green font-bold">
              <span class="md:hidden block text-[11px] font-mono uppercase tracking-wider text-slate-400 mb-1">VoltchZ</span>
              Suporte técnico confiável
            </td>
            <td class="block md:table-cell p-5 md:p-8 pt-0 md:pt-8 pb-6 md:pb-8 text-slate-400">
              <span class="md:hidden block text-[11px] font-mono uppercase tracking-wider text-slate-400 mb-1">Mercado Comum</span>
              Atendimento limitado
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <!-- ──────────────────────────────────────────
       EQUIPAMENTOS SECTION (HARDWARE)
  ────────────────────────────────────────── -->
  <section id="equipamentos" class="bg-brand-bg2 py-24 px-6 relative overflow-hidden">
    <div class="orb w-[300px] h-[300px] top-1/2 -left-20 bg-brand-green/10"></div>
    <div class="max-w-[1200px] mx-auto relative z-10">
      <div class="text-center mb-16 observe">
        <p class="text-[12px] font-mono font-bold uppercase tracking-[0.2em] text-brand-green mb-4">Hardware de Elite
        </p>
        <h2 class="text-4xl font-extrabold text-white tracking-tight mb-5">Equipamentos Homologados</h2>
        <p class="text-brand-muted max-w-2xl mx-auto text-lg leading-relaxed">Trabalhamos exclusivamente com as marcas
          líderes do mercado global, garantindo longevidade e suporte técnico nacional.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 observe">
        <div
          class="group relative bg-white/5 border border-white/10 rounded-[40px] p-10 hover:bg-white/10 transition-all duration-500 hover:-translate-y-2">
          <div class="mb-8"><span
              class="text-brand-green font-bold text-xs uppercase tracking-widest border border-brand-green/30 px-3 py-1 rounded-full">Nacional</span>
          </div>
          <h3 class="text-2xl font-extrabold text-white mb-4">Intelbras</h3>
          <p class="text-brand-muted leading-relaxed"><span class="font-bold text-white">Líder absoluta</span> em
            segurança e referência em <span class="font-bold text-brand-green">carregadores inteligentes</span> para
            residências e condomínios.</p>
        </div>
        <div
          class="group relative bg-white/5 border border-white/10 rounded-[40px] p-10 hover:bg-white/10 transition-all duration-500 hover:-translate-y-2">
          <div class="mb-8"><span
              class="text-brand-green font-bold text-xs uppercase tracking-widest border border-brand-green/30 px-3 py-1 rounded-full">Performance</span>
          </div>
          <h3 class="text-2xl font-extrabold text-white mb-4">Incharge</h3>
          <p class="text-brand-muted leading-relaxed"><span class="font-bold text-white">Soluções robustas</span>
            focadas em ambientes corporativos e <span class="font-bold text-brand-green">eletropostos</span> com alta
            velocidade de carregamento.</p>
        </div>
        <div
          class="group relative bg-white/5 border border-white/10 rounded-[40px] p-10 hover:bg-white/10 transition-all duration-500 hover:-translate-y-2">
          <div class="mb-8"><span
              class="text-brand-green font-bold text-xs uppercase tracking-widest border border-brand-green/30 px-3 py-1 rounded-full">Global</span>
          </div>
          <h3 class="text-2xl font-extrabold text-white mb-4">E-Wolf</h3>
          <p class="text-brand-muted leading-relaxed"><span class="font-bold text-white">Design premium</span> e
            tecnologia alemã para quem busca o máximo de <span class="font-bold text-brand-green">sofisticação</span> e
            integração solar.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ──────────────────────────────────────────

<?php
$additional_scripts = '<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>\n    <script type="module" src="js/pages/sobre.js"></script>';
include "includes/footer.php";
?>
