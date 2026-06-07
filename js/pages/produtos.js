/**
 * VoltchZ Brasil - Página de Produtos/Catálogo
 * Orquestra os filtros, buscas e a renderização dinâmica de cards com mock técnico.
 */

import {
  MARCAS,
  CATEGORIAS,
  PRODUTOS,
  getMarcaById,
  getCategoriaById,
  filterProducts,
  generateTechnicalSVG
} from '../data/db.js';
import { $, $$ } from '../utils/dom.js';

document.addEventListener('DOMContentLoaded', () => {
  // --- DOM NODES ---
  const categoryContainer = $('#category-filters');
  const brandContainer = $('#brand-filters');
  const searchInput = $('#search-input');
  const productsGrid = $('#products-grid');
  const emptyState = $('#empty-state');
  const resultsCount = $('#results-count');
  const resetBtn = $('#reset-filters');
  const loadingSpinner = $('#loading-spinner');

  // --- CONTROLE DE FILTROS ---
  const currentFilters = {
    category: 'todos',
    brand: 'todos',
    busca: ''
  };

  // --- DYNAMIC FILTERS SETUP ---
  const setupFilterChips = () => {
    // 1. Popular Categorias
    if (categoryContainer) {
      CATEGORIAS.forEach(cat => {
        const btn = document.createElement('button');
        btn.setAttribute('data-value', cat.id);
        btn.className = 'filter-btn px-4 py-2 text-xs font-bold rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider';
        btn.textContent = cat.nome;
        categoryContainer.appendChild(btn);
      });
    }

    // 2. Popular Marcas
    if (brandContainer) {
      MARCAS.forEach(brand => {
        const btn = document.createElement('button');
        btn.setAttribute('data-value', brand.id);
        btn.className = 'filter-btn px-4 py-2 text-xs font-bold rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-white/20 transition-all uppercase tracking-wider';
        btn.textContent = brand.nome;
        brandContainer.appendChild(btn);
      });
    }
  };

  // --- RENDERIZADOR DE CARDS ---
  const renderGrid = () => {
    // 1. Mostrar Spinner
    if (loadingSpinner) loadingSpinner.classList.remove('hidden');

    // Simular latência de rede amigável (250ms) para melhorar a percepção de UX premium
    setTimeout(() => {
      // 2. Filtrar Produtos
      const filtered = filterProducts({
        marca: currentFilters.brand,
        categoria: currentFilters.category,
        busca: currentFilters.busca
      });

      // 3. Atualizar Contador
      if (resultsCount) {
        const total = filtered.length;
        resultsCount.textContent = total === 1 
          ? `Exibindo 1 produto` 
          : `Exibindo ${total} produtos`;
      }

      // 4. Esconder Spinner
      if (loadingSpinner) loadingSpinner.classList.add('hidden');

      // 5. Validar estado vazio
      if (filtered.length === 0) {
        if (productsGrid) productsGrid.classList.add('hidden');
        if (emptyState) emptyState.classList.remove('hidden');
        return;
      }

      if (productsGrid) productsGrid.classList.remove('hidden');
      if (emptyState) emptyState.classList.add('hidden');

      // 6. Gerar os HTML Cards
      if (productsGrid) {
        productsGrid.innerHTML = '';
        
        filtered.forEach(p => {
          const card = document.createElement('div');
          card.className = 'fade-item group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[28px] overflow-hidden flex flex-col p-5 backdrop-blur-xl shadow-2xl transition-all duration-300 hover:-translate-y-2';
          
          const marca = getMarcaById(p.marcaId);
          const categoria = getCategoriaById(p.categoriaId);
          const hasVariations = p.variacoes && p.variacoes.length > 0;
          
          card.innerHTML = `
            <!-- Imagem / SVG do Hardware Técnico -->
            <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden bg-brand-bg mb-5 border border-white/5 flex items-center justify-center p-3">
              ${p.imagem ? `<img src="${p.imagem}" alt="${p.nome}" class="w-full h-full object-contain max-h-[150px] transition-transform duration-500 group-hover:scale-105">` : generateTechnicalSVG(p.categoriaId, p.nome, marca.nome)}
            </div>

            <!-- Dados Descritivos -->
            <div class="flex-grow flex flex-col">
              <div class="flex items-center justify-between gap-4 mb-2">
                <span class="text-[10px] font-mono font-black uppercase tracking-[0.2em] text-brand-green">
                  ${marca.nome}
                </span>
                <span class="text-[10px] font-mono text-brand-muted/70">
                  ${categoria.nome}
                </span>
              </div>

              <h3 class="text-lg font-bold text-white mb-2 leading-tight group-hover:text-brand-green transition-colors line-clamp-1">
                ${p.nome}
              </h3>

              <p class="text-brand-muted text-[13px] leading-relaxed mb-4 flex-grow line-clamp-2 min-h-[38px]">
                ${p.resumo}
              </p>

              <!-- Especificações Base -->
              <div class="grid grid-cols-2 gap-2 pt-4 border-t border-white/5 mt-auto text-[11px] font-mono text-brand-muted">
                <div>
                  <span class="block text-[9px] text-brand-muted/40 uppercase tracking-wider">Potência</span>
                  <span class="font-bold text-white text-ellipsis overflow-hidden whitespace-nowrap block">${p.potencia || 'N/A'}</span>
                </div>
                <div>
                  <span class="block text-[9px] text-brand-muted/40 uppercase tracking-wider">Tensão</span>
                  <span class="font-bold text-white text-ellipsis overflow-hidden whitespace-nowrap block">${p.tensao || 'N/A'}</span>
                </div>
              </div>

              <!-- Rodapé da Ação -->
              <div class="flex items-center justify-between gap-4 pt-4 mt-3">
                <span class="text-[10px] font-mono font-medium text-brand-muted/65">
                  ${hasVariations 
                    ? `<span class="w-1.5 h-1.5 rounded-full bg-brand-green inline-block mr-1"></span> ${p.variacoes.length} variações` 
                    : `<span class="w-1.5 h-1.5 rounded-full bg-white/20 inline-block mr-1"></span> Sem variações`}
                </span>
                <a href="produto-detalhe.php?slug=${p.slug}" 
                  class="text-xs font-bold uppercase tracking-wider text-brand-bg bg-white px-4 py-2.5 rounded-xl hover:bg-brand-green hover:text-brand-bg transition-all shadow-lg active:scale-95 whitespace-nowrap">
                  Ver Detalhes
                </a>
              </div>
            </div>
          `;
          
          productsGrid.appendChild(card);
        });
      }
    }, 250);
  };

  // --- BIND DE EVENTOS ---
  const initEvents = () => {
    // 1. Clicar em filtros de categoria
    if (categoryContainer) {
      categoryContainer.addEventListener('click', (e) => {
        const btn = e.target.closest('button');
        if (!btn) return;

        $$('button', categoryContainer).forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        currentFilters.category = btn.getAttribute('data-value');
        renderGrid();
      });
    }

    // 2. Clicar em filtros de marca
    if (brandContainer) {
      brandContainer.addEventListener('click', (e) => {
        const btn = e.target.closest('button');
        if (!btn) return;

        $$('button', brandContainer).forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        currentFilters.brand = btn.getAttribute('data-value');
        renderGrid();
      });
    }

    // 3. Digitar na barra de busca
    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        currentFilters.busca = e.target.value;
        renderGrid();
      });
    }

    // 4. Botão de limpar/resetar filtros
    if (resetBtn) {
      resetBtn.addEventListener('click', () => {
        if (searchInput) searchInput.value = '';
        currentFilters.busca = '';
        currentFilters.category = 'todos';
        currentFilters.brand = 'todos';

        // Resetar botões ativos de categoria
        if (categoryContainer) {
          $$('button', categoryContainer).forEach(b => {
            b.classList.toggle('active', b.getAttribute('data-value') === 'todos');
          });
        }

        // Resetar botões ativos de marca
        if (brandContainer) {
          $$('button', brandContainer).forEach(b => {
            b.classList.toggle('active', b.getAttribute('data-value') === 'todos');
          });
        }

        renderGrid();
      });
    }
  };

  // --- EXECUÇÃO ---
  setupFilterChips();
  initEvents();
  renderGrid();
});
