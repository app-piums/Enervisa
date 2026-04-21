import Alpine from 'alpinejs';
import GLightbox from 'glightbox';
import 'glightbox/dist/css/glightbox.min.css';
import { initShader } from './shader.js';
import { initLightningSplit } from './lightning-split.js';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('hero-shader');
    if (canvas) {
        initShader(canvas);
    }

    document.querySelectorAll('[data-lightning-split]').forEach((el) => {
        initLightningSplit(el);
    });

    if (document.querySelector('.glightbox')) {
        GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            openEffect: 'zoom',
            closeEffect: 'fade',
        });
    }

    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('[data-nav-link]');
    if (sections.length && navLinks.length) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const id = entry.target.id;
                        navLinks.forEach((link) => {
                            link.classList.toggle(
                                'text-brand-orange',
                                link.getAttribute('href') === `#${id}`
                            );
                        });
                    }
                });
            },
            { rootMargin: '-40% 0px -55% 0px' }
        );
        sections.forEach((s) => observer.observe(s));
    }
});
