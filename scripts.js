/**
 * VoltchZ Brasil - Scripts de Interatividade
 * Este arquivo gerencia todas as animações, carrosséis, carregamento dinâmico
 * e lógica de navegação do site.
 */

// ──────────────────────────────────────────
//  LOGO AUTO-LOADER
//  Garante que a logo correta seja carregada em todos os elementos de imagem
// ──────────────────────────────────────────
(function () {
  const logoSrc = 'IMAGENS/logo.png';
  document.querySelectorAll('img[alt="VoltchZ Brasil"]').forEach(img => img.src = logoSrc);
})();

// ──────────────────────────────────────────
//  CLIENTS SLIDER & LIGHTBOX
//  Gerencia o carrossel de fotos de instalações (clientes)
//  e a visualização ampliada (lightbox).
// ──────────────────────────────────────────
(function() {
  const clientImages = [];
  const possibleExtensions = ['jpeg', 'jpg', 'png', 'webp'];
  
  const slider = document.getElementById('clients-slider');
  const dotsContainer = document.getElementById('client-dots');
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  let currentIdx = 0;
  let timer = null;

  /**
   * Varre a pasta IMAGENS/CLIENTES procurando por arquivos cliente-1, cliente-2...
   * Testa múltiplas extensões para garantir compatibilidade.
   */
  async function initClients() {
    if (!slider) return;
    console.log("VoltchZ: Iniciando carregamento de clientes...");

    // Tenta encontrar até 30 imagens na sequência
    for (let i = 1; i <= 30; i++) {
      let foundSrc = null;
      for (const ext of possibleExtensions) {
        const testSrc = `IMAGENS/CLIENTES/cliente-${i}.${ext}`;
        
        const exists = await new Promise((resolve) => {
          const img = new Image();
          img.onload = () => resolve(true);
          img.onerror = () => resolve(false);
          img.src = testSrc;
        });

        if (exists) {
          foundSrc = testSrc;
          console.log(`VoltchZ: Cliente ${i} encontrado: ${testSrc}`);
          break;
        }
      }

      if (foundSrc) {
        const idx = clientImages.length;
        clientImages.push(foundSrc);
        
        // Cria o elemento do Slide
        const slide = document.createElement('div');
        slide.className = 'client-slide' + (idx === 0 ? ' active' : '');
        slide.style.backgroundImage = `url('${foundSrc}')`;
        slide.setAttribute('role', 'group');
        slide.setAttribute('aria-roledescription', 'slide');
        slide.setAttribute('aria-label', `Cliente ${i}`);
        slide.onclick = () => openLightbox(foundSrc);
        slider.appendChild(slide);

        // Cria a bolinha (dot) de navegação correspondente
        if (dotsContainer) {
          const dot = document.createElement('button');
          dot.className = 'w-2.5 h-2.5 rounded-full bg-black/20 border border-black/10 transition-all focus:outline-none focus:ring-2 focus:ring-brand-green' + (idx === 0 ? ' bg-brand-green !w-6' : '');
          dot.setAttribute('aria-label', `Ir para slide ${idx + 1}`);
          dot.onclick = (e) => {
            e.stopPropagation();
            goToSlide(idx);
          };
          dotsContainer.appendChild(dot);
        }
      } else {
        console.log(`VoltchZ: Fim da sequência de clientes no índice ${i}.`);
        break;
      }
    }

    if (clientImages.length > 0) {
      console.log(`VoltchZ: Total de ${clientImages.length} clientes carregados.`);
      startTimer();
      setupControls();
    } else {
      console.warn("VoltchZ: Nenhuma imagem de cliente encontrada em IMAGENS/CLIENTES/");
    }
  }

  // Configura cliques nas setas e gestos de toque
  function setupControls() {
    const prev = document.getElementById('client-prev');
    const next = document.getElementById('client-next');
    if (prev) prev.onclick = (e) => { e.stopPropagation(); goToSlide(currentIdx - 1); };
    if (next) next.onclick = (e) => { e.stopPropagation(); goToSlide(currentIdx + 1); };

    // Suporte a deslize (swipe) em dispositivos móveis
    let touchStartX = 0;
    let touchEndX = 0;

    slider.addEventListener('touchstart', e => {
      touchStartX = e.changedTouches[0].screenX;
      stopTimer();
    }, { passive: true });

    slider.addEventListener('touchend', e => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
      startTimer();
    }, { passive: true });

    function handleSwipe() {
      const threshold = 50;
      if (touchEndX < touchStartX - threshold) goToSlide(currentIdx + 1);
      if (touchEndX > touchStartX + threshold) goToSlide(currentIdx - 1);
    }
  }

  // Muda para um slide específico e atualiza as bolinhas
  function goToSlide(idx) {
    const slides = slider.querySelectorAll('.client-slide');
    const dots = dotsContainer ? dotsContainer.querySelectorAll('button') : [];
    if (slides.length === 0) return;

    slides[currentIdx].classList.remove('active');
    if (dots[currentIdx]) {
      dots[currentIdx].classList.remove('bg-brand-green', '!w-6');
      dots[currentIdx].classList.add('bg-black/20');
    }

    currentIdx = (idx + slides.length) % slides.length;

    slides[currentIdx].classList.add('active');
    if (dots[currentIdx]) {
      dots[currentIdx].classList.add('bg-brand-green', '!w-6');
      dots[currentIdx].classList.remove('bg-black/20');
    }
    
    startTimer();
  }

  // Inicialização e Lightbox
  if (slider) {
    initClients();

    function nextSlide() {
      goToSlide(currentIdx + 1);
    }

    function startTimer() {
      stopTimer();
      timer = setInterval(nextSlide, 5000);
    }

    function stopTimer() {
      if (timer) clearInterval(timer);
    }

    // Funções globais para abrir/fechar o lightbox
    window.openLightbox = (src) => {
      stopTimer();
      lightboxImg.src = src;
      lightbox.classList.remove('hidden');
      lightbox.classList.add('flex');
    };

    window.closeLightbox = () => {
      lightbox.classList.add('hidden');
      lightbox.classList.remove('flex');
      startTimer();
    };
  }

  // ──────────────────────────────────────────
  //  LOGOS AUTO-INJECTION
  //  Insere as logos dos clientes de forma organizada e dinâmica
  // ──────────────────────────────────────────
  async function initLogos() {
    const logosContainer = document.getElementById('logos-container');
    if (!logosContainer) return;

    const possibleLogoExtensions = ['svg', 'png', 'webp', 'jpg'];
    
    // Tenta carregar até 20 logos
    for (let i = 1; i <= 20; i++) {
      let foundLogo = null;
      for (const ext of possibleLogoExtensions) {
        const testPath = `IMAGENS/LOGOS-CLIENTES/logo-${i}.${ext}`;
        const exists = await new Promise(r => {
          const img = new Image();
          img.onload = () => r(true);
          img.onerror = () => r(false);
          img.src = testPath;
        });
        if (exists) {
          foundLogo = testPath;
          break;
        }
      }

      if (foundLogo) {
        const card = document.createElement('div');
        card.className = 'logo-card';
        
        const img = document.createElement('img');
        img.src = foundLogo;
        img.alt = 'Logo Cliente ' + i;
        img.loading = 'lazy';
        img.className = 'w-auto object-contain';
        
        card.appendChild(img);
        logosContainer.appendChild(card);
      } else {
        break; // Para se não encontrar a próxima logo na sequência
      }
    }
  }
  initLogos();
})();

// ──────────────────────────────────────────
//  CAROUSEL (HERO)
//  Lógica do banner principal rotativo do topo
// ──────────────────────────────────────────
(function () {
  const slides = document.querySelectorAll('.carousel-slide');
  const dots = document.querySelectorAll('.carousel-dot');
  const TOTAL = slides.length;
  if (TOTAL === 0) return;

  let current = 0;
  let timer = null;
  const AUTOPLAY_DELAY = 6000;

  const heroSection = document.getElementById('hero-section');
  if (!heroSection) return;

  // Vai para o slide X com transição suave
  function goTo(idx) {
    const prevSlide = slides[current];
    const prevDot = dots[current];
    
    if (prevSlide) prevSlide.classList.remove('active');
    if (prevDot) {
      prevDot.classList.remove('active');
      prevDot.classList.remove('bg-white');
      prevDot.classList.add('bg-white/40');
      prevDot.setAttribute('aria-selected', 'false');
    }

    current = (idx + TOTAL) % TOTAL;

    const nextSlide = slides[current];
    const nextDot = dots[current];

    if (nextSlide) nextSlide.classList.add('active');
    if (nextDot) {
      nextDot.classList.add('active');
      nextDot.classList.add('bg-white');
      nextDot.classList.remove('bg-white/40');
      nextDot.setAttribute('aria-selected', 'true');
    }
  }

  function startAutoplay() {
    stopAutoplay();
    timer = setInterval(() => goTo(current + 1), AUTOPLAY_DELAY);
  }
  function stopAutoplay() {
    if (timer) { clearInterval(timer); timer = null; }
  }

  // Eventos de clique nas setas e bolinhas
  const prevBtn = document.getElementById('carousel-prev');
  const nextBtn = document.getElementById('carousel-next');

  if (prevBtn) prevBtn.addEventListener('click', () => { goTo(current - 1); startAutoplay(); });
  if (nextBtn) nextBtn.addEventListener('click', () => { goTo(current + 1); startAutoplay(); });

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => { goTo(i); startAutoplay(); });
  });

  // Pausa o autoplay ao passar o mouse
  heroSection.addEventListener('mouseenter', stopAutoplay);
  heroSection.addEventListener('mouseleave', startAutoplay);

  // Suporte a swipe no Hero
  let touchStartX = 0;
  heroSection.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].clientX; stopAutoplay(); }, { passive: true });
  heroSection.addEventListener('touchend', e => {
    const dx = e.changedTouches[0].clientX - touchStartX;
    if (Math.abs(dx) > 50) { goTo(dx < 0 ? current + 1 : current - 1); }
    startAutoplay();
  }, { passive: true });

  startAutoplay();
})();

// ──────────────────────────────────────────
//  NAV SCROLL & PROGRESS BAR
//  Controla a transparência do menu e a barra de leitura
// ──────────────────────────────────────────
const nav = document.getElementById('main-nav');
const progressBar = document.getElementById('progress-bar');

if (nav) {
  window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    // Muda o estilo da nav ao rolar
    nav.classList.toggle('scrolled', scrollY > 40);
    updateActiveLink();
    
    // Calcula progresso da leitura da página
    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    if (progressBar) progressBar.style.width = scrolled + "%";
  }, { passive: true });
}

/**
 * Destaca o link do menu correspondente à seção visível na tela.
 * Detecta se estamos na Home ou na página Sobre.
 */
function updateActiveLink() {
  const isSobre = window.location.pathname.includes('sobre.html');
  const sections = isSobre 
    ? ['historia', 'proposito', 'diferenciais', 'equipamentos']
    : ['servicos', 'o-que-faz', 'clientes', 'contato', 'sobre'];
    
  const links = document.querySelectorAll('#nav-links a');
  let current = '';
  
  sections.forEach(id => {
    const el = document.getElementById(id);
    if (el && window.scrollY >= el.offsetTop - 120) current = id;
  });
  
  links.forEach(a => {
    const href = a.getAttribute('href');
    if (href.includes('#')) {
      const id = href.split('#')[1];
      a.classList.toggle('active', id === current);
    }
  });
}

// ──────────────────────────────────────────
//  FAQ ACCORDION
//  Lógica de abrir/fechar as perguntas frequentes
// ──────────────────────────────────────────
window.toggleFaq = function (btn) {
  const item = btn.closest('.faq-item');
  const answer = item.querySelector('.faq-answer');
  const isOpen = item.classList.contains('open');
  
  // Fecha todos os outros antes de abrir o novo
  document.querySelectorAll('.faq-item').forEach(i => {
    i.classList.remove('open');
    i.querySelector('.faq-answer').classList.remove('open');
    i.querySelector('button').setAttribute('aria-expanded', 'false');
  });

  if (!isOpen) {
    item.classList.add('open');
    answer.classList.add('open');
    btn.setAttribute('aria-expanded', 'true');
  }
};

// ──────────────────────────────────────────
//  COUNTER ANIMATION
//  Anima os números (stats) de 0 até o valor final
// ──────────────────────────────────────────
function animateCounters() {
  document.querySelectorAll('.stat-num[data-target]').forEach(el => {
    const target = parseInt(el.dataset.target);
    const prefix = el.dataset.prefix || '';
    const start = performance.now();
    const dur = 1800;
    function tick(now) {
      const p = Math.min((now - start) / dur, 1);
      const eased = 1 - Math.pow(1 - p, 3);
      el.textContent = prefix + Math.floor(eased * target);
      if (p < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  });
}

// ──────────────────────────────────────────
//  INTERSECTION OBSERVER
//  Gerencia animações de fade-in quando os elementos entram na tela
// ──────────────────────────────────────────
const io = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add('in-view');
      e.target.style.opacity = '1';
      e.target.style.transform = 'translateY(0)';
      io.unobserve(e.target);
    }
  });
}, { threshold: .1, rootMargin: '0px 0px -50px 0px' });

// Registra todos os elementos com classe .observe para serem animados
document.querySelectorAll('.observe').forEach(el => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(24px)';
  el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
  io.observe(el);
});

// Gatilho para iniciar contadores apenas quando visíveis
const statsEl = document.querySelector('.stats-grid');
if (statsEl) {
  const counterIO = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) { 
      animateCounters(); 
      counterIO.disconnect(); 
    }
  }, { threshold: .3 });
  counterIO.observe(statsEl);
}

// ──────────────────────────────────────────
//  SMOOTH SCROLL
//  Suaviza a rolagem para âncoras internas
// ──────────────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const href = a.getAttribute('href');
    if (href === '#') return;
    const target = document.querySelector(href);
    if (target) { 
      e.preventDefault(); 
      target.scrollIntoView({ behavior: 'smooth', block: 'start' }); 
    }
  });
});

// ──────────────────────────────────────────
//  MOBILE MENU TOGGLE
//  Abre e fecha o menu hamburguer no mobile
// ──────────────────────────────────────────
window.toggleMobileMenu = function() {
    const menu = document.getElementById('mobile-menu');
    if (menu) {
        menu.classList.toggle('hidden');
    }
}
