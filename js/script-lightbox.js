
const lightboxMota = document.getElementById('lightbox-container');
const closeButton = document.querySelector('.dashicons-no');
const gallery = document.getElementById('gallery');

if (gallery) {

    gallery.addEventListener('click', e => { //Déléguation d'événement sur l'ensemble de la gallery

        const fullScreenIcon = e.target.closest('.dashicons-fullscreen-alt');
            if (!fullScreenIcon) return;

        const imageContainer = fullScreenIcon.closest('.single-link')
        
        const imageMarkup = imageContainer.querySelector('.gallery');
        const imageReference = imageMarkup.dataset.reference;
        const imageCategorie = imageMarkup.dataset.categorie;
        const imageSource = imageMarkup.src;
        const imageLightbox = document.querySelector('.img-full');
        imageLightbox.src = imageSource;

        const lightboxImgReference = document.querySelector('.image-ref');
        lightboxImgReference.innerHTML = imageReference;

        const lightboxImgCategorie = document.querySelector('.image-cat');
        lightboxImgCategorie.innerHTML = imageCategorie;

        lightboxMota.classList.remove('undisplayed');
        document.body.style.overflow = 'hidden';
    })
}

closeButton.addEventListener('click', () => {
    lightboxMota.classList.add('undisplayed');
    document.body.style.overflow = '';
});