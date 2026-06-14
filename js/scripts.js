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
    $('.single-button').on('click', function() {
        $('#photo-ref').val($(this).data('photo-ref'));
    });
});

/**/

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