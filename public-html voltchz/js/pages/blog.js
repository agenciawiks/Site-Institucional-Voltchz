/**
 * VoltchZ Brasil - Portal do Blog Técnico
 * Gerencia a listagem, filtros e pesquisa dos artigos editoriais.
 */

import { ARTIGOS } from '../data/db.js';
import { $, $$ } from '../utils/dom.js';

document.addEventListener('DOMContentLoaded', () => {
  // --- DOM NODES ---
  const searchInput = $('#blog-search-input');
  const categoryFilters = $('#blog-category-filters');
  const featuredSection = $('#featured-article-section');
  const featuredContainer = $('#featured-article-container');
  const blogGrid = $('#blog-grid');
  const emptyState = $('#blog-empty-state');
  const resultsCount = $('#blog-results-count');
  const resetBtn = $('#reset-blog-filters');
  const loadingSpinner = $('#blog-loading-spinner');
  const gridTitle = $('#grid-title');

  // --- FILTERS STATE ---
  const state = {
    category: 'todos',
    search: ''
  };

  // --- RENDERIZADOR ---
  const renderBlog = () => {
    if (loadingSpinner) loadingSpinner.classList.remove('hidden');

    setTimeout(() => {
      // 1. Filtragem Inteligente
      const filtered = ARTIGOS.filter(art => {
        // Categoria
        if (state.category !== 'todos' && art.categoria !== state.category) {
          return false;
        }
        // Pesquisa
        if (state.search) {
          const q = state.search.toLowerCase();
          const match = art.titulo.toLowerCase().includes(q) ||
                        art.resumo.toLowerCase().includes(q) ||
                        art.categoria.toLowerCase().includes(q) ||
                        (art.autor && art.autor.toLowerCase().includes(q));
          if (!match) return false;
        }
        return true;
      });

      // 2. Atualizar Contador
      if (resultsCount) {
        resultsCount.textContent = filtered.length === 1 
          ? `Exibindo 1 artigo` 
          : `Exibindo ${filtered.length} artigos`;
      }

      if (loadingSpinner) loadingSpinner.classList.add('hidden');

      // 3. Validar Estado Vazio
      if (filtered.length === 0) {
        if (featuredSection) featuredSection.classList.add('hidden');
        if (blogGrid) blogGrid.classList.add('hidden');
        if (emptyState) emptyState.classList.remove('hidden');
        return;
      }

      if (emptyState) emptyState.classList.add('hidden');
      if (blogGrid) blogGrid.classList.remove('hidden');

      // 4. Separar Destaque vs Grid (Somente quando não há filtros aplicados)
      const hasNoFilters = state.category === 'todos' && !state.search;

      if (hasNoFilters && filtered.length > 0) {
        if (featuredSection) featuredSection.classList.remove('hidden');
        if (gridTitle) gridTitle.textContent = 'Mais Publicações';

        const featured = filtered[0];
        const rest = filtered.slice(1);

        // Injetar Destaque
        if (featuredContainer) {
          featuredContainer.innerHTML = `
            <div class="group relative grid grid-cols-1 lg:grid-cols-12 gap-8 bg-white/[0.01] border border-white/5 hover:border-brand-green/20 rounded-[32px] overflow-hidden p-6 lg:p-8 backdrop-blur-xl shadow-2xl transition-all duration-300">
              <!-- Capa / Imagem Vetorial -->
              <div class="lg:col-span-6 relative aspect-[16/10] lg:aspect-auto rounded-2xl overflow-hidden bg-brand-bg border border-white/5 flex items-center justify-center min-h-[250px]">
                ${featured.imagem}
              </div>

              <!-- Metadados e Texto -->
              <div class="lg:col-span-6 flex flex-col justify-center">
                <div class="flex items-center gap-4 mb-4 text-[10px] font-mono text-brand-muted/70">
                  <span class="px-2.5 py-1 rounded bg-brand-green/10 text-brand-green font-bold uppercase tracking-widest">
                    Destaque · ${featured.categoria}
                  </span>
                  <span>${featured.data}</span>
                  <span>•</span>
                  <span>${featured.tempoLeitura} de leitura</span>
                </div>

                <h3 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight tracking-tight mb-4 group-hover:text-brand-green transition-colors">
                  <a href="artigo.html?slug=${featured.slug}">${featured.titulo}</a>
                </h3>

                <p class="text-brand-muted text-sm leading-relaxed mb-6">
                  ${featured.resumo}
                </p>

                <!-- Autor e Botão -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-6 border-t border-white/5 mt-auto">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full border border-white/10 bg-white/5 flex items-center justify-center font-bold text-sm text-brand-green">
                      BR
                    </div>
                    <div>
                      <p class="text-xs font-bold text-white">${featured.autor}</p>
                      <p class="text-[9px] font-mono text-brand-muted/50 uppercase tracking-widest">${featured.cargo || 'Especialista VoltchZ'}</p>
                    </div>
                  </div>

                  <a href="artigo.html?slug=${featured.slug}" 
                    class="inline-flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-wider text-brand-bg bg-white px-6 py-3.5 rounded-xl hover:bg-brand-green hover:text-brand-bg transition-all active:scale-95 shadow-lg whitespace-nowrap">
                    Ler Artigo Completo
                  </a>
                </div>
              </div>
            </div>
          `;
        }

        // Renderizar Grid Restante
        renderGrid(rest);

      } else {
        // Se houver filtros, joga todos no grid e esconde o destaque
        if (featuredSection) featuredSection.classList.add('hidden');
        if (gridTitle) gridTitle.textContent = 'Resultados Encontrados';
        renderGrid(filtered);
      }
    }, 250);
  };

  // --- COMPILADOR DO GRID ---
  const renderGrid = (articles) => {
    if (!blogGrid) return;
    blogGrid.innerHTML = '';

    articles.forEach(art => {
      const card = document.createElement('div');
      card.className = 'group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[28px] overflow-hidden flex flex-col p-5 backdrop-blur-xl shadow-2xl transition-all duration-300 hover:-translate-y-1.5';
      
      card.innerHTML = `
        <!-- Capa -->
        <div class="relative w-full aspect-[16/10] rounded-2xl overflow-hidden bg-brand-bg mb-5 border border-white/5 flex items-center justify-center">
          ${art.imagem}
        </div>

        <!-- Conteúdo -->
        <div class="flex-grow flex flex-col">
          <div class="flex items-center justify-between gap-4 mb-3 text-[10px] font-mono text-brand-muted/70">
            <span class="font-black uppercase tracking-wider text-brand-green">
              ${art.categoria}
            </span>
            <div class="flex items-center gap-1.5">
              <span>${art.data}</span>
              <span>•</span>
              <span>${art.tempoLeitura}</span>
            </div>
          </div>

          <h3 class="text-base sm:text-lg font-bold text-white mb-3 leading-snug group-hover:text-brand-green transition-colors line-clamp-2">
            <a href="artigo.html?slug=${art.slug}">${art.titulo}</a>
          </h3>

          <p class="text-brand-muted text-[13px] leading-relaxed mb-6 line-clamp-3">
            ${art.resumo}
          </p>

          <!-- Autor e Link -->
          <div class="flex items-center justify-between gap-4 pt-4 border-t border-white/5 mt-auto">
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 rounded-full border border-white/10 bg-white/5 flex items-center justify-center font-bold text-xs text-brand-green">
                BR
              </div>
              <span class="text-[11px] font-bold text-white">${art.autor}</span>
            </div>

            <a href="artigo.html?slug=${art.slug}" 
              class="text-[10px] font-bold uppercase tracking-wider text-brand-bg bg-white px-4 py-2.5 rounded-lg hover:bg-brand-green hover:text-brand-bg transition-all whitespace-nowrap">
              Ler Artigo
            </a>
          </div>
        </div>
      `;
      blogGrid.appendChild(card);
    });
  };

  // --- EVENTOS BINDING ---
  const initEvents = () => {
    // 1. Clicar nas categorias
    if (categoryFilters) {
      categoryFilters.addEventListener('click', (e) => {
        const btn = e.target.closest('button');
        if (!btn) return;

        $$('button', categoryFilters).forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        state.category = btn.getAttribute('data-value');
        renderBlog();
      });
    }

    // 2. Digitar na barra de pesquisa
    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        state.search = e.target.value;
        renderBlog();
      });
    }

    // 3. Resetar filtros
    if (resetBtn) {
      resetBtn.addEventListener('click', () => {
        if (searchInput) searchInput.value = '';
        state.search = '';
        state.category = 'todos';

        if (categoryFilters) {
          $$('button', categoryFilters).forEach(b => {
            b.classList.toggle('active', b.getAttribute('data-value') === 'todos');
          });
        }

        renderBlog();
      });
    }
  };

  // --- INITIALIZE ---
  initEvents();
  renderBlog();
});
