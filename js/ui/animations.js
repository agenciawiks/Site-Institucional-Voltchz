/**
 * Animações de entrada, contadores e FAQ
 */
import { $, $$ } from '../utils/dom.js';

/**
 * Inicializa FAQ Accordion
 */
export const initFaq = () => {
  $$('.faq-item button').forEach(btn => {
    btn.onclick = () => {
      const item = btn.closest('.faq-item');
      const answer = $('.faq-answer', item);
      const isOpen = item.classList.contains('open');

      // Fecha outros
      $$('.faq-item').forEach(i => {
        i.classList.remove('open');
        $('.faq-answer', i)?.classList.remove('open');
        $('button', i)?.setAttribute('aria-expanded', 'false');
      });

      if (!isOpen) {
        item.classList.add('open');
        answer?.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
      }
    };
  });
};

/**
 * Animação de contadores numéricos
 */
const animateCounters = () => {
  $$('.stat-num[data-target]').forEach(el => {
    const target = parseInt(el.dataset.target);
    const prefix = el.dataset.prefix || '';
    const start = performance.now();
    const duration = 1800;

    const tick = (now) => {
      const p = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - p, 3); // Ease out cubic
      el.textContent = prefix + Math.floor(eased * target);
      if (p < 1) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
  });
};

/**
 * Intersection Observer para fade-ins e gatilho de contadores
 */
export const initIntersections = () => {
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('in-view');
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

  $$('.observe').forEach(el => io.observe(el));

  // Gatilho para contadores
  const statsEl = $('.stats-grid');
  if (statsEl) {
    const counterIO = new IntersectionObserver((entries) => {
      if (entries[0].isIntersecting) {
        animateCounters();
        counterIO.disconnect();
      }
    }, { threshold: 0.3 });
    counterIO.observe(statsEl);
  }
};
