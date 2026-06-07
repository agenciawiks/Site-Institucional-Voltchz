<?php
require_once "includes/db.php";

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$produto = get_produto_by_slug($slug);

if ($produto) {
    $marca = get_marca_by_id($produto['marcaId']);
    $page_title = $produto['nome'] . " | VoltchZ Brasil — Engenharia de Recarga";
    $page_desc = $produto['resumo'];

    // Relacionados
    $db = get_db_connection();
    if ($produto['categoriaId'] === 'suportes') {
        $stmtRel = $db->prepare("SELECT id, slug, nome, marca_id AS marcaId, categoria_id AS categoriaId, resumo, imagem FROM produtos WHERE categoria_id = 'estacoes' AND id != ? LIMIT 3");
    } else {
        $stmtRel = $db->prepare("SELECT id, slug, nome, marca_id AS marcaId, categoria_id AS categoriaId, resumo, imagem FROM produtos WHERE categoria_id = 'suportes' AND id != ? LIMIT 3");
    }
    $stmtRel->execute([$produto['id']]);
    $related_products = $stmtRel->fetchAll();
    
    if (empty($related_products)) {
        $stmtRelFB = $db->prepare("SELECT id, slug, nome, marca_id AS marcaId, categoria_id AS categoriaId, resumo, imagem FROM produtos WHERE marca_id = ? AND id != ? LIMIT 3");
        $stmtRelFB->execute([$produto['marcaId'], $produto['id']]);
        $related_products = $stmtRelFB->fetchAll();
    }
} else {
    $page_title = "Equipamento Não Localizado — VoltchZ Brasil";
    $page_desc = "O equipamento solicitado não consta em nosso catálogo de homologação ativa.";
    $related_products = [];
}

$current_page = "produtos";
include "includes/header.php";
?>

  <!-- ──────────────────────────────────────────
       CORPO PRINCIPAL (FICHA TÉCNICA DO HARDWARE)
  ────────────────────────────────────────── -->
  <main class="pt-28 pb-20 px-6 bg-brand-bg relative min-h-[80vh] z-10">
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
              <a href="produtos.php" class="hover:text-brand-green transition-colors">Produtos</a>
            </div>
          </li>
          <?php if ($produto): ?>
          <li>
            <div class="flex items-center">
              <span class="mx-1 text-white/20">/</span>
              <span id="breadcrumb-brand" class="text-brand-muted/70"><?php echo htmlspecialchars($marca['nome']); ?></span>
            </div>
          </li>
          <li aria-current="page">
            <div class="flex items-center">
              <span class="mx-1 text-white/20">/</span>
              <span id="breadcrumb-current" class="text-white font-black truncate max-w-[150px] sm:max-w-none"><?php echo htmlspecialchars($produto['nome']); ?></span>
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

      <?php if ($produto): ?>
      <!-- Chassis Principal de Detalhe -->
      <div id="product-detail-chassis" class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
        <!-- COLUNA ESQUERDA: Render/Mídia -->
        <div class="lg:col-span-5 flex flex-col gap-6">
          <div class="relative w-full aspect-[4/3] rounded-[32px] overflow-hidden bg-brand-bg2 border border-white/5 shadow-2xl p-6 flex items-center justify-center">
            <div id="product-media-container" class="w-full h-full flex items-center justify-center">
              <?php if (!empty($produto['imagem'])): ?>
                <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="w-full h-full object-contain max-h-[250px] transition-transform duration-500 hover:scale-105">
              <?php else: ?>
                <?php echo generate_technical_svg($produto['categoriaId'], $produto['nome'], $marca['nome']); ?>
              <?php endif; ?>
            </div>
          </div>

          <!-- Caixa de Engenharia Certificada -->
          <div class="p-5 rounded-2xl bg-white/[0.01] border border-white/5 flex items-start gap-4 shadow-xl">
            <div class="text-brand-green mt-0.5 p-2 bg-brand-green/10 rounded-xl">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
              </svg>
            </div>
            <div>
              <h4 class="text-xs font-mono font-bold uppercase tracking-wider text-white mb-1">Qualidade Assegurada VoltchZ</h4>
              <p class="text-xs text-brand-muted leading-relaxed">
                Este equipamento foi homologado e certificado por engenheiros formados pelo ITA (Instituto Tecnológico de Aeronáutica). Projetado seguindo com rigor a NBR 5410 e NBR 17019 brasileiras.
              </p>
            </div>
          </div>
        </div>

        <!-- COLUNA DIREITA: Especificações e Compra -->
        <div class="lg:col-span-7 flex flex-col">
          <!-- Marcas e Categorias -->
          <div class="flex items-center gap-3 mb-4">
            <span id="product-brand-tag" class="px-3 py-1 rounded-lg border border-brand-green/30 bg-brand-green/10 text-[10px] font-mono font-bold uppercase tracking-widest text-brand-green">
              <?php echo htmlspecialchars($marca['nome']); ?>
            </span>
            <span id="product-category-tag" class="text-xs font-mono text-brand-muted/70">
              <?php $cat = get_categoria_by_id($produto['categoriaId']); echo htmlspecialchars($cat['nome']); ?>
            </span>
          </div>

          <!-- Título -->
          <h1 id="product-name" class="text-3xl sm:text-4xl font-extrabold leading-tight tracking-tight text-white mb-4">
            <?php echo htmlspecialchars($produto['nome']); ?>
          </h1>

          <!-- Descrições -->
          <p id="product-desc-long" class="text-brand-muted text-sm sm:text-base leading-relaxed mb-6">
            <?php echo htmlspecialchars($produto['descricao'] ?: $produto['resumo']); ?>
          </p>

          <!-- Seletor de Variações -->
          <?php $has_variations = isset($produto['variacoes']) && count($produto['variacoes']) > 0; ?>
          <div id="variations-section" class="mb-8 <?php echo $has_variations ? '' : 'hidden'; ?> p-5 rounded-2xl bg-white/[0.01] border border-white/5">
            <p class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green mb-3">Modelagem / Variação Técnica</p>
            <div id="variations-container" class="flex flex-col gap-2.5">
              <?php if ($has_variations): ?>
                <?php foreach ($produto['variacoes'] as $index => $v): ?>
                  <button data-sku="<?php echo htmlspecialchars($v['sku']); ?>" 
                          data-desc="<?php echo htmlspecialchars($v['adicionalDesc'] ?: ''); ?>"
                          data-budget-url="<?php echo htmlspecialchars(get_budget_url($produto, $v)); ?>"
                          class="variation-btn <?php echo $index === 0 ? 'active' : ''; ?> px-4 py-3 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-white/20 transition-all text-left flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <span class="text-xs font-bold text-white"><?php echo htmlspecialchars($v['nome']); ?></span>
                    <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-brand-green/80 bg-brand-green/10 border border-brand-green/20 px-2.5 py-0.5 rounded-md self-start sm:self-auto"><?php echo htmlspecialchars($v['sku']); ?></span>
                  </button>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <p id="variation-desc-box" class="text-xs text-brand-muted/80 mt-3 border-t border-white/5 pt-3 leading-relaxed <?php echo ($has_variations && !empty($produto['variacoes'][0]['adicionalDesc'])) ? '' : 'hidden'; ?>">
              <?php if ($has_variations) echo htmlspecialchars($produto['variacoes'][0]['adicionalDesc']); ?>
            </p>
          </div>

          <!-- CTA WhatsApp Dinâmico -->
          <div class="mb-8">
            <a id="budget-whatsapp-btn" href="<?php echo get_budget_url($produto, $has_variations ? $produto['variacoes'][0] : null); ?>" target="_blank" rel="noopener noreferrer"
              class="w-full inline-flex items-center justify-center gap-3 bg-brand-green text-brand-bg text-sm font-bold uppercase tracking-wider px-8 py-4.5 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-brand-green/20 text-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
              Solicitar Orçamento Desta Variação
            </a>
          </div>

          <!-- Tabela de Especificações Físicas (Monoespacada) -->
          <div class="mb-8">
            <p class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green mb-3">Especificações de Engenharia</p>
            <div class="overflow-hidden rounded-2xl border border-white/5 bg-white/[0.01] shadow-2xl">
              <table class="w-full text-left font-mono text-[11px] sm:text-xs border-collapse">
                <tbody id="specs-tbody" class="divide-y divide-white/5">
                  <?php foreach ($produto['especificacoes'] as $key => $val): ?>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                      <td class="p-4 font-bold text-white/40 uppercase tracking-wider w-1/3 border-r border-white/5"><?php echo htmlspecialchars($key); ?></td>
                      <td class="p-4 text-white font-bold"><?php echo htmlspecialchars($val); ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Diferenciais e Vantagens Técnicas -->
          <?php $has_diffs = isset($produto['diferenciais']) && count($produto['diferenciais']) > 0; ?>
          <div id="diferenciais-section" class="<?php echo $has_diffs ? '' : 'hidden'; ?>">
            <p class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green mb-3">Recursos e Diferenciais</p>
            <ul id="diferenciais-list" class="space-y-3 text-brand-muted text-xs sm:text-sm leading-relaxed">
              <?php if ($has_diffs): ?>
                <?php foreach ($produto['diferenciais'] as $diff): ?>
                  <li class="flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-brand-green mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                      <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span><?php echo htmlspecialchars($diff); ?></span>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
            </ul>
          </div>

        </div>
      </div>
      <?php else: ?>
      <!-- Estado Inexistente (Error 404/Empty State) -->
      <div id="product-not-found" class="flex flex-col items-center justify-center text-center max-w-xl mx-auto py-16 px-8 rounded-3xl bg-brand-bg2 border border-white/5 shadow-2xl">
        <div class="w-16 h-16 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mb-6 text-brand-green">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-3">Equipamento Não Localizado</h3>
        <p class="text-sm text-brand-muted leading-relaxed mb-6">
          O equipamento solicitado não consta em nosso catálogo de homologação ativa. Caso necessite de dimensionamento especial ou importação certificada de hardware, consulte nossa engenharia.
        </p>
        <a href="produtos.php" class="inline-flex items-center gap-2 bg-brand-green text-brand-bg text-xs font-black uppercase tracking-widest px-6 py-3.5 rounded-xl hover:brightness-110 active:scale-95 transition-all">
          Retornar ao Catálogo
        </a>
      </div>
      <?php endif; ?>

      <!-- ──────────────────────────────────────────
           SEÇÃO: VOCÊ TAMBÉM PODE PRECISAR
      ────────────────────────────────────────── -->
      <?php if ($produto && !empty($related_products)): ?>
      <section id="related-section" class="mt-20 pt-12 border-t border-white/5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
          <div>
            <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-brand-green">
              Acessórios e Dimensionamento
            </span>
            <h2 class="text-xl sm:text-2xl font-bold text-white mt-1">
              Você também pode precisar
            </h2>
          </div>
          <a href="produtos.php?categoria=suportes" class="text-brand-green text-xs font-bold uppercase tracking-wider hover:underline flex items-center gap-1">
            Ver Todos os Suportes
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
        </div>

        <div id="related-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($related_products as $rp): 
            $rmarca = get_marca_by_id($rp['marcaId']);
          ?>
            <div class="group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[28px] overflow-hidden flex flex-col p-5 backdrop-blur-xl shadow-2xl transition-all duration-300 hover:-translate-y-1.5">
              <!-- Imagem / SVG Mini -->
              <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden bg-brand-bg mb-4 border border-white/5 flex items-center justify-center p-3">
                <?php if (!empty($rp['imagem'])): ?>
                  <img src="<?php echo htmlspecialchars($rp['imagem']); ?>" alt="<?php echo htmlspecialchars($rp['nome']); ?>" class="w-full h-full object-contain max-h-[120px] transition-transform duration-500 group-hover:scale-105">
                <?php else: ?>
                  <?php echo generate_technical_svg($rp['categoriaId'], $rp['nome'], $rmarca['nome']); ?>
                <?php endif; ?>
              </div>
              
              <div class="flex-grow flex flex-col">
                <span class="text-[9px] font-mono font-black uppercase tracking-[0.2em] text-brand-green mb-1.5">
                  <?php echo htmlspecialchars($rmarca['nome']); ?>
                </span>
                <h3 class="text-sm font-bold text-white mb-1.5 leading-tight group-hover:text-brand-green transition-colors line-clamp-1">
                  <?php echo htmlspecialchars($rp['nome']); ?>
                </h3>
                <p class="text-brand-muted text-[11px] leading-relaxed mb-4 line-clamp-2">
                  <?php echo htmlspecialchars($rp['resumo']); ?>
                </p>
                
                <a href="produto-detalhe.php?slug=<?php echo htmlspecialchars($rp['slug']); ?>" 
                  class="mt-auto text-[10px] font-bold uppercase tracking-wider text-center text-brand-bg bg-white py-2 rounded-lg hover:bg-brand-green hover:text-brand-bg transition-all">
                  Ver Detalhes
                </a>
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
        Necessita de uma solução corporativa ou predial sob medida?
      </h2>
      <p class="text-brand-muted text-sm sm:text-base leading-relaxed mb-8">
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

  <!-- Script local para gerenciar a troca de variações na UI local -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const variationButtons = document.querySelectorAll('.variation-btn');
      const descBox = document.getElementById('variation-desc-box');
      const whatsappBtn = document.getElementById('budget-whatsapp-btn');

      variationButtons.forEach(btn => {
        btn.addEventListener('click', () => {
          // Toggle active class
          variationButtons.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');

          // Update description
          const desc = btn.getAttribute('data-desc');
          if (desc && desc.trim() !== '') {
            descBox.textContent = desc;
            descBox.classList.remove('hidden');
          } else {
            descBox.classList.add('hidden');
          }

          // Update whatsapp budget url
          const budgetUrl = btn.getAttribute('data-budget-url');
          if (budgetUrl) {
            whatsappBtn.href = budgetUrl;
          }
        });
      });
    });
  </script>

<?php
include "includes/footer.php";
?>
