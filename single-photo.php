<?php

    get_header();

    //Récupèration des slugs de toutes les photos dans un tableau
    $photos = get_posts([
    'post_type'      => 'photo',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_key'       => 'photo_year',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC'
    ]);

    $slugs = [];//tableau des slugs
    $photoFiles = [];//tableau des fichiers images

    foreach ($photos as $photo) {
        $slugs[] = $photo->post_name;
        $photoUrls[] = get_permalink($photo->ID);
        $photoImage = (int) SCF::get('photo_file', $photo->ID);
        $photoFiles[] = wp_get_attachment_image_url($photoImage, 'medium');
    }
?>

<?php

    while ( have_posts() ) : the_post() ;

    $photo_file = mb_strtoupper ('Fichier : ' . esc_html(SCF::get('photo_file')), 'UTF-8');
    $photo_file_url = wp_get_attachment_url(SCF::get('photo_file'));
    $photo_title = mb_strtoupper (esc_html(SCF::get('photo_title')), 'UTF-8');
    $photo_reference =  mb_strtoupper (esc_html(SCF::get('photo_reference')), 'UTF-8');
    $photo_year =   mb_strtoupper (esc_html(SCF::get('photo_year')), 'UTF-8');
    $photo_type =  mb_strtoupper (esc_html(SCF::get('photo_type')), 'UTF-8');
    $photo_format =  mb_strtoupper (esc_html(SCF::get('photo_format')), 'UTF-8');

    $photo_categorie = [];
        $cats = get_the_terms(get_the_ID(), 'categorie');
        $photo_categorie = mb_strtoupper('néant');
        if ($cats && !is_wp_error($cats)) {
            $photo_categorie = [];
            foreach ($cats as $cat) { $photo_categorie[] = $cat->name; }
        $photo_categorie =  mb_strtoupper (implode (', ', $photo_categorie), 'UTF-8');
        }
?>

<script>
    const photoSlugs = <?php echo json_encode($slugs); ?>;//Tableau des slug de toutes les photos
    const photoUrls = <?php echo json_encode($photoUrls); ?>;//Tableau des url de toutes les photos
    const photoFiles = <?php echo json_encode($photoFiles); ?>;//Tableau des chemins vers les fichiers
    const thisPhotoSlug = "<?= get_post_field('post_name', get_the_ID()); ?>";//Slug de l'image actuelle
    const thisPhotoRef = "<?= esc_js($photo_reference); ?>";//reference de la photo actuelle pour jQuery et la modale
</script>

<!--STRUCTURE HTML DE LA PAGE SINGLE-->
<article id="main-single">

    <div class="post-photo-single">

        <div class="left-contain">

            <div class="desc-photo-single <?php echo $class_format; ?>">
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
				data-title="<?php echo mb_strtolower($photo_title); ?>" />
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
            <img class="slider-image" src="<?php echo esc_url($photo_file_url);?>"/>

            <div class="slider-arrows">
                <img class="arrow-left" title="Photo précédente" src="<?= get_stylesheet_directory_uri() ?>/assets/icons/arrow67.svg"/>
                <img class="arrow-right" title="Photo suivante" src="<?= get_stylesheet_directory_uri() ?>/assets/icons/arrow67.svg"/>
            
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