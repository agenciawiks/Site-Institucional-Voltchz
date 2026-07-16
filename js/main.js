/**
 * VoltchZ Brasil - Main Entry Point
 * Orquestra a inicialização de todos os módulos.
 */
import { CONFIG } from './config.js';
import { $, $$ } from './utils/dom.js';
import { handleLeadSubmission } from './utils/forms.js';
import { initHeroCarousel, initClientsCarousel, initStatsCarousel } from './ui/carousel.js';
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
  initStatsCarousel();
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



  console.log('VoltchZ: Sistema inicializado com sucesso.');
});
