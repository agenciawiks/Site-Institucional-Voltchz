/**
 * Navegação, Header, Mobile Menu e Progress Bar
 */
import { $, $$, throttle, handleScrollClasses } from '../utils/dom.js';

export const initNavigation = () => {
  const nav = $('#main-nav');
  const progressBar = $('#progress-bar');
  const logo = nav?.querySelector('img');

  if (!nav) return;

  /**
   * Atualiza o header e a barra de progresso no scroll (Throttled)
   */
  const handleScroll = throttle(() => {
    // 1. Header Styles
    handleScrollClasses(
      nav,
      50,
      ['scrolled', 'backdrop-blur-xl', 'bg-brand-bg/80', 'py-3', 'shadow-2xl'],
      ['py-6', 'bg-transparent']
    );

    if (logo) {
      logo.style.height = window.scrollY > 50 ? '24px' : '32px';
    }

    // 2. Progress Bar
    const winScroll = document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    if (progressBar) progressBar.style.width = `${scrolled}%`;

    // 3. Active Links
    updateActiveLink();
  }, 16); // ~60fps

  window.addEventListener('scroll', handleScroll, { passive: true });

  /**
   * Mobile Menu
   */
  const mobileMenuBtn = $('#mobile-menu-btn');
  const mobileMenu = $('#mobile-menu');

  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.onclick = () => {
      const isOpen = !mobileMenu.classList.contains('hidden');
      mobileMenu.classList.toggle('hidden');
      mobileMenuBtn.setAttribute('aria-expanded', String(!isOpen));
    };
  }

  /**
   * Encontre um Eletroposto Dropdown
   */
  const setupDropdown = (btnId, menuId, iconId, wrapperId) => {
    const btn = $(`#${btnId}`);
    const menu = $(`#${menuId}`);
    const icon = $(`#${iconId}`);
    const wrapper = $(`#${wrapperId}`);

    if (!btn || !menu) return;

    const toggle = (forceClose = false) => {
      const isOpen = forceClose ? true : !menu.classList.contains('hidden');
      if (isOpen) {
        menu.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
        icon?.classList.remove('rotate-180');
      } else {
        menu.classList.remove('hidden');
        btn.setAttribute('aria-expanded', 'true');
        icon?.classList.add('rotate-180');
      }
    };

    btn.onclick = (e) => { e.preventDefault(); toggle(); };
    document.addEventListener('click', (e) => {
      if (wrapper && !wrapper.contains(e.target)) toggle(true);
    });
  };

  setupDropdown('tools-dropdown-btn', 'tools-dropdown-menu', 'tools-dropdown-icon', 'tools-dropdown');
  setupDropdown('mobile-tools-toggle', 'mobile-tools-menu', 'mobile-tools-icon', 'mobile-tools-menu');

  /**
   * Smooth Scroll
   */
  $$('a[href^="#"]').forEach(a => {
    a.onclick = (e) => {
      const href = a.getAttribute('href');
      if (href === '#') return;
      const target = $(href);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        // Close mobile menu if open
        mobileMenu?.classList.add('hidden');
      }
    };
  });
};

function updateActiveLink() {
  const isSobre = window.location.pathname.includes('sobre.php') || window.location.pathname.endsWith('/sobre');
  const sections = isSobre
    ? ['historia', 'proposito', 'diferenciais', 'equipamentos']
    : ['servicos', 'o-que-faz', 'clientes', 'sobre'];

  let current = '';
  sections.forEach(id => {
    const el = $(`#${id}`);
    if (el && window.scrollY >= el.offsetTop - 120) current = id;
  });

  $$('#nav-links a').forEach(a => {
    const href = a.getAttribute('href');
    if (href?.includes('#')) {
      const id = href.split('#')[1];
      a.classList.toggle('active', id === current);
    }
  });
}
