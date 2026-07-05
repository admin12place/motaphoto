/*EVENEMENTS DE LA SINGLE PAGE*/


/*Changement d'image au click sur les flèches et apparition des thumbnails*/
document.addEventListener('DOMContentLoaded', () => {

    const arrowPrec = document.querySelector('.arrow-left');
    const arrowSuiv = document.querySelector('.arrow-right');
    const precSuivThumb = document.querySelector('.prec-suiv-thumbnail');
    const mainImage = document.querySelector('.slider-image');

    //Arret de la fonction si les elements n'existent pas
    if (!mainImage || !arrowPrec || !arrowSuiv || !precSuivThumb) {
        return;
    }

    const previousId = arrowPrec.dataset.previousId;
    const nextId = arrowSuiv.dataset.nextId;

    function getPhotoData(postId) {
        return fetch(ajax_object.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'get_photo_data',
                post_id: postId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                throw new Error("Impossible de récupérer la photo.");
            }
            return data.data;
        });
    }

    function showPreview(postId) {
        getPhotoData(postId).then(photo => {
            precSuivThumb.style.backgroundImage = `url("${photo.image}")`;
            precSuivThumb.classList.add('displayed');
        });
    }

    //3 actions sur la flèche précédente
    arrowPrec.addEventListener('click', () => {
        getPhotoData(previousId).then(photo => {
            window.location.href = photo.link;
        });
    });

    arrowPrec.addEventListener('mouseenter', () => {
        showPreview(previousId);
    });
    
    arrowPrec.addEventListener('mouseleave', () => {
        precSuivThumb.classList.remove('displayed');
    });

    //3 actions sur la flèche suivante
    arrowSuiv.addEventListener('click', () => {
        getPhotoData(nextId).then(photo => {
            window.location.href = photo.link;
        });
    });
    
    arrowSuiv.addEventListener('mouseenter', () => {
        showPreview(nextId);
    });
    
    arrowSuiv.addEventListener('mouseleave', () => {
        precSuivThumb.classList.remove('displayed');
    });
});
