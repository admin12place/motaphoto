/*ÉVÉNEMENTS SUR LA GALERIE, PAGINATION ET CONTRÔLES DE TRI ET FILTRES*/

//Gestion du bouton de fin de galerie
function endMorePhotosButton (paged, maxPages, button) {
    if (paged >= maxPages) {
        button.disabled = true;
        button.innerHTML = 'Terminé';
    } else {
        button.disabled = false;
        button.innerHTML = 'Chargez plus';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    
    //initialisation de toutes les constantes
    const button = document.querySelector('.more-photos');
    const gallery = document.getElementById('gallery');
    const categorieSelect = document.getElementById('categories-search');
    const formatSelect = document.getElementById('formats-search');
    const sortSelect = document.getElementById('sort-photos');

    let sortSearchState = {
        paged: 1,
        category: '',
        format: '',
        sort: 'DESC',
    };

    const photoDisplayer = (photo) => `
    <div class="single-link">
        <img class="gallery" src="${photo.image}" alt="${photo.title}">
        <a href="${photo.url}">
            <span class="dashicons dashicons-visibility" title="Voir les détails"></span>
        </a>
        <span class="dashicons dashicons-fullscreen-alt" title="Plein écran"></span>
    </div>`;

    //Fin de l'événement si un de ces elements n'existe pas
    if (!button || !gallery || !categorieSelect || !formatSelect || !sortSelect) {
        return;
    }
    
    /*PAGINATION*/
    
    button.addEventListener('click', () => {
        sortSearchState.paged++;

        const newSortParams = new URLSearchParams({
            paged:      sortSearchState.paged,
            category:   sortSearchState.category,
            format:     sortSearchState.format,
            sort:       sortSearchState.sort,
        });

        

        fetch(apiUrl + '?' + newSortParams)
        .then(responsePagination => responsePagination.json())
        .then(data => {

            data.photos.forEach(photo => {
                gallery.insertAdjacentHTML('beforeend', photoDisplayer(photo));
            });

            endMorePhotosButton (sortSearchState.paged, data.max_pages, button);

        })

        .catch(err => console.error("AJAX ERROR:", err));

    });

    /*TRI ET FILTRES*/

    //événements sur chaque constante
    categorieSelect.addEventListener('change', (e) => {
        sortSearchState.category = e.target.value;
        sortSearchState.paged = 1;

        load_sorted_photos(true);
    })

    formatSelect.addEventListener('change', (e) => {
        sortSearchState.format = e.target.value;
        sortSearchState.paged = 1;

        load_sorted_photos(true);
    })

    sortSelect.addEventListener('change', (e) => {
        sortSearchState.sort = e.target.value;
        sortSearchState.paged = 1;

        load_sorted_photos(true);
    })

    //Fonction d'affichage des photos triées

    function load_sorted_photos(reset = false) {

        const newSortParams =  new URLSearchParams(sortSearchState);

        console.log(newSortParams);

        fetch(apiUrl + '?' + newSortParams)
            .then(responseFilters => responseFilters.json())
            .then(data => {
                if(reset === true){
                    gallery.innerHTML = '';
                }

                data.photos.forEach(photo => {
                    gallery.insertAdjacentHTML('beforeend', photoDisplayer(photo));
            });

            endMorePhotosButton (sortSearchState.paged, data.max_pages, button);

        });
    }
})
