/*script utilisés par les menus, la globale, le chargement de la gallery*/


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


/*PRÉ REMPLISSAGE DE LA REF. DE PHOTO SUR LA MODALE*/
jQuery(function($) {
    if (typeof thisPhotoRef !== 'undefined') {
        $('#photo-ref').val(thisPhotoRef);
    }
    $('.single-button').on('click', function() {
        $('#photo-ref').val($(this).data('photo-ref'));
    });
});


/*MENU BURGER*/
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