<?php
require_once "includes/db.php";

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$artigo = get_artigo_by_slug($slug);

if ($artigo) {
    $page_title = $artigo['titulo'] . " — VoltchZ Brasil";
    $page_desc = $artigo['resumo'];

    // Artigos Recomendados
    $db = get_db_connection();
    $stmtRec = $db->prepare("
        SELECT id, slug, titulo, categoria, resumo, autor, data_publicacao AS data, tempo_leitura AS tempoLeitura 
        FROM artigos 
        WHERE id != ? 
        ORDER BY (categoria = ?) DESC, id DESC 
        LIMIT 3
    ");
    $stmtRec->execute([$artigo['id'], $artigo['categoria']]);
    $recommended_articles = $stmtRec->fetchAll();
} else {
    $page_title = "Publicação Não Localizada — VoltchZ Brasil";
    $page_desc = "O artigo solicitado não existe ou foi removido de nossa base técnica.";
    $recommended_articles = [];
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
            <a href="index" class="hover:text-brand-green transition-colors">Início</a>
          </li>
          <li>
            <div class="flex items-center">
              <span class="mx-1 text-white/20">/</span>
              <a href="blog" class="hover:text-brand-green transition-colors">Blog</a>
            </div>
          </li>
          <?php if ($artigo): ?>
          <li>
            <div class="flex items-center">
              <span class="mx-1 text-white/20">/</span>
              <a href="blog?categoria=<?php echo urlencode($artigo['categoria']); ?>" class="hover:text-brand-green transition-colors"><?php echo htmlspecialchars($artigo['categoria']); ?></a>
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

          <!-- Perfil do Autor e Botão de Compartilhar -->
          <div class="flex items-center justify-between gap-4 flex-wrap">
            <div class="flex items-center gap-4">
              <img src="static/bruno.webp" alt="Bruno Riêra" loading="lazy"
                class="w-12 h-12 rounded-full object-cover border-2 border-brand-green/30 flex-shrink-0">
              <div>
                <p id="article-author" class="text-sm font-bold text-white leading-tight"><?php echo htmlspecialchars($artigo['autor']); ?></p>
                <p id="article-author-cargo" class="text-[10px] font-mono text-brand-muted/60 uppercase tracking-widest mt-0.5"><?php echo htmlspecialchars($artigo['cargo'] ?: 'Especialista VoltchZ'); ?></p>
              </div>
            </div>
            
            <button id="btn-share-article" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/5 hover:bg-brand-green/10 text-brand-muted hover:text-brand-green border border-white/10 hover:border-brand-green/20 text-xs font-mono font-bold uppercase tracking-wider transition-all duration-300 active:scale-95">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
              Compartilhar
            </button>
          </div>
        </header>

        <!-- Capa Técnica -->
        <div class="relative w-full aspect-[16/5] rounded-[20px] overflow-hidden bg-brand-bg2 border border-white/5 shadow-2xl flex items-center justify-center mb-12">
          <div id="article-media-container" class="w-full h-full flex items-center justify-center">
            <img src="<?php echo !empty($artigo['imagem']) ? $artigo['imagem'] : get_artigo_imagem($artigo['slug']); ?>" alt="<?php echo htmlspecialchars($artigo['titulo']); ?>" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
          </div>
          <!-- Gradient overlay bottom -->
          <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-brand-bg2 to-transparent pointer-events-none"></div>
        </div>

        <!-- Corpo Editorial Reativo -->
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
            <?php elseif ($block['type'] === 'image'): ?>
              <div class="my-8 rounded-3xl overflow-hidden border border-white/5 shadow-2xl observe">
                <img src="<?php echo htmlspecialchars($block['text']); ?>" alt="Imagem do artigo" class="w-full h-auto object-cover max-h-[500px]" loading="lazy">
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
        <a href="blog" class="inline-flex items-center gap-2 bg-brand-green text-brand-bg text-xs font-black uppercase tracking-widest px-6 py-3.5 rounded-xl hover:brightness-110 active:scale-95 transition-all">
          Retornar ao Blog
        </a>
      </div>
      <?php endif; ?>

      <!-- ──────────────────────────────────────────
           SEÇÃO: ARTIGOS RECOMENDADOS (LATERAIS)
      ────────────────────────────────────────── -->
      <?php if ($artigo && !empty($recommended_articles)): ?>
      <section id="recommended-section" class="mt-24 pt-12 border-t border-white/5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
          <div>
            <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-brand-green">
              Leitura Complementar
            </span>
            <h2 class="text-xl sm:text-2xl font-bold text-white mt-1">
              Recomendado para você
            </h2>
          </div>
          <a href="blog" class="text-brand-green text-xs font-bold uppercase tracking-wider hover:underline flex items-center gap-1">
            Ver Todos os Artigos
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
        </div>

        <div id="recommended-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <?php foreach ($recommended_articles as $ra): ?>
            <div class="group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[28px] overflow-hidden flex flex-col p-5 backdrop-blur-xl shadow-2xl transition-all duration-300 hover:-translate-y-1.5 text-left">
              <!-- Capa Técnica -->
              <div class="relative w-full aspect-[16/10] rounded-2xl overflow-hidden bg-brand-bg mb-5 border border-white/5 flex items-center justify-center">
                <img src="<?php echo get_artigo_imagem($ra['slug']); ?>" alt="<?php echo htmlspecialchars($ra['titulo']); ?>" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
              </div>

              <!-- Metadados e Título -->
              <div class="flex-grow flex flex-col">
                <div class="flex items-center justify-between gap-4 mb-3 text-[10px] font-mono text-brand-muted/70">
                  <span class="font-black uppercase tracking-wider text-brand-green">
                    <?php echo htmlspecialchars($ra['categoria']); ?>
                  </span>
                  <div class="flex items-center gap-1.5">
                    <span><?php echo htmlspecialchars($ra['data']); ?></span>
                    <span>•</span>
                    <span><?php echo htmlspecialchars($ra['tempoLeitura']); ?></span>
                  </div>
                </div>

                <h3 class="text-base sm:text-lg font-bold text-white mb-3 leading-snug group-hover:text-brand-green transition-colors line-clamp-2">
                  <a href="blog/<?php echo htmlspecialchars($ra['slug']); ?>"><?php echo htmlspecialchars($ra['titulo']); ?></a>
                </h3>

                <p class="text-brand-muted text-[13px] leading-relaxed mb-6 line-clamp-3">
                  <?php echo htmlspecialchars($ra['resumo']); ?>
                </p>

                <!-- Rodapé do Card (Autor e CTA) -->
                <div class="flex items-center justify-between gap-4 pt-4 border-t border-white/5 mt-auto">
                  <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full border border-white/10 bg-white/5 flex items-center justify-center font-bold text-xs text-brand-green">
                      BR
                    </div>
                    <span class="text-[11px] font-bold text-white"><?php echo htmlspecialchars($ra['autor']); ?></span>
                  </div>

                  <a href="blog/<?php echo htmlspecialchars($ra['slug']); ?>" 
                    class="text-[10px] font-bold uppercase tracking-wider text-brand-bg bg-white px-4 py-2.5 rounded-lg hover:bg-brand-green hover:text-brand-bg transition-all whitespace-nowrap">
                    Ler Artigo
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
      <?php endif; ?>

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
        <a href="contato"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border border-white/10 bg-white/5 text-white font-extrabold px-8 py-4 rounded-2xl hover:bg-white/10 transition-all">
          Agendar Reunião Técnica
        </a>
      </div>
    </div>
  </section>

<?php
include "includes/footer.php";
?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const shareBtn = document.getElementById('btn-share-article');
  if (shareBtn) {
    shareBtn.addEventListener('click', async () => {
      try {
        await navigator.clipboard.writeText(window.location.href);
        const originalText = shareBtn.innerHTML;
        shareBtn.innerHTML = `
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
          Copiado!
        `;
        shareBtn.classList.remove('hover:bg-brand-green/10', 'text-brand-muted', 'hover:text-brand-green', 'border-white/10');
        shareBtn.classList.add('bg-brand-green/20', 'text-brand-green', 'border-brand-green/30');
        setTimeout(() => {
          shareBtn.innerHTML = originalText;
          shareBtn.classList.add('hover:bg-brand-green/10', 'text-brand-muted', 'hover:text-brand-green', 'border-white/10');
          shareBtn.classList.remove('bg-brand-green/20', 'text-brand-green', 'border-brand-green/30');
        }, 2000);
      } catch (err) {
        console.error('Falha ao copiar o link:', err);
      }
    });
  }
});
</script>
