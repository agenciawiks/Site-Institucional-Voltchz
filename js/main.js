/**
 * VoltchZ Brasil - Main Entry Point
 * Orquestra a inicialização de todos os módulos.
 */
import { CONFIG } from './config.js';
import { $, $$ } from './utils/dom.js';
import { handleLeadSubmission } from './utils/forms.js';
import { initHeroCarousel, initClientsCarousel } from './ui/carousel.js';
import { initLightbox } from './ui/lightbox.js';
import { initNavigation } from './ui/navigation.js';
import { initFaq, initIntersections } from './ui/animations.js';
import { initPortfolioExpandido } from './ui/portfolio-real.js';


document.addEventListener('DOMContentLoaded', () => {
  // 1. Logo Auto-loader (Garante consistência)
  $$('img[alt="VoltchZ Brasil"]').forEach(img => {
    img.src = CONFIG.ASSETS.DEFAULT_LOGO;
  });

  // 2. UI Components
  initNavigation();
  initHeroCarousel();
  initClientsCarousel();
  initPortfolioExpandido();
  initLightbox();
  initFaq();
  initIntersections();


  // 3. Form Handlers (Centralizado)
  const contactForm = $('#contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', (e) => handleLeadSubmission(e, 'email'));
  }

  const quickLeadForm = $('#quick-lead-form');
  if (quickLeadForm) {
    quickLeadForm.addEventListener('submit', (e) => handleLeadSubmission(e, 'whatsapp'));
  }

  // 4. Logos de Clientes (Injeção dinâmica)
  const logosContainer = $('#logos-container');
  if (logosContainer) {
    CONFIG.ASSETS.LOGOS.forEach((src, idx) => {
      const card = document.createElement('div');
      card.className = 'logo-card';
      card.innerHTML = `
        <img src="${src}" alt="Logo Cliente ${idx + 1}" loading="lazy" decoding="async" class="w-auto object-contain">
      `;
      logosContainer.appendChild(card);
    });
  }

  console.log('VoltchZ: Sistema inicializado com sucesso.');
});
