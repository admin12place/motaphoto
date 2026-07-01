/*EVENEMENTS DE LA SINGLE PAGE*/


/*Changement d'image au click sur les flèches et apparition des thumbnails*/
document.addEventListener('DOMContentLoaded', () => {

    const arrowPrec = document.querySelector('.arrow-left');
    const arrowSuiv = document.querySelector('.arrow-right');
    const precSuivThumb = document.querySelector('.prec-suiv-thumbnail');

    //Arret de la fonction si les elements n'existent pas
    if (!arrowPrec || !arrowSuiv || !precSuivThumb) {
        return;
    }

    const photoLength = photoSlugs.length;
    let thisIndex = photoSlugs.indexOf(thisPhotoSlug);

    function showPreview(index) {
        precSuivThumb.style.backgroundImage =
            `url(${photoFiles[index]})`;

        precSuivThumb.classList.add('displayed');
    }

    //3 events sur la fleche precedente
    arrowPrec.addEventListener('click', ()=> {
        thisIndex = (thisIndex > 0) ? thisIndex - 1 : photoLength - 1;
        window.location.href = photoUrls[thisIndex];
    });

    arrowPrec.addEventListener('mouseenter', () => {
        showPreview((thisIndex - 1 + photoLength) % photoLength);
    });

    arrowPrec.addEventListener('mouseleave', () => {
        precSuivThumb.classList.remove('displayed');
    });

    //3 events sur la fleche suivante
    arrowSuiv.addEventListener('click', ()=> {
        thisIndex = (thisIndex < photoLength - 1) ? thisIndex + 1 : 0;
        window.location.href = photoUrls[thisIndex];
    });

    arrowSuiv.addEventListener('mouseenter', () => {
        showPreview((thisIndex + 1) % photoLength);
    });

    arrowSuiv.addEventListener('mouseleave', () => {
        precSuivThumb.classList.remove('displayed');
    });
});
