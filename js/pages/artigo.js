/**
 * VoltchZ Brasil - Leitor Editorial de Artigo Técnico
 * Processa o slug do artigo, renderiza o conteúdo técnico formatado de forma premium,
 * reescreve metadados de SEO em tempo real e busca leituras complementares recomendadas.
 */

import { ARTIGOS } from '../data/db.js';
import { $, $$ } from '../utils/dom.js';

document.addEventListener('DOMContentLoaded', () => {
  // --- DOM NODES ---
  const readerChassis = $('#article-reader-chassis');
  const notFoundChassis = $('#article-not-found');
  const recommendedSection = $('#recommended-section');
  const recommendedGrid = $('#recommended-grid');

  // --- QUERY PARSING ---
  const params = new URLSearchParams(window.location.search);
  const slug = params.get('slug') || window.location.pathname.split('/').filter(Boolean).pop();

  // --- BUSCAR ARTIGO ---
  const article = ARTIGOS.find(art => art.slug === slug);

  // --- CONTROLLER DE ESTADO ---
  if (!article) {
    // Estado Inexistente (404)
    if (readerChassis) readerChassis.classList.add('hidden');
    if (recommendedSection) recommendedSection.classList.add('hidden');
    if (notFoundChassis) {
      notFoundChassis.classList.remove('hidden');
      notFoundChassis.classList.add('flex');
    }
    
    // Atualizar SEO básico
    document.title = 'Artigo não localizado — VoltchZ Brasil';
    return;
  }

  // Artigo Localizado com Sucesso
  if (notFoundChassis) {
    notFoundChassis.classList.add('hidden');
    notFoundChassis.classList.remove('flex');
  }
  if (readerChassis) {
    readerChassis.classList.remove('hidden');
  }

  // --- PREENCHIMENTO DE BREADCRUMBS ---
  const breadcrumbCategory = $('#breadcrumb-category');
  const breadcrumbCurrent = $('#breadcrumb-current');
  
  if (breadcrumbCategory) {
    breadcrumbCategory.textContent = article.categoria;
    breadcrumbCategory.href = `blog.php?categoria=${encodeURIComponent(article.categoria)}`;
  }
  if (breadcrumbCurrent) {
    breadcrumbCurrent.textContent = article.titulo;
    breadcrumbCurrent.title = article.titulo;
  }

  // --- PREENCHIMENTO DE CABEÇALHO ---
  const categoryTag = $('#article-category-tag');
  const dateField = $('#article-date');
  const readTimeField = $('#article-read-time');
  const titleField = $('#article-title');
  const authorField = $('#article-author');
  const authorCargoField = $('#article-author-cargo');

  if (categoryTag) categoryTag.textContent = article.categoria;
  if (dateField) dateField.textContent = article.data;
  if (readTimeField) readTimeField.textContent = `${article.tempoLeitura} de leitura`;
  if (titleField) titleField.textContent = article.titulo;
  if (authorField) authorField.textContent = article.autor;
  if (authorCargoField) authorCargoField.textContent = article.cargo || 'Diretor de Engenharia';

  // --- INJEÇÃO DA CAPA VETORIAL ---
  const mediaContainer = $('#article-media-container');
  if (mediaContainer && article.imagem) {
    mediaContainer.innerHTML = article.imagem;
  }

  // --- RENDERIZAÇÃO DO CORPO EDITORIAL DINÂMICO ---
  const bodyContent = $('#article-body-content');
  if (bodyContent) {
    bodyContent.innerHTML = '';

    article.conteudo.forEach(item => {
      let blockHtml = '';

      switch (item.type) {
        case 'heading':
          blockHtml = `
            <h2 class="text-xl sm:text-2xl font-extrabold text-white mt-12 mb-5 pl-4 border-l-4 border-brand-green leading-tight observe">
              ${item.text}
            </h2>
          `;
          break;

        case 'paragraph':
          blockHtml = `
            <p class="leading-[1.85] text-brand-muted/90 text-sm sm:text-base mb-7 text-justify sm:text-left observe">
              ${item.text}
            </p>
          `;
          break;

        case 'list':
          blockHtml = `
            <ul class="space-y-3.5 my-6 pl-2 observe">
              ${item.items.map(li => `
                <li class="flex items-start gap-3 text-sm sm:text-base text-brand-muted/95 leading-relaxed">
                  <svg class="w-5 h-5 text-brand-green flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                  </svg>
                  <span>${li}</span>
                </li>
              `).join('')}
            </ul>
          `;
          break;

        case 'blockquote':
          blockHtml = `
            <div class="my-8 p-6 sm:p-8 rounded-3xl bg-brand-bg2 border border-white/5 border-l-4 border-l-brand-green relative overflow-hidden shadow-xl observe">
              <div class="absolute -right-4 -top-8 text-brand-green/5 text-9xl font-serif pointer-events-none select-none">“</div>
              <p class="text-white italic text-base sm:text-lg leading-relaxed relative z-10 mb-4 text-justify sm:text-left">
                "${item.text}"
              </p>
              ${item.author ? `
                <cite class="not-italic text-xs font-mono font-bold uppercase tracking-wider text-brand-green block relative z-10">
                  — ${item.author}
                </cite>
              ` : ''}
            </div>
          `;
          break;
      }

      if (blockHtml) {
        bodyContent.insertAdjacentHTML('beforeend', blockHtml);
      }
    });
  }

  // --- REESCRITA DE METADADOS DE SEO ---
  document.title = `${article.titulo} — VoltchZ Brasil`;

  const descMeta = $('meta[name="description"]');
  if (descMeta) descMeta.setAttribute('content', article.resumo);

  const ogTitle = $('meta[property="og:title"]');
  if (ogTitle) ogTitle.setAttribute('content', `${article.titulo} — VoltchZ Brasil`);

  const ogDesc = $('meta[property="og:description"]');
  if (ogDesc) ogDesc.setAttribute('content', article.resumo);

  // --- RECOMENDAÇÕES (ARTIGOS RELACIONADOS) ---
  const renderRecommended = () => {
    if (!recommendedSection || !recommendedGrid) return;

    // Classificação inteligente de relevância:
    // 1. Prioriza o mesmo tema/categoria (Legislação, Segurança, Infraestrutura, Tecnologia, Mercado)
    // 2. Exclui o artigo atualmente ativo no leitor
    // 3. Ordena decrescente por ID
    const related = ARTIGOS
      .filter(art => art.slug !== article.slug)
      .sort((a, b) => {
        const sameCategoryA = a.categoria === article.categoria ? 1 : 0;
        const sameCategoryB = b.categoria === article.categoria ? 1 : 0;
        
        if (sameCategoryA !== sameCategoryB) {
          return sameCategoryB - sameCategoryA; // 1 (mesma categoria) vem antes de 0
        }
        return b.id - a.id; // Desempate por ID decrescente
      })
      .slice(0, 3);

    if (related.length === 0) {
      recommendedSection.classList.add('hidden');
      return;
    }

    recommendedGrid.innerHTML = '';

    related.forEach(art => {
      const card = document.createElement('div');
      card.className = 'group bg-white/[0.02] border border-white/5 hover:border-brand-green/20 rounded-[28px] overflow-hidden flex flex-col p-5 backdrop-blur-xl shadow-2xl transition-all duration-300 hover:-translate-y-1.5 observe';

      card.innerHTML = `
        <!-- Capa Técnica -->
        <div class="relative w-full aspect-[16/10] rounded-2xl overflow-hidden bg-brand-bg mb-5 border border-white/5 flex items-center justify-center">
          ${art.imagem}
        </div>

        <!-- Metadados e Título -->
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
            <a href="blog/${art.slug}">${art.titulo}</a>
          </h3>

          <p class="text-brand-muted text-[13px] leading-relaxed mb-6 line-clamp-3">
            ${art.resumo}
          </p>

          <!-- Rodapé do Card (Autor e CTA) -->
          <div class="flex items-center justify-between gap-4 pt-4 border-t border-white/5 mt-auto">
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 rounded-full border border-white/10 bg-white/5 flex items-center justify-center font-bold text-xs text-brand-green">
                BR
              </div>
              <span class="text-[11px] font-bold text-white">${art.autor}</span>
            </div>

            <a href="blog/${art.slug}" 
              class="text-[10px] font-bold uppercase tracking-wider text-brand-bg bg-white px-4 py-2.5 rounded-lg hover:bg-brand-green hover:text-brand-bg transition-all whitespace-nowrap">
              Ler Artigo
            </a>
          </div>
        </div>
      `;
      recommendedGrid.appendChild(card);
    });

    recommendedSection.classList.remove('hidden');
  };

  // Executar a renderização de artigos recomendados
  renderRecommended();

  // Re-inicializa observadores de interseção/animação (se houver animações globais ativas)
  if (window.VoltchZ?.initIntersections) {
    window.VoltchZ.initIntersections();
  }
});
