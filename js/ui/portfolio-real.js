/**
 * VoltchZ Brasil - Portfólio Real Expandido
 * Controla os filtros de exibição de cards do portfólio (SSR) e a navegação dos carrosséis internos de imagem.
 */

import { $ } from '../utils/dom.js';

export const initPortfolioExpandido = () => {
    const gridVeiculos = $('#portfolio-grid-expandido');
    const tabsContainer = $('#portfolio-tabs-expandido');
    if (!gridVeiculos) return;

    const cards = gridVeiculos.querySelectorAll('.portfolio-card');

    // Forca um reflow/repaint nos cards logo apos o carregamento.
    // Alguns navegadores mobile deixam de pintar os cards ate que algo
    // force um recalculo de layout (o mesmo efeito que clicar num filtro
    // causa via card.style.display). Reproduzimos isso automaticamente.
    cards.forEach(card => {
        card.style.display = 'none';
        void card.offsetHeight;
        card.style.display = '';
    });

    // 1. Inicializa Filtros de Abas (Tabs)
    if (tabsContainer) {
        tabsContainer.querySelectorAll('.portfolio-tab-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove as classes ativas de todas as abas
                tabsContainer.querySelectorAll('.portfolio-tab-btn').forEach(b => {
                    b.classList.remove('border-brand-green', 'bg-brand-green', 'text-brand-bg');
                    b.classList.add('border-white/10', 'bg-white/5', 'text-brand-muted');
                });

                // Adiciona classe ativa no botão clicado
                btn.classList.add('border-brand-green', 'bg-brand-green', 'text-brand-bg');
                btn.classList.remove('border-white/10', 'bg-white/5', 'text-brand-muted');

                const filter = btn.getAttribute('data-filter');

                // Exibe/oculta cards de acordo com o filtro
                cards.forEach(card => {
                    const cardBrand = card.getAttribute('data-brand');
                    if (filter === 'all' || cardBrand === filter) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }

    // 2. Inicializa os Carrosséis Internos de Imagens
    cards.forEach(card => {
        const container = card.querySelector('.carousel-images-container');
        if (!container) return; // Se não tem carrossel múltiplo, pula

        const indicators = card.querySelectorAll('.carousel-indicator');
        const prevBtn = card.querySelector('.carousel-prev-btn');
        const nextBtn = card.querySelector('.carousel-next-btn');
        const imgElements = container.querySelectorAll('.btn-open-lightbox');
        const count = imgElements.length;

        let activeIdx = 0;

        const updateCarousel = () => {
            container.style.transform = `translateX(-${activeIdx * 100}%)`;
            indicators.forEach((ind, i) => {
                if (i === activeIdx) {
                    ind.classList.add('bg-brand-green', 'w-3');
                    ind.classList.remove('bg-white/45');
                } else {
                    ind.classList.remove('bg-brand-green', 'w-3');
                    ind.classList.add('bg-white/45');
                }
            });
        };

        if (prevBtn) {
            prevBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                activeIdx = (activeIdx === 0) ? count - 1 : activeIdx - 1;
                updateCarousel();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                activeIdx = (activeIdx === count - 1) ? 0 : activeIdx + 1;
                updateCarousel();
            });
        }
    });

    // 3. Inicializa Cliques para Abrir Lightbox
    gridVeiculos.querySelectorAll('.btn-open-lightbox').forEach(el => {
        el.addEventListener('click', (e) => {
            e.stopPropagation();
            const src = el.getAttribute('data-src');
            if (src) {
                window.dispatchEvent(new CustomEvent('open-lightbox', { detail: { src } }));
            }
        });
    });
};
