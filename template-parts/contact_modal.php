<section id="contact-modal" class="hidden">

    <div class="close-button">
        <span class="dashicons dashicons-no contact-no" title="Fermer"></span>
    </div>

    <div class="modal-header">
        <img class="logo-contact" src="<?php echo get_stylesheet_directory_uri() . '/images/contact-header-logo.png'?>" 
        alt="Logo du formulaire de contact"/>
    </div>

    <div class="contact-form">
        <?php echo do_shortcode('[contact-form-7 id="a53ef32" title="Formulaire de contact 1"]');?>
    </div>
</section>