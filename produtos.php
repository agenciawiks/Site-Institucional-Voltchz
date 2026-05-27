<?php
$page_title = "Equipamentos e Soluções de Recarga — VoltchZ Brasil";
$page_desc = "Conheça nosso catálogo completo de infraestrutura e carregadores para veículos elétricos. Engenharia certificada ITA com proteção industrial avançada.";
$current_page = "produtos";
include "includes/header.php";
?>

  <!-- ──────────────────────────────────────────
       HERO INSTITUCIONAL DO CATÁLOGO
  ────────────────────────────────────────── -->
  <header class="relative pt-32 pb-16 overflow-hidden bg-brand-bg2">
    <div class="absolute inset-0 opacity-20">
      <div class="orb w-[500px] h-[500px] -top-30 -right-30 bg-brand-green/20"></div>
    </div>
    <div class="max-w-[1200px] mx-auto px-6 relative z-10 text-center">
      <span
        class="inline-block px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono mb-5">
        Portfólio de Equipamentos
      </span>
      <h1 class="text-[clamp(34px,7vw,64px)] font-extrabold leading-tight tracking-tighter mb-6">
        Catálogo Técnico de Equipamentos<br>
        <span class="text-brand-green">e Proteções Elétricas</span>
      </h1>
      <p class="text-lg text-brand-muted max-w-3xl mx-auto leading-relaxed">
        Proteções exclusivas contra surtos e choque elétrico com a marca E-Wolf, pedestais estruturais VoltchZ e
        carregadores inteligentes de alta durabilidade com engenharia certificada.
      </p>
    </div>
  </header>

  <!-- ──────────────────────────────────────────
       CORPO PRINCIPAL (BUSCA, FILTROS E GRID)
  ────────────────────────────────────────── -->
  <main class="py-12 px-6 bg-brand-bg relative min-h-[60vh] z-10">
    <div class="max-w-[1200px] mx-auto">

      <!-- Barra de Busca Textual -->
      <div class="mb-10 max-w-xl mx-auto observe">
        <div class="relative">
          <input type="text" id="search-input" placeholder="Pesquisar por modelo, amperagem, SKU ou característica..."
            class="w-full bg-white/[0.03] border border-white/10 rounded-2xl pl-12 pr-4 py-4 text-[14px] text-brand-text placeholder:text-brand-muted/50 focus:outline-none focus:border-brand-green/50 transition-all shadow-xl">
          <div class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-muted/50">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </div>
        </div>
      </div>

      <!-- Grid de Filtros Laterais/Superiores -->
      <div class="flex flex-col gap-6 mb-12 border-b border-white/5 pb-8 observe">
        <!-- Filtro por Categorias (Chips) -->
        <div>
          <p class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green mb-3">Categorias</p>
          <div id="category-filters" class="flex flex-wrap gap-2">
            <button data-value="todos" class="filter-btn active px-4 py-2 text-xs font-bold rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">Todos</button>
            <!-- Injetado por JS -->
          </div>
        </div>

        <!-- Filtro por Marcas (Chips) -->
        <div>
          <p class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green mb-3">Marcas</p>
          <div id="brand-filters" class="flex flex-wrap gap-2">
            <button data-value="todos" class="filter-btn active px-4 py-2 text-xs font-bold rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">Todos</button>
            <!-- Injetado por JS -->
          </div>
        </div>
      </div>

      <!-- Indicador de Resultados -->
      <div class="flex items-center justify-between mb-6 text-sm text-brand-muted observe">
        <span id="results-count">Exibindo 0 produtos</span>
        <button id="reset-filters" class="text-brand-green hover:underline text-xs font-bold uppercase tracking-wider flex items-center gap-1">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
            <path d="M23 4v6h-6M1 20v-6h6"></path>
            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
          </svg>
          Limpar Filtros
        </button>
      </div>

      <!-- Grid de Produtos com Efeito Loading -->
      <div class="relative">
        <div id="loading-spinner" class="absolute inset-0 z-20 flex items-center justify-center bg-brand-bg/80 backdrop-blur-sm transition-opacity duration-300 hidden">
          <div class="w-10 h-10 border-4 border-brand-green border-t-transparent rounded-full animate-spin"></div>
        </div>

        <!-- Grid de Cards -->
        <div id="products-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 transition-all duration-300">
          <!-- Injetado Dinamicamente em JS -->
        </div>

        <!-- Estado Vazio (Empty State) para marcas sem produtos cadastrados -->
        <div id="empty-state" class="hidden flex-col items-center justify-center text-center max-w-xl mx-auto py-16 px-8 rounded-3xl bg-brand-bg2 border border-white/5 shadow-2xl">
          <div class="w-16 h-16 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mb-6 text-brand-green">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-white mb-3">Sem Equipamentos Cadastrados</h3>
          <p class="text-sm text-brand-muted leading-relaxed mb-6">
            Não existem produtos cadastrados sob estes critérios no momento. Nossa divisão de engenharia realiza homologação e testes de novos hardwares continuamente.
          </p>
          <a href="contato.php" class="inline-flex items-center gap-2 bg-brand-green text-brand-bg text-xs font-black uppercase tracking-widest px-6 py-3.5 rounded-xl hover:brightness-110 active:scale-95 transition-all">
            Solicitar Projeto Especial
          </a>
        </div>
      </div>

    </div>
  </main>

  <!-- ──────────────────────────────────────────
       ÁREA DE CTA INSTITUCIONAL FUTURA
  ────────────────────────────────────────── -->
  <section class="relative bg-brand-bg3 py-20 px-6 border-t border-white/5 overflow-hidden observe">
    <div class="absolute inset-0 bg-[linear-gradient(rgba(34,197,94,0.01)_1px,transparent_1px),linear-gradient(90deg,rgba(34,197,94,0.01)_1px,transparent_1px)] bg-[size:40px_40px]"></div>
    <div class="max-w-[800px] mx-auto text-center relative z-10">
      <h2 class="text-3xl font-extrabold tracking-tight mb-6">
        Necessita de uma solução corporativa ou predial sob medida?
      </h2>
      <p class="text-brand-muted text-base leading-relaxed mb-8">
        Nossos engenheiros eletricistas especializados realizam o estudo de viabilidade, dimensionamento de fiação de alta bitola e projetos de recarga escalável com balanceamento dinâmico (OCPP).
      </p>
      <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
        <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-brand-green text-brand-bg font-extrabold px-8 py-4 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
          Conversar no WhatsApp
        </a>
        <a href="viabilidade.php"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border border-white/10 bg-white/5 text-white font-extrabold px-8 py-4 rounded-2xl hover:bg-white/10 transition-all">
          Estudo de Viabilidade
        </a>
      </div>
    </div>
  </section>

<?php
$additional_scripts = '<script type="module" src="js/pages/produtos.js"></script>';
include "includes/footer.php";
?>
