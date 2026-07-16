/**
 * Lógica dos carrosséis (Hero e Clientes)
 */
import { CONFIG } from '../config.js';
import { $, $$ } from '../utils/dom.js';

class Carousel {
  constructor(containerId, options = {}) {
    this.container = $(`#${containerId}`);
    if (!this.container) return;

    this.slidesSelector = options.slidesSelector || '.carousel-slide';
    this.dotsSelector = options.dotsSelector || '.carousel-dot';
    this.autoplayDelay = options.autoplayDelay || 5000;
    this.currentIdx = 0;
    this.timer = null;

    this.init();
  }

  init() {
    this.goTo(0);
    this.startAutoplay();
    this.bindEvents();
  }

  get slides() { 
    return $$(this.slidesSelector, this.container); 
  }
  
  get dots() { 
    // Se o dotsSelector for apenas uma classe, busca no document ou container
    // Se for um seletor composto, tenta encontrar o container de dots primeiro
    return $$(this.dotsSelector); 
  }

  goTo(idx) {
    const slides = this.slides;
    const dots = this.dots;
    if (slides.length === 0) return;

    // Remove active from current
    slides[this.currentIdx]?.classList.remove('active');
    this.updateDot(this.currentIdx, false);

    // Update index
    this.currentIdx = (idx + slides.length) % slides.length;

    // Add active to new
    slides[this.currentIdx]?.classList.add('active');
    this.updateDot(this.currentIdx, true);

    this.startAutoplay();
  }

  updateDot(idx, active) {
    const dots = this.dots;
    const dot = dots[idx];
    if (!dot) return;

    if (active) {
      dot.classList.add('active', 'bg-white', 'bg-brand-green'); // Suporta ambos os temas
      dot.classList.remove('bg-white/40', 'bg-black/20');
      dot.setAttribute('aria-selected', 'true');
      if (dot.classList.contains('rounded-full')) dot.classList.add('!w-6'); // Slider clientes
    } else {
      dot.classList.remove('active', 'bg-white', 'bg-brand-green', '!w-6');
      dot.classList.add('bg-white/40', 'bg-black/20');
      dot.setAttribute('aria-selected', 'false');
    }
  }

  startAutoplay() {
    this.stopAutoplay();
    this.timer = setInterval(() => this.goTo(this.currentIdx + 1), this.autoplayDelay);
  }

  stopAutoplay() {
    if (this.timer) clearInterval(this.timer);
  }

  bindEvents() {
    // Swipe support
    let touchStartX = 0;
    this.container.addEventListener('touchstart', e => {
      touchStartX = e.changedTouches[0].clientX;
      this.stopAutoplay();
    }, { passive: true });

    this.container.addEventListener('touchend', e => {
      const dx = e.changedTouches[0].clientX - touchStartX;
      if (Math.abs(dx) > 50) this.goTo(dx < 0 ? this.currentIdx + 1 : this.currentIdx - 1);
      this.startAutoplay();
    }, { passive: true });

    // Hover pause
    this.container.addEventListener('mouseenter', () => this.stopAutoplay());
    this.container.addEventListener('mouseleave', () => this.startAutoplay());
  }
}

/**
 * Inicializa o Carrossel de Clientes injetando os slides
 */
export const initClientsCarousel = () => {
  const slider = $('#clients-slider');
  const dotsContainer = $('#client-dots');
  if (!slider) return;

  const images = window.VOLTCHZ_CLIENTS || CONFIG.ASSETS.CLIENTS;

  images.forEach((src, idx) => {
    const slide = document.createElement('div');
    slide.className = 'client-slide' + (idx === 0 ? ' active' : '');
    slide.style.backgroundImage = `url('${src}')`;
    slide.innerHTML = `
      <div class="client-slide-content">
        <span class="inline-block bg-brand-green/90 text-brand-bg text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest mb-2">Projeto Realizado</span>
      </div>
    `;
    
    // Lightbox integration via events instead of global
    slide.addEventListener('click', () => {
      window.dispatchEvent(new CustomEvent('open-lightbox', { detail: { src } }));
    });
    
    slider.appendChild(slide);

    if (dotsContainer) {
      const dot = document.createElement('button');
      dot.className = 'w-2.5 h-2.5 rounded-full bg-black/20 border border-black/10 transition-all focus:outline-none focus:ring-2 focus:ring-brand-green' + (idx === 0 ? ' bg-brand-green !w-6' : '');
      dot.setAttribute('aria-label', `Ir para slide ${idx + 1}`);
      dot.onclick = (e) => { e.stopPropagation(); clientsCarousel.goTo(idx); };
      dotsContainer.appendChild(dot);
    }
  });

  const clientsCarousel = new Carousel('clients-slider', {
    slidesSelector: '.client-slide',
    dotsSelector: '#client-dots button',
    autoplayDelay: CONFIG.ANIMATIONS.AUTOPLAY_CLIENTS
  });

  // Setas
  $('#client-prev')?.addEventListener('click', () => clientsCarousel.goTo(clientsCarousel.currentIdx - 1));
  $('#client-next')?.addEventListener('click', () => clientsCarousel.goTo(clientsCarousel.currentIdx + 1));
};

/**
 * Inicializa o Carrossel Hero
 */
export const initHeroCarousel = () => {
  if (!$('#hero-section')) return;

  const heroCarousel = new Carousel('hero-section', {
    slidesSelector: '.carousel-slide',
    dotsSelector: '.carousel-dot',
    autoplayDelay: CONFIG.ANIMATIONS.AUTOPLAY_HERO
  });

  $('#carousel-prev')?.addEventListener('click', () => heroCarousel.goTo(heroCarousel.currentIdx - 1));
  $('#carousel-next')?.addEventListener('click', () => heroCarousel.goTo(heroCarousel.currentIdx + 1));
  
  $$('.carousel-dot').forEach((dot, i) => {
    dot.addEventListener('click', () => heroCarousel.goTo(i));
  });
};

/**
 * Inicializa o mini carrossel de estatísticas no mobile
 */
export const initStatsCarousel = () => {
  const grid = $('.stats-grid');
  if (!grid) return;

  const totalSlides = grid.children.length;
  if (totalSlides <= 1) return;

  let autoplayInterval;
  let currentActive = 0;

  const startAutoplay = () => {
    stopAutoplay();
    autoplayInterval = setInterval(() => {
      currentActive = (currentActive + 1) % totalSlides;
      const width = grid.clientWidth;
      grid.scrollTo({
        left: currentActive * width,
        behavior: 'smooth'
      });
    }, 3500); // Roda a cada 3.5 segundos
  };

  const stopAutoplay = () => {
    if (autoplayInterval) clearInterval(autoplayInterval);
  };

  // Inicia o autoplay
  startAutoplay();

  grid.addEventListener('scroll', () => {
    const width = grid.clientWidth;
    const scrollLeft = grid.scrollLeft;
    currentActive = Math.round(scrollLeft / width);
  }, { passive: true });

  // Evita propagação dos gestos de touch para o carrossel de fundo (Hero)
  grid.addEventListener('touchstart', (e) => {
    e.stopPropagation();
    stopAutoplay();
  }, { passive: true });

  grid.addEventListener('touchend', (e) => {
    e.stopPropagation();
    startAutoplay();
  }, { passive: true });

  // Pausa autoplay quando o mouse estiver em cima (desktop)
  grid.addEventListener('mouseenter', stopAutoplay);
  grid.addEventListener('mouseleave', startAutoplay);
};
