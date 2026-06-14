<?php

    get_header();

    while ( have_posts() ) : the_post() ;

    $photo_file = mb_strtoupper ('Fichier : ' . esc_html(SCF::get('photo_file')), 'UTF-8');
    $photo_file_url = wp_get_attachment_url(SCF::get('photo_file'));
    $photo_title = mb_strtoupper (esc_html(SCF::get('photo_title')), 'UTF-8');
    $photo_reference =  mb_strtoupper (esc_html(SCF::get('photo_reference')), 'UTF-8');
    $photo_year =   mb_strtoupper ('année : ' . esc_html(SCF::get('photo_year')), 'UTF-8');
    $photo_type =  mb_strtoupper ('type : ' . esc_html(SCF::get('photo_type')), 'UTF-8');
    $class_format = strtolower (esc_html(SCF::get('photo_format')));
    $photo_format =  mb_strtoupper ('format : ' . esc_html(SCF::get('photo_format')), 'UTF-8');

    $photo_categorie = [];
        $cats = get_the_terms(get_the_ID(), 'categorie');
        if ($cats && !is_wp_error($cats)) {
            foreach ($cats as $cat) { $photo_categorie[] = $cat->name; } }
    $photo_categorie =  mb_strtoupper ('catégorie : ' . implode (', ', $photo_categorie), 'UTF-8');
?>

<!--STRUCTURE HTML DE LA PAGE SINGLE-->
<article id="main-single">

    <div class="post-photo-single">

        <div class="left-contain">

            <div class="desc-photo-single <?php echo $class_format; ?>">
                <h2><?php echo $photo_title; ?></h2>
                <span class="desc-item-photo"><?php echo "RÉFÉRENCE : " . $photo_reference; ?></span>
                <span class="desc-item-photo"><?php echo $photo_categorie; ?></span>
                <span class="desc-item-photo"><?php echo $photo_format; ?></span>
                <span class="desc-item-photo"><?php echo $photo_type; ?></span>
                <span class="desc-item-photo"><?php echo $photo_year; ?></span>
            </div>

        </div>

        <div class="img-photo-single">
            <img class="main-image" src="<?php echo esc_url($photo_file_url);?>"/>
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
            <img class="slider-image" src="<?php echo esc_url($photo_file_url);?>"/>

            <div class="slider-arrows">
                <img class="arrow-left" src="<?= get_stylesheet_directory_uri() ?>/assets/icons/arrow67.svg"/>
                <img class="arrow-right" src="<?= get_stylesheet_directory_uri() ?>/assets/icons/arrow67.svg"/>
            </div>

        </div>
        
    </div>
    <div class="like-photo-single">
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

        <div id="related-photos"
            data-photo-id="<?php echo get_the_ID(); ?>"
            data-categories="<?php echo implode(',', $category_ids); ?>">
        </div>
    </div>

</article>

<?php
endwhile;

get_footer();