// Header scroll shadow
const header = document.getElementById('header');
window.addEventListener('scroll', () => {
  header.classList.toggle('scrolled', window.scrollY > 20);
});

// Mobile menu toggle
const menuToggle = document.getElementById('menuToggle');
const nav = document.getElementById('nav');

const ICON_HAMBURGER = '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>';
const ICON_CLOSE = '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';

menuToggle.addEventListener('click', () => {
  nav.classList.toggle('open');
  const isOpen = nav.classList.contains('open');
  menuToggle.setAttribute('aria-label', isOpen ? 'Fermer le menu' : 'Ouvrir le menu');
  menuToggle.innerHTML = isOpen ? ICON_CLOSE : ICON_HAMBURGER;
});

// Close nav on link click
nav.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', () => {
    nav.classList.remove('open');
    menuToggle.innerHTML = ICON_HAMBURGER;
  });
});

// Intersection Observer for fade-up animations
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    }
  });
}, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
