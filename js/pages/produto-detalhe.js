/**
 * VoltchZ Brasil - Página Interna de Produto (Ficha Técnica & Orçamentos)
 * Lê parâmetros da URL via Query String, preenche a ficha em JetBrains Mono
 * e configura o CTA do WhatsApp com a variação selecionada.
 */

import {
  PRODUTOS,
  getMarcaById,
  getCategoriaById,
  getBudgetUrl,
  generateTechnicalSVG
} from '../data/db.js';
import { $ } from '../utils/dom.js';

document.addEventListener('DOMContentLoaded', () => {
  // --- DOM NODES ---
  const breadcrumbBrand = $('#breadcrumb-brand');
  const breadcrumbCurrent = $('#breadcrumb-current');
  const detailChassis = $('#product-detail-chassis');
  const notFoundChassis = $('#product-not-found');
  const mediaContainer = $('#product-media-container');
  const brandTag = $('#product-brand-tag');
  const categoryTag = $('#product-category-tag');
  const productName = $('#product-name');
  const productDescLong = $('#product-desc-long');
  const specsTbody = $('#specs-tbody');
  const diferenciaisSection = $('#diferenciais-section');
  const diferenciaisList = $('#diferenciais-list');
  const variationsSection = $('#variations-section');
  const variationsContainer = $('#variations-container');
  const variationDescBox = $('#variation-desc-box');
  const whatsappBtn = $('#budget-whatsapp-btn');
  const relatedSection = $('#related-section');
  const relatedGrid = $('#related-grid');

  // --- LEITOR DE SLUG NA URL ---
  const urlParams = new URLSearchParams(window.location.search);
  const slug = urlParams.get('slug');

  if (!slug) {
    show404();
    return;
  }

  // --- SELECIONAR PRODUTO ---
  const product = PRODUTOS.find(p => p.slug === slug);

  if (!product) {
    show404();
    return;
  }

  // --- RENDERIZAR DETALHES ---
  renderProductDetail(product);

  // --- FUNÇÕES AUXILIARES ---

  function show404() {
    if (detailChassis) detailChassis.classList.add('hidden');
    if (notFoundChassis) notFoundChassis.classList.remove('hidden');
    if (breadcrumbCurrent) breadcrumbCurrent.textContent = 'Erro 404';
  }

  function renderProductDetail(p) {
    if (detailChassis) detailChassis.classList.remove('hidden');
    if (notFoundChassis) notFoundChassis.classList.add('hidden');

    const marca = getMarcaById(p.marcaId);
    const categoria = getCategoriaById(p.categoriaId);

    // 1. Atualizar SEO e Breadcrumbs
    document.title = `${p.nome} | VoltchZ Brasil — Engenharia de Recarga`;
    const metaDesc = document.querySelector('meta[name="description"]');
    if (metaDesc) metaDesc.content = p.resumo;

    if (breadcrumbBrand) breadcrumbBrand.textContent = marca.nome;
    if (breadcrumbCurrent) breadcrumbCurrent.textContent = p.nome;

    // 2. Injetar Imagem / SVG Técnico
    if (mediaContainer) {
      if (p.imagem) {
        mediaContainer.innerHTML = `<img src="${p.imagem}" alt="${p.nome}" class="w-full h-full object-contain max-h-[250px] transition-transform duration-500 hover:scale-105">`;
      } else {
        mediaContainer.innerHTML = generateTechnicalSVG(p.categoriaId, p.nome, marca.nome);
      }
    }

    // 3. Atualizar Dados Identidade
    if (brandTag) brandTag.textContent = marca.nome;
    if (categoryTag) categoryTag.textContent = categoria.nome;
    if (productName) productName.textContent = p.nome;
    if (productDescLong) productDescLong.textContent = p.descricao || p.resumo;

    // 4. Preencher Tabela de Especificações (JetBrains Mono)
    if (specsTbody && p.especificacoes) {
      specsTbody.innerHTML = '';
      Object.entries(p.especificacoes).forEach(([key, val]) => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-white/[0.01] transition-all';
        tr.innerHTML = `
          <td class="px-4 py-3.5 text-brand-muted/40 w-1/3 border-r border-white/5 uppercase tracking-wider font-bold text-[10px]">
            ${key}
          </td>
          <td class="px-4 py-3.5 text-white font-semibold">
            ${val}
          </td>
        `;
        specsTbody.appendChild(tr);
      });
    }

    // 5. Preencher Recursos / Diferenciais
    if (diferenciaisSection && diferenciaisList && p.diferenciais && p.diferenciais.length > 0) {
      diferenciaisSection.classList.remove('hidden');
      diferenciaisList.innerHTML = '';
      p.diferenciais.forEach(dif => {
        const li = document.createElement('li');
        li.className = 'flex items-start gap-3';
        li.innerHTML = `
          <span class="text-brand-green mt-1 flex-shrink-0 bg-brand-green/10 p-0.5 rounded">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
          </span>
          <span class="text-brand-text/90">${dif}</span>
        `;
        diferenciaisList.appendChild(li);
      });
    } else {
      if (diferenciaisSection) diferenciaisSection.classList.add('hidden');
    }

    // 6. Configurar Seletor de Variações
    if (p.variacoes && p.variacoes.length > 0) {
      if (variationsSection) variationsSection.classList.remove('hidden');
      if (variationsContainer) {
        variationsContainer.innerHTML = '';
        p.variacoes.forEach((v, index) => {
          const btn = document.createElement('button');
          btn.className = 'variation-btn w-full text-left p-4 rounded-xl border border-white/5 bg-white/[0.01] hover:border-brand-green/20 hover:bg-white/[0.02] transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-3';
          if (index === 0) btn.classList.add('active');

          btn.innerHTML = `
            <span class="text-xs font-bold text-white tracking-wide">${v.nome}</span>
            ${v.sku ? `<span class="text-[9px] font-mono text-brand-muted/40 uppercase tracking-widest bg-white/5 px-2 py-0.5 rounded">${v.sku}</span>` : ''}
          `;

          btn.addEventListener('click', () => {
            document.querySelectorAll('.variation-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            updateActiveVariation(p, v);
          });

          variationsContainer.appendChild(btn);
        });

        // Selecionar a primeira variação por padrão
        updateActiveVariation(p, p.variacoes[0]);
      }
    } else {
      if (variationsSection) variationsSection.classList.add('hidden');
      if (whatsappBtn) {
        whatsappBtn.href = getBudgetUrl(p, null);
      }
    }

    // 7. Carregar Produtos Relacionados ("Você também pode precisar")
    loadRelatedProducts(p);
  }

  function updateActiveVariation(product, variation) {
    // Exibir descrição adicional se existir
    if (variationDescBox && variation.adicionalDesc) {
      variationDescBox.textContent = variation.adicionalDesc;
      variationDescBox.classList.remove('hidden');
    } else if (variationDescBox) {
      variationDescBox.classList.add('hidden');
    }

    // Atualizar WhatsApp link
    if (whatsappBtn) {
      whatsappBtn.href = getBudgetUrl(product, variation);
    }
  }

  function loadRelatedProducts(currentProduct) {
    // Selecionar produtos sugeridos:
    // Se o produto for carregador ou proteção, sugerimos os suportes da VoltchZ (categoria "suportes")
    // Se for suporte, sugerimos estações de carregamento (categoria "estacoes")
    let related = [];
    if (currentProduct.categoriaId === 'suportes') {
      related = PRODUTOS.filter(p => p.categoriaId === 'estacoes');
    } else {
      related = PRODUTOS.filter(p => p.categoriaId === 'suportes');
    }

    // Fallback: se não houver produtos na categoria sugerida, buscar da mesma marca
    if (related.length === 0) {
      related = PRODUTOS.filter(p => p.marcaId === currentProduct.marcaId && p.id !== currentProduct.id);
    }

    // Filtrar para remover o próprio item e limitar em 3
    related = related.filter(p => p.id !== currentProduct.id).slice(0, 3);

    if (related.length === 0) {
      if (relatedSection) relatedSection.classList.add('hidden');
      return;
    }

    if (relatedSection) relatedSection.classList.remove('hidden');
    if (relatedGrid) {
      relatedGrid.innerHTML = '';
      related.forEach(p => {
        const card = document.createElement('div');
        card.className = 'group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[28px] overflow-hidden flex flex-col p-5 backdrop-blur-xl shadow-2xl transition-all duration-300 hover:-translate-y-1.5';
        
        const marca = getMarcaById(p.marcaId);
        const categoria = getCategoriaById(p.categoriaId);
        
        card.innerHTML = `
          <!-- Imagem / SVG Mini -->
          <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden bg-brand-bg mb-4 border border-white/5 flex items-center justify-center p-3">
            ${p.imagem ? `<img src="${p.imagem}" alt="${p.nome}" class="w-full h-full object-contain max-h-[120px] transition-transform duration-500 group-hover:scale-105">` : generateTechnicalSVG(p.categoriaId, p.nome, marca.nome)}
          </div>
          
          <div class="flex-grow flex flex-col">
            <span class="text-[9px] font-mono font-black uppercase tracking-[0.2em] text-brand-green mb-1.5">
              ${marca.nome}
            </span>
            <h3 class="text-sm font-bold text-white mb-1.5 leading-tight group-hover:text-brand-green transition-colors line-clamp-1">
              ${p.nome}
            </h3>
            <p class="text-brand-muted text-[11px] leading-relaxed mb-4 line-clamp-2">
              ${p.resumo}
            </p>
            
            <a href="produto-detalhe.php?slug=${p.slug}" 
              class="mt-auto text-[10px] font-bold uppercase tracking-wider text-center text-brand-bg bg-white py-2 rounded-lg hover:bg-brand-green hover:text-brand-bg transition-all">
              Ver Detalhes
            </a>
          </div>
        `;
        relatedGrid.appendChild(card);
      });
    }
  }
});
