<?php
require_once "includes/db.php";

$marca_filter = isset($_GET['marca']) ? $_GET['marca'] : 'todos';
$cat_filter = isset($_GET['categoria']) ? $_GET['categoria'] : 'todos';
$busca_filter = isset($_GET['busca']) ? $_GET['busca'] : '';

$filtered_products = get_filtered_produtos($marca_filter, $cat_filter, $busca_filter);
$produtos_count = count($filtered_products);

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
      <form method="GET" action="produtos" class="mb-10 max-w-xl mx-auto observe">
        <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($cat_filter); ?>">
        <input type="hidden" name="marca" value="<?php echo htmlspecialchars($marca_filter); ?>">
        <div class="relative">
          <input type="text" name="busca" value="<?php echo htmlspecialchars($busca_filter); ?>" placeholder="Pesquisar por modelo, amperagem, SKU ou característica..."
            class="w-full bg-white/[0.03] border border-white/10 rounded-2xl pl-12 pr-4 py-4 text-[14px] text-brand-text placeholder:text-brand-muted/50 focus:outline-none focus:border-brand-green/50 transition-all shadow-xl">
          <div class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-muted/50">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </div>
        </div>
      </form>

      <!-- Grid de Filtros Laterais/Superiores -->
      <div class="flex flex-col gap-6 mb-12 border-b border-white/5 pb-8 observe">
        <!-- Filtro por Categorias (Chips) -->
        <div>
          <p class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green mb-3">Categorias</p>
          <div class="flex flex-wrap gap-2">
            <a href="?categoria=todos&marca=<?php echo urlencode($marca_filter); ?>&busca=<?php echo urlencode($busca_filter); ?>" 
               class="px-4 py-2 text-xs font-bold rounded-xl border <?php echo $cat_filter === 'todos' ? 'border-brand-green bg-brand-green text-brand-bg' : 'border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20'; ?> transition-all uppercase tracking-wider">
               Todos
            </a>
            <?php foreach (get_categorias() as $cat): ?>
              <a href="?categoria=<?php echo urlencode($cat['id']); ?>&marca=<?php echo urlencode($marca_filter); ?>&busca=<?php echo urlencode($busca_filter); ?>" 
                 class="px-4 py-2 text-xs font-bold rounded-xl border <?php echo $cat_filter === $cat['id'] ? 'border-brand-green bg-brand-green text-brand-bg' : 'border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20'; ?> transition-all uppercase tracking-wider">
                 <?php echo htmlspecialchars($cat['nome']); ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Filtro por Marcas (Chips) -->
        <div>
          <p class="text-xs font-mono font-bold uppercase tracking-wider text-brand-green mb-3">Marcas</p>
          <div class="flex flex-wrap gap-2">
            <a href="?categoria=<?php echo urlencode($cat_filter); ?>&marca=todos&busca=<?php echo urlencode($busca_filter); ?>" 
               class="px-4 py-2 text-xs font-bold rounded-xl border <?php echo $marca_filter === 'todos' ? 'border-brand-green bg-brand-green text-brand-bg' : 'border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20'; ?> transition-all uppercase tracking-wider">
               Todos
            </a>
            <?php foreach (get_marcas() as $b): ?>
              <a href="?categoria=<?php echo urlencode($cat_filter); ?>&marca=<?php echo urlencode($b['id']); ?>&busca=<?php echo urlencode($busca_filter); ?>" 
                 class="px-4 py-2 text-xs font-bold rounded-xl border <?php echo $marca_filter === $b['id'] ? 'border-brand-green bg-brand-green text-brand-bg' : 'border-white/10 bg-white/5 text-brand-muted hover:bg-white/10 hover:border-white/20'; ?> transition-all uppercase tracking-wider">
                 <?php echo htmlspecialchars($b['nome']); ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Indicador de Resultados -->
      <div class="flex items-center justify-between mb-6 text-sm text-brand-muted observe">
        <span>Exibindo <?php echo $produtos_count; ?> <?php echo $produtos_count === 1 ? 'produto' : 'produtos'; ?></span>
        <a href="produtos" class="text-brand-green hover:underline text-xs font-bold uppercase tracking-wider flex items-center gap-1">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
            <path d="M23 4v6h-6M1 20v-6h6"></path>
            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
          </svg>
          Limpar Filtros
        </a>
      </div>

      <!-- Grid de Cards -->
      <div class="relative">
        <?php if (empty($filtered_products)): ?>
          <!-- Estado Vazio (Empty State) -->
          <div id="empty-state" class="flex flex-col items-center justify-center text-center max-w-xl mx-auto py-16 px-8 rounded-3xl bg-brand-bg2 border border-white/5 shadow-2xl">
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
            <a href="contato" class="inline-flex items-center gap-2 bg-brand-green text-brand-bg text-xs font-black uppercase tracking-widest px-6 py-3.5 rounded-xl hover:brightness-110 active:scale-95 transition-all">
              Solicitar Projeto Especial
            </a>
          </div>
        <?php else: ?>
          <div id="products-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 transition-all duration-300">
            <?php foreach ($filtered_products as $p): 
              $marca = get_marca_by_id($p['marcaId']);
              $categoria = get_categoria_by_id($p['categoriaId']);
              $hasVariations = !empty($p['variacoes']) && count($p['variacoes']) > 0;
            ?>
              <div class="fade-item group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[28px] overflow-hidden flex flex-col p-5 backdrop-blur-xl shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <!-- Imagem do Hardware / SVG Fallback -->
                <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden bg-brand-bg mb-5 border border-white/5 flex items-center justify-center p-4">
                  <?php if (!empty($p['imagem'])): ?>
                    <img src="<?php echo htmlspecialchars($p['imagem']); ?>" alt="<?php echo htmlspecialchars($p['nome']); ?>" class="w-full h-full object-contain max-h-[180px] transition-transform duration-500 hover:scale-105">
                  <?php else: ?>
                    <?php echo generate_technical_svg($p['categoriaId'], $p['nome'], $marca['nome']); ?>
                  <?php endif; ?>
                </div>

                <!-- Dados Descritivos -->
                <div class="flex-grow flex flex-col">
                  <div class="flex items-center justify-between gap-4 mb-2">
                    <span class="text-[10px] font-mono font-black uppercase tracking-[0.2em] text-brand-green">
                      <?php echo htmlspecialchars($marca['nome']); ?>
                    </span>
                    <span class="text-[10px] font-mono text-brand-muted/70">
                      <?php echo htmlspecialchars($categoria['nome']); ?>
                    </span>
                  </div>

                  <h3 class="text-lg font-bold text-white mb-2 leading-tight group-hover:text-brand-green transition-colors line-clamp-1">
                    <?php echo htmlspecialchars($p['nome']); ?>
                  </h3>

                  <p class="text-brand-muted text-[13px] leading-relaxed mb-4 flex-grow line-clamp-2 min-h-[38px]">
                    <?php echo htmlspecialchars($p['resumo']); ?>
                  </p>

                  <!-- Especificações Base -->
                  <div class="grid grid-cols-2 gap-2 pt-4 border-t border-white/5 mt-auto text-[11px] font-mono text-brand-muted">
                    <div>
                      <span class="block text-[9px] text-brand-muted/40 uppercase tracking-wider">Potência</span>
                      <span class="font-bold text-white text-ellipsis overflow-hidden whitespace-nowrap block"><?php echo htmlspecialchars($p['potencia'] ?: 'N/A'); ?></span>
                    </div>
                    <div>
                      <span class="block text-[9px] text-brand-muted/40 uppercase tracking-wider">Tensão</span>
                      <span class="font-bold text-white text-ellipsis overflow-hidden whitespace-nowrap block"><?php echo htmlspecialchars($p['tensao'] ?: 'N/A'); ?></span>
                    </div>
                  </div>

                  <!-- Rodapé da Ação -->
                  <div class="flex items-center justify-between gap-4 pt-4 mt-3">
                    <span class="text-[10px] font-mono font-medium text-brand-muted/65">
                      <?php if ($hasVariations): ?>
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-green inline-block mr-1"></span> <?php echo count($p['variacoes']); ?> variações
                      <?php else: ?>
                        <span class="w-1.5 h-1.5 rounded-full bg-white/20 inline-block mr-1"></span> Sem variações
                      <?php endif; ?>
                    </span>
                    <a href="produto/<?php echo htmlspecialchars($p['slug']); ?>" 
                      class="text-xs font-bold uppercase tracking-wider text-brand-bg bg-white px-4 py-2.5 rounded-xl hover:bg-brand-green hover:text-brand-bg transition-all shadow-lg active:scale-95 whitespace-nowrap">
                      Ver Detalhes
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
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
        <a href="viabilidade"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border border-white/10 bg-white/5 text-white font-extrabold px-8 py-4 rounded-2xl hover:bg-white/10 transition-all">
          Estudo de Viabilidade
        </a>
      </div>
    </div>
  </section>

<?php
include "includes/footer.php";
?>
