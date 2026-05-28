/**
 * Lightbox com foco em performance e acessibilidade
 */
import { $ } from '../utils/dom.js';

export const initLightbox = () => {
  const lightbox = $('#lightbox');
  const lightboxImg = $('#lightbox-img');
  if (!lightbox || !lightboxImg) return;

  const close = () => {
    lightbox.classList.add('hidden');
    lightbox.classList.remove('flex');
    document.body.style.overflow = ''; // Libera scroll
  };

  const open = (src) => {
    lightboxImg.src = src;
    lightbox.classList.remove('hidden');
    lightbox.classList.add('flex');
    document.body.style.overflow = 'hidden'; // Trava scroll
    lightbox.focus(); // Move foco para o modal
  };

  // Eventos de clique
  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox || e.target.closest('button')) close();
  });

  // Acessibilidade: Tecla Esc
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !lightbox.classList.contains('hidden')) {
      close();
    }
  });

  // Escuta evento customizado vindo do carrossel ou outros componentes
  window.addEventListener('open-lightbox', (e) => {
    if (e.detail?.src) open(e.detail.src);
  });
};
