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

/*Pré-remplissage de la référence de la photo en cours*/

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

    $.ajax({
        url: ajax_object.ajax_url,
        type: 'POST',
        data: {
            action: 'load_related_photos',
            photo_id: container.data('photo-id'),
            categories: container.data('categories')
        },
        success: function (response) {
            container.html(response);
        }
    });

});

/*Changement d'image au click sur les flèches*/

const arrowPrec = document.querySelector('.arrow-left');
const arrowSuiv = document.querySelector('.arrow-right');
const photoLength = photoSlugs.length;

let thisIndex = photoSlugs.indexOf(thisPhotoSlug);

arrowPrec.addEventListener('click', ( )=> {
    if (thisIndex > 0) {
        thisIndex--;
    } else {
        thisIndex = photoLength - 1;
    }

    let newSlug = photoSlugs[thisIndex];
    window.location.href = photoUrls[thisIndex];
})

arrowSuiv.addEventListener('click', ( )=> {
    if (thisIndex < photoLength - 1) {
        thisIndex++;
    } else {
        thisIndex = 0;
    }

    let newSlug = photoSlugs[thisIndex];
    window.location.href = photoUrls[thisIndex];
})
