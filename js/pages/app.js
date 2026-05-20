/**
 * VoltchZ Brasil — App Mobile Page Controller
 * Inicializa animações e IntersectionObserver da página App.
 */

import { $ } from '../utils/dom.js';

document.addEventListener('DOMContentLoaded', () => {
  // Intersection Observer para animações .observe
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(el => {
      if (el.isIntersecting) {
        el.target.classList.add('in-view');
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

  document.querySelectorAll('.observe').forEach(el => observer.observe(el));

  // Staggered animation for grid items
  document.querySelectorAll('.observe-stagger').forEach((el, i) => {
    el.style.transitionDelay = `${i * 80}ms`;
    observer.observe(el);
  });

  // Animated counters
  const counters = document.querySelectorAll('[data-counter]');
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const target = parseInt(el.dataset.counter);
        const suffix = el.dataset.suffix || '';
        let current = 0;
        const increment = target / 60;
        const timer = setInterval(() => {
          current += increment;
          if (current >= target) {
            current = target;
            clearInterval(timer);
          }
          el.textContent = Math.floor(current).toLocaleString('pt-BR') + suffix;
        }, 16);
        counterObserver.unobserve(el);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach(el => counterObserver.observe(el));

  // Placeholder se a imagem do mockup não existir
  const mockupImg = document.querySelector('#mockup-slot img');
  const mockupSlot = document.getElementById('mockup-slot');
  if (mockupImg && mockupSlot && !mockupImg.complete) {
    mockupImg.addEventListener('error', () => mockupSlot.classList.add('is-empty'));
  } else if (mockupImg?.naturalWidth === 0 && mockupSlot) {
    mockupSlot.classList.add('is-empty');
  }
});
