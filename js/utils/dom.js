/**
 * Utilitários para manipulação do DOM de forma segura e performática
 */

/**
 * Throttle function to limit execution frequency
 */
export const throttle = (fn, wait) => {
  let time = Date.now();
  return function() {
    if ((time + wait - Date.now()) < 0) {
      fn();
      time = Date.now();
    }
  }
};

/**
 * Debounce function
 */
export const debounce = (func, wait) => {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
};

/**
 * Safe query selector
 */
export const $ = (selector, context = document) => context.querySelector(selector);
export const $$ = (selector, context = document) => Array.from(context.querySelectorAll(selector));

/**
 * Toggle classes based on scroll position
 */
export const handleScrollClasses = (el, threshold, classesToAdd, classesToRemove) => {
  if (!el) return;
  const isScrolled = window.scrollY > threshold;
  
  if (isScrolled) {
    el.classList.add(...classesToAdd);
    el.classList.remove(...classesToRemove);
  } else {
    el.classList.remove(...classesToAdd);
    el.classList.add(...classesToRemove);
  }
  return isScrolled;
};
