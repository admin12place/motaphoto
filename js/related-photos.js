/*GESTION DES IMAGES LIKE DE LA SINGLE PAGE


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