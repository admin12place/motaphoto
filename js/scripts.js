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