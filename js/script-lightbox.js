
const lightboxMota = document.getElementById('lightbox-container');
const fullScreenIcons = document.querySelectorAll('.dashicons.dashicons-fullscreen-alt');
const closeButton = document.querySelector('.dashicons-no');

fullScreenIcons.forEach(icon => {//ouverture de la lightbox pour chaque image
    icon.addEventListener('click', () => {
        console.log('Element ciblé');
        lightboxMota.classList.remove('undisplayed');
        document.body.style.overflow = 'hidden';
    });
});

closeButton.addEventListener('click', () => {
    lightboxMota.classList.add('undisplayed');
    document.body.style.overflow = '';
});