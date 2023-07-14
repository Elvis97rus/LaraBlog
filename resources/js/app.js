import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('livewire:load', function () {
    Livewire.on('scroll-to-top', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
var scrollToTopLink = document.querySelector('.scroll-to-top-link');

window.addEventListener('scroll', function () {
    if (window.scrollY >= 400) {
        scrollToTopLink.classList.remove('hidden');
    } else {
        scrollToTopLink.classList.add('hidden');
    }
});
