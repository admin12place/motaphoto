/*script utilisés par les menus, la globale, le chargement de la gallery*/

/*MODALE DE CONTACT*/
const siteBody = document.querySelector('.customize-support');
const contactModal = document.getElementById('contact-modal');
const closeContactButton = document.querySelector('.contact-no');//icon de fermeture de la modale

/*PRÉ REMPLISSAGE DE LA REF. DE PHOTO SUR LA MODALE*/
let selectedPhotoRef = '';
const singleButton = document.querySelector('.single-button')
if (singleButton) {
    selectedPhotoRef = singleButton.dataset.photoRef;
}

document.addEventListener('click', (e) => {

    const contactButton = e.target.closest('a[href="#contact"]');
        if(contactButton) {
            e.preventDefault();
            document.querySelector('#photo-ref').value = selectedPhotoRef;
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

if (contactModal && closeContactButton) {
    closeContactButton.addEventListener('click', () => {
        contactModal.classList.add('hidden');
    });
}

document.addEventListener('wpcf7mailsent', function(event) {
    alert('Votre message a bien été envoyé');
    contactModal.classList.add('hidden');
}, false);

/*MENU BURGER*/
const menuBurger = document.querySelector('.burger');
const menuContainer = document.querySelector('.primary-navigation');

if (menuBurger && menuContainer) {
    menuBurger.addEventListener('click', () => {
        menuBurger.classList.add('undisplayed');
        menuContainer.classList.add('active');
    });

    document.addEventListener('click', (e) => {
        if (
            (!menuContainer.contains(e.target) && !menuBurger.contains(e.target)) ||
            e.target.closest('a[href="#contact"]')
        ) {
            menuContainer.classList.remove('active');
            menuBurger.classList.remove('undisplayed');
        }
    });
}