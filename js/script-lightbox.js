
const lightboxMota = document.getElementById('lightbox-container');
const closeButton = document.querySelector('.dashicons-no');
const gallery = document.getElementById('gallery');
const lightboxPhoto = document.querySelector('.image-container');


//fonction recréant la liste des photos affichées
let selectedPhotos = [];
let currentIndex = 0;

function updateSelectedPhotos() {
    selectedPhotos = document.querySelectorAll('.gallery');
}

function displaySelectedPhoto (index) {
    const newImage = selectedPhotos[index];
    
    //lightboxPhoto.innerHTML = '';
    lightboxPhoto.innerHTML = `
        <img class="img-full" src="${newImage.src}" alt="${newImage.dataset.title}">
        <div class="image-details">
            <p class="image-ref">${newImage.dataset.reference}</p>
            <p class="image-cat">${newImage.dataset.categorie}</p>
        </div>
    `;
}

if (gallery) {

    gallery.addEventListener('click', e => { //Déléguation d'événement sur l'ensemble de la gallery
        
        const fullScreenIcon = e.target.closest('.dashicons-fullscreen-alt');
            if (!fullScreenIcon) return;

        updateSelectedPhotos()

        const imageContainer = fullScreenIcon.closest('.single-link')
        const imageReference = imageContainer.querySelector('.gallery').dataset.reference

         selectedPhotos.forEach((selectedPhoto, thisIndex) => {
            if(selectedPhoto.dataset.reference === imageReference) {
                currentIndex = thisIndex;
            }
        })

        displaySelectedPhoto(currentIndex)
        
        lightboxMota.classList.remove('undisplayed');
        document.body.style.overflow = 'hidden';

        
       
    })
}

closeButton.addEventListener('click', () => {
    lightboxMota.classList.add('undisplayed');
    document.body.style.overflow = '';
});

//Flèches précédente et suivante

const rightArrow = document.querySelector('.right-arrow');
const leftArrow = document.querySelector('.left-arrow');

rightArrow.addEventListener('click', () => {
    currentIndex++;
    if (currentIndex > selectedPhotos.length - 1) {
        currentIndex = 0;
    }
    displaySelectedPhoto (currentIndex)
})

leftArrow.addEventListener('click', () => {
    currentIndex--;
    if (currentIndex < 0) {
        currentIndex = selectedPhotos.length - 1;
    }
    displaySelectedPhoto (currentIndex)
})