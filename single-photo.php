<?php

    get_header();

    while ( have_posts() ) : the_post() ;
    //on récupère l'ID de l'image en cours
    $current_id = get_the_ID();

    //Celui de l'image précédente dans la galerie
    $previous_id = $wpdb->get_var(
    $wpdb->prepare(
        "SELECT ID
         FROM {$wpdb->posts}
         WHERE post_type = 'photo'
           AND post_status = 'publish'
           AND ID < %d
         ORDER BY ID DESC
         LIMIT 1",
        $current_id
        )
    );
    //Si on est au début de la galerie, on boucle sur la dernière image
    if (!$previous_id) {
    $previous_id = $wpdb->get_var(
        "SELECT ID
         FROM {$wpdb->posts}
         WHERE post_type = 'photo'
           AND post_status = 'publish'
         ORDER BY ID DESC
         LIMIT 1"
    );
}

    //Celui de l'image suivante dans la galerie
    $next_id = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT ID
            FROM {$wpdb->posts}
            WHERE post_type = 'photo'
            AND post_status = 'publish'
            AND ID > %d
            ORDER BY ID ASC
            LIMIT 1",
            $current_id
        )
    );
    // Si on est à la fin de la galerie, on boucle sur la première image
    if (!$next_id) {
        $next_id = $wpdb->get_var(
            "SELECT ID
            FROM {$wpdb->posts}
            WHERE post_type = 'photo'
            AND post_status = 'publish'
            ORDER BY ID ASC
            LIMIT 1"
        );
    }

    $photo_file_url = wp_get_attachment_url(SCF::get('photo_file'));
    $photo_title = mb_strtoupper (esc_html(SCF::get('photo_title')), 'UTF-8');
    $photo_reference =  mb_strtoupper (esc_html(SCF::get('photo_reference')), 'UTF-8');
    $photo_year =   mb_strtoupper (esc_html(SCF::get('photo_year')), 'UTF-8');
    $photo_type =  mb_strtoupper (esc_html(SCF::get('photo_type')), 'UTF-8');
    $photo_format =  mb_strtoupper (esc_html(SCF::get('photo_format')), 'UTF-8');
    $photo_categorie = mb_strtoupper (get_photo_categories());

?>
<!--STRUCTURE HTML DE LA PAGE SINGLE-->
<article id="main-single">

    <div class="post-photo-single">

        <div class="left-contain">

            <div class="desc-photo-single">
                <h2 class="desc-photo-title"><?php echo $photo_title; ?></h2>
                <span class="desc-item-photo"><?php echo "RÉFÉRENCE : " . $photo_reference; ?></span>
                <span class="desc-item-photo"><?php echo "CATÉGORIES : " . $photo_categorie; ?></span>
                <span class="desc-item-photo"><?php echo "FORMAT : " . $photo_format; ?></span>
                <span class="desc-item-photo"><?php echo "TYPE : " . $photo_type; ?></span>
                <span class="desc-item-photo"><?php echo "ANNÉE : " . $photo_year; ?></span>
            </div>

        </div>

        <div class="img-photo-single">
            <img class="main-image" src="<?php echo esc_url($photo_file_url);?>"
                data-title="<?php echo mb_strtolower($photo_title); ?>"
                data-reference="<?php echo mb_strtolower($photo_reference); ?>"
                data-categorie="<?php echo mb_strtolower($photo_categorie); ?>"/>
            <span class="dashicons dashicons-fullscreen-alt" title="Plein écran"></span>
        </div>

    </div>

    <div class="link-slider-single">

        <div class="left-block-slider">
            <h3 class="single-text">Cette photo vous intéresse ?</h3>
            <button class="single-button" data-photo-ref="<?php echo esc_attr($photo_reference); ?>">
                <a href="#contact" class="single-button">Contact</a>
            </button>
        </div>

        <div class="right-block-slider">
            <img class="slider-image" src="<?php echo esc_url($photo_file_url);?>"
                data-this-id="<?php echo $current_id; ?>"/>

            <div class="slider-arrows">
                <img class="arrow-left" title="Photo précédente" src="<?= get_stylesheet_directory_uri() ?>/assets/icons/arrow67.svg"
                    data-previous-id="<?php echo $previous_id; ?>" />
                <img class="arrow-right" title="Photo suivante" src="<?= get_stylesheet_directory_uri() ?>/assets/icons/arrow67.svg"
                    data-next-id="<?php echo $next_id; ?>" />
            
                <div class="prec-suiv-thumbnail"></div>
            </div>

        </div>
        
    </div>
    <div id="gallery" class="like-photo-single">
        <h3>VOUS AIMEREZ AUSSI</h3>
        <?php
            $categories = get_the_terms(get_the_ID(), 'categorie');

            $category_ids = [];

            if ($categories) {
                foreach ($categories as $category) {
                    $category_ids[] = $category->term_id;
                }
            }
        ?>

        <div id="related-photos" class="photos-thumbnail"
            data-photo-id="<?php echo get_the_ID(); ?>"
            data-categories="<?php echo implode(',', $category_ids); ?>">
        </div>
    </div>

</article>

<?php

endwhile;

get_footer();