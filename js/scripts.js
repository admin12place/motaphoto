/*MODALE DE CONTACT*/
const siteBody = document.querySelector('.customize-support');
const contactModal = document.getElementById('contact-modal');


document.addEventListener('click', (e) => {

    const contactButton = e.target.closest('a[href="#contact"]');
        if(contactButton) {
            e.preventDefault();
            contactModal.classList.remove('hidden');
        return
        }

        if(
            !contactModal.classList.contains('hidden') &&
            !contactModal.contains(e.target)
        ) {
            contactModal.classList.add('hidden');
        }
    });

/*Gestion du menu burger*/

const menuBurger = document.querySelector('.burger');
const menuContainer = document.querySelector('.primary-navigation');

menuBurger.addEventListener('click', () => {
    menuBurger.classList.add('undisplayed');
    menuContainer.classList.add('active');
})

document.addEventListener('click', (e) => {
    if (!menuContainer.contains(e.target)  && !menuBurger.contains(e.target)){
        menuContainer.classList.remove('active');
        menuBurger.classList.remove('undisplayed');
    }
})

/*Pré-remplissage de la référence de la photo en cours sur la modale contact*/

jQuery(function($) {
    if (typeof thisPhotoRef !== 'undefined') {
        $('#photo-ref').val(thisPhotoRef);
    }
    $('.single-button').on('click', function() {
        $('#photo-ref').val($(this).data('photo-ref'));
    });
});

/*Envoi de la requete ajax au serveur, reponse et modif du html*/

jQuery(document).ready(function ($) {

    const container = $('#related-photos');

    if (!container.length) {
        return;
    }

    $.ajax({//Lance la requete ajax
        url: ajax_object.ajax_url,//adresse vers admin-ajax.php definie dans functions.php
        type: 'POST',
        data: {
            action: 'load_related_photos',//appel à la fonction citée
            photo_id: container.data('photo-id'),
            categories: container.data('categories')
        },
        success: function (response) {
            container.html(response);
        }
    });

});

/*Changement d'image au click sur les flèches et apparition des thumbnails*/

const arrowPrec = document.querySelector('.arrow-left');
const arrowSuiv = document.querySelector('.arrow-right');
const photoLength = photoSlugs.length;
const precSuivThumb = document.querySelector('.prec-suiv-thumbnail');

let thisIndex = photoSlugs.indexOf(thisPhotoSlug);

function showPreview(index) {
    precSuivThumb.style.backgroundImage =
        `url(${photoFiles[index]})`;

    precSuivThumb.classList.add('displayed');
}

//gestion de la fleche image précédente
arrowPrec.addEventListener('click', ()=> {
    if (thisIndex > 0) {
        thisIndex--;
    } else {
        thisIndex = photoLength - 1;
    }

    let newSlug = photoSlugs[thisIndex];
    window.location.href = photoUrls[thisIndex];
})

arrowPrec.addEventListener('mouseenter', () => {
    showPreview((thisIndex - 1 + photoLength) % photoLength);
});

arrowPrec.addEventListener('mouseleave', () => {
    precSuivThumb.classList.remove('displayed');
})

//Gestion de la fleche image suivante
arrowSuiv.addEventListener('click', ( )=> {
    if (thisIndex < photoLength - 1) {
        thisIndex++;
    } else {
        thisIndex = 0;
    }

    let newSlug = photoSlugs[thisIndex];
    window.location.href = photoUrls[thisIndex];
})

arrowSuiv.addEventListener('mouseenter', () => {
    showPreview((thisIndex + 1) % photoLength);
});

arrowSuiv.addEventListener('mouseleave', () => {
    precSuivThumb.classList.remove('displayed');
})




