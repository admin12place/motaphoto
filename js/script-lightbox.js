
const lightboxMota = document.getElementById('lightbox-container');//la lightbox
const closeButton = document.querySelector('.dashicons-no');//icon de fermeture de la lightbox
const gallery = document.getElementById('gallery');//la galerie de la page d'accueil
const lightboxPhoto = document.querySelector('.image-container');//la <div> de l'image de la lightbox

const rightArrow = document.querySelector('.right-arrow');//fleche de droite (avec le text)
const leftArrow = document.querySelector('.left-arrow');//fleche de gauche (avec le texte)

let selectedPhotos = [];
let currentIndex = 0;

//fonction recréant la liste des photos affichées
function updateSelectedPhotos() {
    selectedPhotos = document.querySelectorAll('.gallery');//tableau des photos de la page d'accueil
}

//fonction d'affichage des photos
function displaySelectedPhoto (index) {
    const newImage = selectedPhotos[index];
    
    lightboxPhoto.innerHTML = `
        <img class="img-full" src="${newImage.src}" alt="${newImage.dataset.title}" title="${newImage.dataset.title}">
        <div class="image-details">
            <p class="image-ref">${newImage.dataset.reference}</p>
            <p class="image-cat">${newImage.dataset.categorie}</p>
        </div>
    `;
}

if (gallery) {

    gallery.addEventListener('click', e => { //Délégation d'événement sur l'ensemble de la gallery
        
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

//Fermeture de la lightbox
closeButton.addEventListener('click', () => {
    lightboxMota.classList.add('undisplayed');
    document.body.style.overflow = '';
});

//Flèches précédente et suivante


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

//Lightbox sur la page single

const singleMainImage = document.querySelector('.main-image');
const fullScreen = document.querySelector('.dashicons-fullscreen-alt');

if (singleMainImage) {
    selectedPhotos = [singleMainImage];
    console.log(selectedPhotos)

    fullScreen.addEventListener('click', () => {
        currentIndex = 0;
        displaySelectedPhoto(currentIndex);
        lightboxMota.classList.remove('undisplayed');
        document.body.style.overflow = 'hidden';
        document.querySelectorAll('.left-arrow, .right-arrow, .image-ref, .image-cat')
            .forEach(element => {
                element.style.display = 'none';
            });
    });
}