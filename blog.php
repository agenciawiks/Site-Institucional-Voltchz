<?php
require_once "includes/db.php";

$cat_filter = isset($_GET['categoria']) ? $_GET['categoria'] : 'todos';
$busca_filter = isset($_GET['busca']) ? $_GET['busca'] : '';

$filtered_articles = get_filtered_artigos($cat_filter, $busca_filter);
$articles_count = count($filtered_articles);

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
      <form method="GET" action="blog.php" class="mb-12 max-w-xl mx-auto">
        <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($cat_filter); ?>">
        <div class="relative">
          <input type="text" name="busca" value="<?php echo htmlspecialchars($busca_filter); ?>" placeholder="Pesquisar artigos por palavra-chave, tema ou norma..."
            class="w-full bg-white/[0.03] border border-white/10 rounded-2xl pl-12 pr-4 py-4 text-[14px] text-brand-text placeholder:text-brand-muted/50 focus:outline-none focus:border-brand-green/50 transition-all shadow-xl">
          <div class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-muted/50">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </div>
        </div>
      </form>

      <!-- Filtros por Categoria do Blog -->
      <div class="mb-12 border-b border-white/5 pb-8">
        <p class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green mb-3">Filtrar Temas</p>
        <div class="flex flex-wrap gap-2.5">
          <a href="?categoria=todos&busca=<?php echo urlencode($busca_filter); ?>" 
             class="px-4 py-2 text-xs font-bold rounded-xl border <?php echo $cat_filter === 'todos' ? 'border-brand-green bg-brand-green text-brand-bg' : 'border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20'; ?> transition-all uppercase tracking-wider">
             Todos
          </a>
          <?php 
          $available_cats = ['Legislação', 'Segurança', 'Infraestrutura', 'Tecnologia'];
          foreach ($available_cats as $c):
          ?>
            <a href="?categoria=<?php echo urlencode($c); ?>&busca=<?php echo urlencode($busca_filter); ?>" 
               class="px-4 py-2 text-xs font-bold rounded-xl border <?php echo $cat_filter === $c ? 'border-brand-green bg-brand-green text-brand-bg' : 'border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20'; ?> transition-all uppercase tracking-wider">
               <?php echo htmlspecialchars($c); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="relative">
        
        <!-- ──────────────────────────────────────────
             ARTIGO EM DESTAQUE (HERO CARD)
        ────────────────────────────────────────── -->
        <?php 
        $display_articles = $filtered_articles;
        if (empty($busca_filter) && $cat_filter === 'todos' && !empty($filtered_articles)): 
          $featured = $filtered_articles[0];
          $display_articles = array_slice($filtered_articles, 1);
        ?>
          <section id="featured-article-section" class="mb-16">
            <div id="featured-article-container">
              <div class="group relative grid grid-cols-1 lg:grid-cols-12 gap-8 bg-white/[0.01] border border-white/5 hover:border-brand-green/20 rounded-[32px] overflow-hidden p-6 lg:p-8 backdrop-blur-xl shadow-2xl transition-all duration-300">
                <!-- Capa / Imagem Vetorial -->
                <div class="lg:col-span-6 relative aspect-[16/10] lg:aspect-auto rounded-2xl overflow-hidden bg-brand-bg border border-white/5 flex items-center justify-center min-h-[250px]">
                  <?php echo generate_technical_svg($featured['categoria'] === 'Legislação' ? 'protecao' : 'estacoes', $featured['titulo'], 'VoltchZ Insights'); ?>
                </div>

                <!-- Metadados e Texto -->
                <div class="lg:col-span-6 flex flex-col justify-center">
                  <div class="flex items-center gap-4 mb-4 text-[10px] font-mono text-brand-muted/70">
                    <span class="px-2.5 py-1 rounded bg-brand-green/10 text-brand-green font-bold uppercase tracking-widest">
                      Destaque · <?php echo htmlspecialchars($featured['categoria']); ?>
                    </span>
                    <span><?php echo htmlspecialchars($featured['data']); ?></span>
                    <span>•</span>
                    <span><?php echo htmlspecialchars($featured['tempoLeitura']); ?> de leitura</span>
                  </div>

                  <h3 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight tracking-tight mb-4 group-hover:text-brand-green transition-colors">
                    <a href="artigo.php?slug=<?php echo htmlspecialchars($featured['slug']); ?>"><?php echo htmlspecialchars($featured['titulo']); ?></a>
                  </h3>

                  <p class="text-brand-muted text-sm leading-relaxed mb-6">
                    <?php echo htmlspecialchars($featured['resumo']); ?>
                  </p>

                  <!-- Autor e Botão -->
                  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-6 border-t border-white/5 mt-auto">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-full border border-white/10 bg-white/5 flex items-center justify-center font-bold text-sm text-brand-green">
                        BR
                      </div>
                      <div>
                        <p class="text-xs font-bold text-white"><?php echo htmlspecialchars($featured['autor']); ?></p>
                        <p class="text-[9px] font-mono text-brand-muted/50 uppercase tracking-widest"><?php echo htmlspecialchars($featured['cargo'] ?: 'Especialista VoltchZ'); ?></p>
                      </div>
                    </div>

                    <a href="artigo.php?slug=<?php echo htmlspecialchars($featured['slug']); ?>" 
                      class="inline-flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-wider text-brand-bg bg-white px-6 py-3.5 rounded-xl hover:bg-brand-green hover:text-brand-bg transition-all active:scale-95 shadow-lg whitespace-nowrap">
                      Ler Artigo Completo
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </section>
        <?php endif; ?>

        <!-- ──────────────────────────────────────────
             GRID DOS DEMAIS ARTIGOS
        ────────────────────────────────────────── -->
        <section>
          <div class="flex items-center justify-between mb-8">
            <h2 id="grid-title" class="text-xl sm:text-2xl font-extrabold tracking-tight text-white">
              <?php echo (empty($busca_filter) && $cat_filter === 'todos') ? 'Mais Publicações' : 'Resultados Encontrados'; ?>
            </h2>
            <span id="blog-results-count" class="text-xs font-mono text-brand-muted/70">
              Exibindo <?php echo $articles_count; ?> <?php echo $articles_count === 1 ? 'artigo' : 'artigos'; ?>
            </span>
          </div>

          <?php if (empty($filtered_articles)): ?>
            <!-- Empty State (Nenhum artigo encontrado) -->
            <div id="blog-empty-state" class="flex flex-col items-center justify-center text-center max-w-xl mx-auto py-16 px-8 rounded-3xl bg-brand-bg2 border border-white/5 shadow-2xl">
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
              <a href="blog.php" class="inline-flex items-center gap-2 bg-brand-green text-brand-bg text-xs font-black uppercase tracking-widest px-6 py-3.5 rounded-xl hover:brightness-110 active:scale-95 transition-all">
                Limpar Filtros e Busca
              </a>
            </div>
          <?php else: ?>
            <div id="blog-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              <?php foreach ($display_articles as $art): ?>
                <div class="group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[28px] overflow-hidden flex flex-col p-5 backdrop-blur-xl shadow-2xl transition-all duration-300 hover:-translate-y-1.5">
                  <!-- Capa -->
                  <div class="relative w-full aspect-[16/10] rounded-2xl overflow-hidden bg-brand-bg mb-5 border border-white/5 flex items-center justify-center">
                    <?php echo generate_technical_svg($art['categoria'] === 'Legislação' ? 'protecao' : 'estacoes', $art['titulo'], 'VoltchZ Insights'); ?>
                  </div>

                  <!-- Conteúdo -->
                  <div class="flex-grow flex flex-col">
                    <div class="flex items-center justify-between gap-4 mb-3 text-[10px] font-mono text-brand-muted/70">
                      <span class="font-black uppercase tracking-wider text-brand-green">
                        <?php echo htmlspecialchars($art['categoria']); ?>
                      </span>
                      <div class="flex items-center gap-1.5">
                        <span><?php echo htmlspecialchars($art['data']); ?></span>
                        <span>•</span>
                        <span><?php echo htmlspecialchars($art['tempoLeitura']); ?></span>
                      </div>
                    </div>

                    <h3 class="text-base sm:text-lg font-bold text-white mb-3 leading-snug group-hover:text-brand-green transition-colors line-clamp-2">
                      <a href="artigo.php?slug=<?php echo htmlspecialchars($art['slug']); ?>"><?php echo htmlspecialchars($art['titulo']); ?></a>
                    </h3>

                    <p class="text-brand-muted text-[13px] leading-relaxed mb-6 line-clamp-3">
                      <?php echo htmlspecialchars($art['resumo']); ?>
                    </p>

                    <!-- Autor e Link -->
                    <div class="flex items-center justify-between gap-4 pt-4 border-t border-white/5 mt-auto">
                      <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full border border-white/10 bg-white/5 flex items-center justify-center font-bold text-xs text-brand-green">
                          BR
                        </div>
                        <span class="text-[11px] font-bold text-white"><?php echo htmlspecialchars($art['autor']); ?></span>
                      </div>

                      <a href="artigo.php?slug=<?php echo htmlspecialchars($art['slug']); ?>" 
                        class="text-[10px] font-bold uppercase tracking-wider text-brand-bg bg-white px-4 py-2.5 rounded-lg hover:bg-brand-green hover:text-brand-bg transition-all whitespace-nowrap">
                        Ler Artigo
                      </a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
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
include "includes/footer.php";
?>
