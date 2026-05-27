<?php
$page_title = "Blog Técnico e Conteúdo Editorial — VoltchZ Brasil";
$page_desc = "Leia artigos técnicos elaborados por especialistas da VoltchZ. Legislação de condomínios, curvas de disjuntores, dimensionamento de fiação e tecnologia de recarga.";
$current_page = "blog";
include "includes/header.php";
?>

  <!-- ──────────────────────────────────────────
       HERO EDITORIAL
  ────────────────────────────────────────── -->
  <header class="relative pt-32 pb-16 overflow-hidden bg-brand-bg2">
    <div class="absolute inset-0 opacity-20">
      <div class="orb w-[500px] h-[500px] -top-30 -right-30 bg-brand-green/20"></div>
    </div>
    <div class="max-w-[1200px] mx-auto px-6 relative z-10 text-center">
      <span
        class="inline-block px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono mb-5">
        VoltchZ Insights & Editorial
      </span>
      <h1 class="text-[clamp(34px,7vw,64px)] font-extrabold leading-tight tracking-tighter mb-6">
        Conhecimento Técnico que Impulsiona<br>
        <span class="text-brand-green">a Mobilidade Elétrica</span>
      </h1>
      <p class="text-lg text-brand-muted max-w-3xl mx-auto leading-relaxed">
        Artigos elaborados por nossos engenheiros sobre dimensionamento de fiação, NBR 5410, normas prediais paulistas e inovações de engenharia.
      </p>
    </div>
  </header>

  <!-- ──────────────────────────────────────────
       CORPO DO BLOG: BUSCA, DESTAQUE E GRID
  ────────────────────────────────────────── -->
  <main class="py-12 px-6 bg-brand-bg relative min-h-[60vh] z-10">
    <div class="max-w-[1200px] mx-auto">

      <!-- Filtro de Busca Textual Rápido -->
      <div class="mb-12 max-w-xl mx-auto">
        <div class="relative">
          <input type="text" id="blog-search-input" placeholder="Pesquisar artigos por palavra-chave, tema ou norma..."
            class="w-full bg-white/[0.03] border border-white/10 rounded-2xl pl-12 pr-4 py-4 text-[14px] text-brand-text placeholder:text-brand-muted/50 focus:outline-none focus:border-brand-green/50 transition-all shadow-xl">
          <div class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-muted/50">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </div>
        </div>
      </div>

      <!-- Filtros por Categoria do Blog -->
      <div class="mb-12 border-b border-white/5 pb-8">
        <p class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green mb-3">Filtrar Temas</p>
        <div id="blog-category-filters" class="flex flex-wrap gap-2.5">
          <button data-value="todos" class="filter-btn active px-4 py-2 text-xs font-bold rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">Todos</button>
          <button data-value="Legislação" class="filter-btn px-4 py-2 text-xs font-bold rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">Legislação</button>
          <button data-value="Segurança" class="filter-btn px-4 py-2 text-xs font-bold rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">Segurança</button>
          <button data-value="Infraestrutura" class="filter-btn px-4 py-2 text-xs font-bold rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">Infraestrutura</button>
          <button data-value="Tecnologia" class="filter-btn px-4 py-2 text-xs font-bold rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider">Tecnologia</button>
        </div>
      </div>

      <!-- Spinner de Carregamento -->
      <div class="relative">
        <div id="blog-loading-spinner" class="absolute inset-0 z-20 flex items-center justify-center bg-brand-bg/80 backdrop-blur-sm transition-opacity duration-300 hidden">
          <div class="w-10 h-10 border-4 border-brand-green border-t-transparent rounded-full animate-spin"></div>
        </div>

        <!-- ──────────────────────────────────────────
             ARTIGO EM DESTAQUE (HERO CARD)
        ────────────────────────────────────────── -->
        <section id="featured-article-section" class="mb-16 hidden">
          <div id="featured-article-container">
            <!-- Injetado dinamicamente via JavaScript -->
          </div>
        </section>

        <!-- ──────────────────────────────────────────
             GRID DOS DEMAIS ARTIGOS
        ────────────────────────────────────────── -->
        <section>
          <div class="flex items-center justify-between mb-8">
            <h2 id="grid-title" class="text-xl sm:text-2xl font-extrabold tracking-tight text-white">Últimas Publicações</h2>
            <span id="blog-results-count" class="text-xs font-mono text-brand-muted/70">Exibindo 0 artigos</span>
          </div>

          <div id="blog-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Cards injetados via JS -->
          </div>

          <!-- Empty State (Nenhum artigo encontrado) -->
          <div id="blog-empty-state" class="hidden flex-col items-center justify-center text-center max-w-xl mx-auto py-16 px-8 rounded-3xl bg-brand-bg2 border border-white/5 shadow-2xl">
            <div class="w-16 h-16 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mb-6 text-brand-green">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="8" y1="12" x2="16" y2="12"></line>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-3">Nenhum artigo localizado</h3>
            <p class="text-sm text-brand-muted leading-relaxed mb-6">
              Não encontramos nenhuma publicação para o termo pesquisado. Experimente buscar por palavras genéricas como "lei", "cabo", "DR" ou "condomínio".
            </p>
            <button id="reset-blog-filters" class="inline-flex items-center gap-2 bg-brand-green text-brand-bg text-xs font-black uppercase tracking-widest px-6 py-3.5 rounded-xl hover:brightness-110 active:scale-95 transition-all">
              Limpar Filtros e Busca
            </button>
          </div>
        </section>
      </div>

    </div>
  </main>

  <!-- ──────────────────────────────────────────
       ÁREA DE CTA INSTITUCIONAL
  ────────────────────────────────────────── -->
  <section class="relative bg-brand-bg3 py-20 px-6 border-t border-white/5 overflow-hidden">
    <div class="absolute inset-0 bg-[linear-gradient(rgba(34,197,94,0.01)_1px,transparent_1px),linear-gradient(90deg,rgba(34,197,94,0.01)_1px,transparent_1px)] bg-[size:40px_40px]"></div>
    <div class="max-w-[800px] mx-auto text-center relative z-10">
      <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-6">
        Necessita de assessoria de engenharia para o seu condomínio?
      </h2>
      <p class="text-brand-muted text-sm sm:text-base leading-relaxed mb-8">
        Elaboramos projetos elétricos robustos, estudos técnicos de viabilidade com ART e atuamos na adequação condominial completa perante a Lei 18.403.
      </p>
      <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
        <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-brand-green text-brand-bg font-extrabold px-8 py-4 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
          Falar com Especialistas
        </a>
        <a href="contato.php"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border border-white/10 bg-white/5 text-white font-extrabold px-8 py-4 rounded-2xl hover:bg-white/10 transition-all">
          Entre em Contato
        </a>
      </div>
    </div>
  </section>

<?php
$additional_scripts = '<script type="module" src="js/pages/blog.js"></script>';
include "includes/footer.php";
?>
