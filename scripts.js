// --- CONFIGURAÇÕES ---
const CONFIG = {
  AUTOPLAY_HERO: 7000,
  AUTOPLAY_CLIENTS: 5000,
  SCROLL_THRESHOLD: 50,
  CLIENTS: [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15], // IDs existentes
  LOGOS: [
    { id: 1, ext: 'svg' },
    { id: 2, ext: 'png' },
    { id: 3, ext: 'png' }
  ]
};

// --- ESTADO GLOBAL ---
const STATE = {
  isMenuOpen: false,
  currentHeroSlide: 0,
  currentClientSlide: 0
};

// --- UTILS ---
const $ = (sel) => document.querySelector(sel);
const $$ = (sel) => document.querySelectorAll(sel);

// --- NAVBAR & SCROLL ---
function initNavbar() {
  const nav = $('#main-nav');
  const progressBar = $('#progress-bar');
  if (!nav) return;

  const updateNav = () => {
    const scrollY = window.scrollY;
    const isScrolled = scrollY > CONFIG.SCROLL_THRESHOLD;

    nav.classList.toggle('scrolled', isScrolled);

    // Update Active Links
    const sections = $$('section[id]');
    let currentSection = '';
    sections.forEach(sec => {
      const top = sec.offsetTop - 120;
      if (scrollY >= top) currentSection = sec.id;
    });

    $$('#nav-links a').forEach(link => {
      const href = link.getAttribute('href');
      if (href.includes('#')) {
        const id = href.split('#')[1];
        link.classList.toggle('active', id === currentSection);
      }
    });

    // Progress Bar
    if (progressBar) {
      const winScroll = document.documentElement.scrollTop;
      const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const scrolled = (winScroll / height) * 100;
      progressBar.style.width = scrolled + '%';
    }
  };

  window.addEventListener('scroll', updateNav, { passive: true });
  updateNav();
}

// --- MOBILE MENU ---
function initMobileMenu() {
  const btn = $('#mobile-menu-btn');
  const overlay = $('#mobile-menu-overlay');
  if (!btn || !overlay) return;

  const toggle = () => {
    STATE.isMenuOpen = !STATE.isMenuOpen;
    overlay.classList.toggle('hidden', !STATE.isMenuOpen);
    document.body.classList.toggle('menu-open', STATE.isMenuOpen);
    
    // Accessibility
    btn.setAttribute('aria-expanded', STATE.isMenuOpen);
  };

  btn.addEventListener('click', (e) => {
    e.stopPropagation();
    toggle();
  });

  overlay.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      if (STATE.isMenuOpen) toggle();
    });
  });

  // Close on escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && STATE.isMenuOpen) toggle();
  });
}

// --- HERO CAROUSEL ---
function initHero() {
  const slides = $$('.carousel-slide');
  const dots = $$('.carousel-dot');
  if (slides.length === 0) return;

  const goTo = (idx) => {
    slides[STATE.currentHeroSlide].classList.remove('active');
    dots[STATE.currentHeroSlide]?.classList.remove('active');
    STATE.currentHeroSlide = (idx + slides.length) % slides.length;
    slides[STATE.currentHeroSlide].classList.add('active');
    dots[STATE.currentHeroSlide]?.classList.add('active');
  };

  setInterval(() => goTo(STATE.currentHeroSlide + 1), CONFIG.AUTOPLAY_HERO);
  $('#carousel-prev')?.addEventListener('click', () => goTo(STATE.currentHeroSlide - 1));
  $('#carousel-next')?.addEventListener('click', () => goTo(STATE.currentHeroSlide + 1));
  dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)));
}

// --- CLIENT SLIDER (DYNAMIC INJECTION) ---
function initClients() {
  const slider = $('#clients-slider');
  const dotsContainer = $('#client-dots');
  if (!slider) return;

  CONFIG.CLIENTS.forEach((id, idx) => {
    const slide = document.createElement('div');
    slide.className = `client-slide ${idx === 0 ? 'active' : ''}`;
    slide.style.backgroundImage = `url('IMAGENS/CLIENTES/cliente-${id}.avif')`;
    slide.innerHTML = `
        <div class="client-slide-content">
          <span class="text-[10px] font-bold uppercase tracking-widest bg-brand-green/90 text-brand-bg px-3 py-1 rounded-full mb-2 inline-block">Instalação Realizada</span>
          <p class="text-xs text-white/60">Sistema VoltchZ Elite • 2024</p>
        </div>
      `;
    slide.addEventListener('click', () => openLightbox(`IMAGENS/CLIENTES/cliente-${id}.avif`));
    slider.appendChild(slide);

    if (dotsContainer) {
      const dot = document.createElement('button');
      dot.className = `client-dot w-2.5 h-2.5 rounded-full bg-white/20 transition-all ${idx === 0 ? 'active' : ''}`;
      dot.addEventListener('click', () => goToClient(idx));
      dotsContainer.appendChild(dot);
    }
  });

  const goToClient = (idx) => {
    const slides = $$('.client-slide');
    const dots = dotsContainer?.querySelectorAll('button');
    if (slides.length === 0) return;

    slides[STATE.currentClientSlide].classList.remove('active');
    dots?.[STATE.currentClientSlide].classList.remove('active');

    STATE.currentClientSlide = (idx + slides.length) % slides.length;

    slides[STATE.currentClientSlide].classList.add('active');
    dots?.[STATE.currentClientSlide].classList.add('active');
  };

  $('#client-prev')?.addEventListener('click', () => goToClient(STATE.currentClientSlide - 1));
  $('#client-next')?.addEventListener('click', () => goToClient(STATE.currentClientSlide + 1));

  setInterval(() => goToClient(STATE.currentClientSlide + 1), CONFIG.AUTOPLAY_CLIENTS);
}

// --- LOGOS SLIDER ---
function initLogos() {
  const container = $('#logos-container');
  if (!container) return;

  CONFIG.LOGOS.forEach(logo => {
    const card = document.createElement('div');
    card.className = 'logo-card group';
    card.innerHTML = `<img src="IMAGENS/LOGOS-CLIENTES/logo-${logo.id}.${logo.ext}" alt="Parceiro ${logo.id}" class="h-10 w-auto opacity-50 group-hover:opacity-100 transition-all grayscale group-hover:grayscale-0">`;
    container.appendChild(card);
  });
}

// --- LIGHTBOX ---
function openLightbox(src) {
  let lb = $('#lightbox');
  if (!lb) {
    lb = document.createElement('div');
    lb.id = 'lightbox';
    lb.className = 'fixed inset-0 z-[200] bg-black/95 backdrop-blur-xl hidden items-center justify-center p-10 cursor-zoom-out';
    lb.innerHTML = `<img id="lightbox-img" src="" class="max-w-full max-h-full rounded-2xl shadow-2xl scale-95 transition-transform duration-500"><button class="absolute top-10 right-10 text-white hover:text-brand-green transition-colors"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>`;
    document.body.appendChild(lb);
    lb.addEventListener('click', () => lb.classList.replace('flex', 'hidden'));
  }
  const img = $('#lightbox-img');
  img.src = src;
  lb.classList.replace('hidden', 'flex');
  setTimeout(() => img.classList.replace('scale-95', 'scale-100'), 10);
}

// --- FORM HANDLING ---
async function handleForm(e) {
  e.preventDefault();
  const form = e.target;
  const btn = form.querySelector('button[type="submit"]');
  const originalText = btn.innerHTML;

  btn.disabled = true;
  btn.innerHTML = `<span class="flex items-center justify-center gap-2">Processando... <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></span>`;

  await new Promise(r => setTimeout(r, 1800));

  const modal = $('#success-modal');
  if (modal) {
    modal.classList.add('active');
    form.reset();
  } else {
    alert('Mensagem enviada com sucesso!');
    form.reset();
  }

  btn.disabled = false;
  btn.innerHTML = originalText;
}

// --- INITIALIZATION ---
document.addEventListener('DOMContentLoaded', () => {
  initNavbar();
  initMobileMenu();
  initHero();
  initClients();
  initLogos();

  $('#contact-form')?.addEventListener('submit', handleForm);
  $('#quick-lead-form')?.addEventListener('submit', handleForm);

  $('.close-modal')?.addEventListener('click', () => $('#success-modal')?.classList.remove('active'));

  // Animation Observer
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });
  $$('.observe').forEach(el => observer.observe(el));
});