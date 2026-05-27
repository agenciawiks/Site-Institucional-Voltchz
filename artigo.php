<?php
include "includes/db.php";

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$artigo = get_artigo_by_slug($slug);

if ($artigo) {
    $page_title = $artigo['titulo'] . " — VoltchZ Brasil";
    $page_desc = $artigo['resumo'];
} else {
    $page_title = "Publicação Não Localizada — VoltchZ Brasil";
    $page_desc = "O artigo solicitado não existe ou foi removido de nossa base técnica.";
}

$current_page = "blog";
include "includes/header.php";
?>

  <!-- ──────────────────────────────────────────
       CORPO DO LEITOR DE ARTIGO
  ────────────────────────────────────────── -->
  <main class="pt-28 pb-20 px-6 bg-brand-bg relative z-10">
    <div class="max-w-[1200px] mx-auto">

      <!-- Breadcrumbs -->
      <nav class="flex mb-8 text-[11px] font-mono font-bold uppercase tracking-widest text-brand-muted/50" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
          <li class="inline-flex items-center">
            <a href="index.php" class="hover:text-brand-green transition-colors">Início</a>
          </li>
          <li>
            <div class="flex items-center">
              <span class="mx-1 text-white/20">/</span>
              <a href="blog.php" class="hover:text-brand-green transition-colors">Blog</a>
            </div>
          </li>
          <?php if ($artigo): ?>
          <li>
            <div class="flex items-center">
              <span class="mx-1 text-white/20">/</span>
              <a href="blog.php?categoria=<?php echo urlencode($artigo['categoria']); ?>" class="hover:text-brand-green transition-colors"><?php echo htmlspecialchars($artigo['categoria']); ?></a>
            </div>
          </li>
          <li aria-current="page">
            <div class="flex items-center">
              <span class="mx-1 text-white/20">/</span>
              <span id="breadcrumb-current" class="text-white font-black truncate max-w-[150px] sm:max-w-none"><?php echo htmlspecialchars($artigo['titulo']); ?></span>
            </div>
          </li>
          <?php else: ?>
          <li aria-current="page">
            <div class="flex items-center">
              <span class="mx-1 text-white/20">/</span>
              <span id="breadcrumb-current" class="text-white font-black">Erro</span>
            </div>
          </li>
          <?php endif; ?>
        </ol>
      </nav>

      <?php if ($artigo): ?>
      <!-- Chassis do Leitor -->
      <article id="article-reader-chassis" class="max-w-[800px] mx-auto">
        <!-- Cabeçalho do Artigo -->
        <header class="mb-10 border-b border-white/5 pb-8">
          <div class="flex flex-wrap items-center gap-3 mb-5 text-xs font-mono text-brand-muted/70">
            <span id="article-category-tag" class="px-3 py-1.5 rounded-lg bg-brand-green/10 text-brand-green font-bold uppercase tracking-widest border border-brand-green/20">
              <?php echo htmlspecialchars($artigo['categoria']); ?>
            </span>
            <span class="text-brand-muted/40">•</span>
            <span id="article-date"><?php echo htmlspecialchars($artigo['data']); ?></span>
            <span class="text-brand-muted/40">•</span>
            <span id="article-read-time" class="flex items-center gap-1">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <?php echo htmlspecialchars($artigo['tempoLeitura']); ?> de leitura
            </span>
          </div>

          <h1 id="article-title" class="text-2xl sm:text-3xl lg:text-[2.2rem] font-extrabold leading-tight tracking-tight text-white mb-8">
            <?php echo htmlspecialchars($artigo['titulo']); ?>
          </h1>

          <!-- Perfil do Autor -->
          <div class="flex items-center gap-4">
            <img src="static/bruno.webp" alt="Bruno Riêra" loading="lazy"
              class="w-12 h-12 rounded-full object-cover border-2 border-brand-green/30 flex-shrink-0">
            <div>
              <p id="article-author" class="text-sm font-bold text-white leading-tight"><?php echo htmlspecialchars($artigo['autor']); ?></p>
              <p id="article-author-cargo" class="text-[10px] font-mono text-brand-muted/60 uppercase tracking-widest mt-0.5"><?php echo htmlspecialchars($artigo['cargo']); ?></p>
            </div>
          </div>
        </header>

        <!-- Capa Técnica -->
        <div class="relative w-full aspect-[16/5] rounded-[20px] overflow-hidden bg-brand-bg2 border border-white/5 shadow-2xl flex items-center justify-center mb-12">
          <div id="article-media-container" class="w-full h-full flex items-center justify-center">
            <!-- SVG do Artigo Gerado no Servidor -->
            <?php 
              $svg_meta = $artigo['svg_metadata'];
              echo generate_technical_svg($svg_meta['category'], $svg_meta['title'], $svg_meta['subtitle']);
            ?>
          </div>
          <!-- Gradient overlay bottom -->
          <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-brand-bg2 to-transparent pointer-events-none"></div>
        </div>

        <!-- Corpo Editorial Reativo (Server-Side Premium Rendering) -->
        <div id="article-body-content" class="text-brand-text/90 leading-relaxed min-h-0" style="min-height:auto;">
          <?php foreach ($artigo['conteudo'] as $block): ?>
            <?php if ($block['type'] === 'heading'): ?>
              <h2 class="text-xl sm:text-2xl font-extrabold text-white mt-12 mb-5 pl-4 border-l-4 border-brand-green leading-tight observe">
                <?php echo htmlspecialchars($block['text']); ?>
              </h2>
            <?php elseif ($block['type'] === 'paragraph'): ?>
              <p class="leading-[1.85] text-brand-muted/90 text-sm sm:text-base mb-7 text-justify sm:text-left observe">
                <?php echo htmlspecialchars($block['text']); ?>
              </p>
            <?php elseif ($block['type'] === 'list'): ?>
              <ul class="space-y-3.5 my-6 pl-2 observe">
                <?php foreach ($block['items'] as $li): ?>
                  <li class="flex items-start gap-3 text-sm sm:text-base text-brand-muted/95 leading-relaxed">
                    <svg class="w-5 h-5 text-brand-green flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span><?php echo htmlspecialchars($li); ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php elseif ($block['type'] === 'blockquote'): ?>
              <div class="my-8 p-6 sm:p-8 rounded-3xl bg-brand-bg2 border border-white/5 border-l-4 border-l-brand-green relative overflow-hidden shadow-xl observe">
                <div class="absolute -right-4 -top-8 text-brand-green/5 text-9xl font-serif pointer-events-none select-none">“</div>
                <p class="text-white italic text-base sm:text-lg leading-relaxed relative z-10 mb-4 text-justify sm:text-left">
                  "<?php echo htmlspecialchars($block['text']); ?>"
                </p>
                <?php if (isset($block['author'])): ?>
                  <cite class="not-italic text-xs font-mono font-bold uppercase tracking-wider text-brand-green block relative z-10">
                    — <?php echo htmlspecialchars($block['author']); ?>
                  </cite>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>

        <!-- Seção: Biografia do Autor no Fim da Leitura -->
        <div class="mt-16 p-6 sm:p-8 rounded-3xl bg-white/[0.02] border border-white/8 flex flex-col sm:flex-row items-center sm:items-start gap-5 shadow-2xl observe">
          <img src="static/bruno.webp" alt="Bruno Riêra" loading="lazy"
            class="w-20 h-20 rounded-full object-cover border-2 border-brand-green/30 flex-shrink-0">
          <div class="text-center sm:text-left">
            <h4 class="text-base font-bold text-white mb-1">Bruno Riêra</h4>
            <p class="text-[10px] font-mono font-bold uppercase tracking-wider text-brand-green mb-3">Diretor de Engenharia & Especialista ITA — VoltchZ Brasil</p>
            <p class="text-sm text-brand-muted leading-relaxed">
              Engenheiro Eletrotécnico formado pelo ITA (Instituto Tecnológico de Aeronáutica), Bruno lidera a equipe de dimensionamento e segurança elétrica da VoltchZ Brasil. Especialista em proteção ativa de circuitos, balanceamento de carga inteligente via OCPP e adequação de instalações às normas NBR 5410 e NBR 17019.
            </p>
          </div>
        </div>
      </article>
      <?php else: ?>
      <!-- Estado Inexistente (Error 404/Empty State) -->
      <div id="article-not-found" class="flex flex-col items-center justify-center text-center max-w-xl mx-auto py-16 px-8 rounded-3xl bg-brand-bg2 border border-white/5 shadow-2xl">
        <div class="w-16 h-16 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mb-6 text-brand-green">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-3">Publicação não localizada</h3>
        <p class="text-sm text-brand-muted leading-relaxed mb-6">
          O artigo solicitado não existe ou foi removido de nossa base técnica. Retorne ao painel editorial para conferir outras matérias de engenharia de recarga.
        </p>
        <a href="blog.php" class="inline-flex items-center gap-2 bg-brand-green text-brand-bg text-xs font-black uppercase tracking-widest px-6 py-3.5 rounded-xl hover:brightness-110 active:scale-95 transition-all">
          Retornar ao Blog
        </a>
      </div>
      <?php endif; ?>

      <!-- ──────────────────────────────────────────
           SEÇÃO: ARTIGOS RECOMENDADOS (LATERAIS)
      ────────────────────────────────────────── -->
      <section id="recommended-section" class="mt-24 pt-12 border-t border-white/5 <?php echo $artigo ? '' : 'hidden'; ?>">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
          <div>
            <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-brand-green">
              Leitura Complementar
            </span>
            <h2 class="text-xl sm:text-2xl font-bold text-white mt-1">
              Recomendado para você
            </h2>
          </div>
          <a href="blog.php" class="text-brand-green text-xs font-bold uppercase tracking-wider hover:underline flex items-center gap-1">
            Ver Todos os Artigos
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
        </div>

        <div id="recommended-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Injetado por JS Hydration -->
        </div>
      </section>

    </div>
  </main>

  <!-- ──────────────────────────────────────────
       ÁREA DE CTA INSTITUCIONAL
  ────────────────────────────────────────── -->
  <section class="relative bg-brand-bg3 py-20 px-6 border-t border-white/5 overflow-hidden">
    <div class="absolute inset-0 bg-[linear-gradient(rgba(34,197,94,0.01)_1px,transparent_1px),linear-gradient(90deg,rgba(34,197,94,0.01)_1px,transparent_1px)] bg-[size:40px_40px]"></div>
    <div class="max-w-[800px] mx-auto text-center relative z-10">
      <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-6">
        Adequação elétrica segura para o seu edifício
      </h2>
      <p class="text-brand-muted text-sm sm:text-base leading-relaxed mb-8">
        Trabalhe de forma regular. Solicite agora mesmo um diagnóstico técnico da infraestrutura do seu prédio para instalação homologada de carregadores inteligentes.
      </p>
      <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
        <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-brand-green text-brand-bg font-extrabold px-8 py-4 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20">
          Orçamento no WhatsApp
        </a>
        <a href="contato.php"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border border-white/10 bg-white/5 text-white font-extrabold px-8 py-4 rounded-2xl hover:bg-white/10 transition-all">
          Agendar Reunião Técnica
        </a>
      </div>
    </div>
  </section>

<?php
$additional_scripts = '<script type="module" src="js/pages/artigo.js"></script>';
include "includes/footer.php";
?>
