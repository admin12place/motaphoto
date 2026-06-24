<?php
register_nav_menus([
    'primary' => 'Menu principal',
    'footer'  => 'Menu footer',
]);

/***************************/


function wpm_enqueue_styles() {//Ref au theme parent
	wp_enqueue_style( 
		'mota_photo', 
		get_stylesheet_uri()
	);
}
add_action( 'wp_enqueue_scripts', 'wpm_enqueue_styles' );

/***************************/


function load_dashicons_frontend() {//chargement des dashicons
    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'load_dashicons_frontend');

/***************************/


function mota_enqueue_style() { //le css perso
    wp_enqueue_style(
        'styles-perso',
        get_stylesheet_directory_uri() . '/styles/styles.css',
        array(),
        filemtime(get_stylesheet_directory() . '/styles/styles.css'));
};
add_action('wp_enqueue_scripts', 'mota_enqueue_style');

/*****************************/


function mota_enqueue_script_global() { //le js global
    wp_enqueue_script(
        'script-global',
        get_stylesheet_directory_uri() . '/js/script-global.js',
        array(),
        filemtime(get_stylesheet_directory() . '/js/script-global.js'), true);

    wp_localize_script(
        'script-global',
        'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php')
        )
    );
}
add_action( 'wp_enqueue_scripts', 'mota_enqueue_script_global' );

/*****************************/


function mota_enqueue_script_single() { //le js de la page single
    wp_enqueue_script(
        'script-single',
        get_stylesheet_directory_uri() . '/js/script-single.js',
        array(),
        filemtime(get_stylesheet_directory() . '/js/script-single.js'), true);

    wp_localize_script(
        'script-single',
        'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php')
        )
    );
}
add_action( 'wp_enqueue_scripts', 'mota_enqueue_script_single' );

/*****************************/


function mota_enqueue_related_photos() { //le js des photos connexes
    wp_enqueue_script(
        'related-photos',
        get_stylesheet_directory_uri() . '/js/related-photos.js',
        array(),
        filemtime(get_stylesheet_directory() . '/js/related-photos.js'), true);

    wp_localize_script(
            'related-photos',
        'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php')
        )
    );
}
add_action( 'wp_enqueue_scripts', 'mota_enqueue_related_photos' );

/*****************************/


function mota_enqueue_script_gallery() {//le js de la gallery
    wp_enqueue_script(
        'script-gallery',
        get_stylesheet_directory_uri() . '/js/script-gallery.js',
        array(),
        filemtime(get_stylesheet_directory() . '/js/script-gallery.js'), true);

    wp_localize_script(
            'script-gallery',
        'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php')
        )
    );
}
add_action( 'wp_enqueue_scripts', 'mota_enqueue_script_gallery' );

/*****************************/

function mota_enqueue_script_lightbox() {//le js de la lightbox
    wp_enqueue_script(
        'script-lightbox',
        get_stylesheet_directory_uri() . '/js/script-lightbox.js',
        array(),
        filemtime(get_stylesheet_directory() . '/js/script-lightbox.js'), true);

    /*wp_localize_script(
            'script-lightbox',
        'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php')
        )
    );*/
}
add_action( 'wp_enqueue_scripts', 'mota_enqueue_script_lightbox' );

/*****************************/




function theme_enqueue_scripts() {//le jquery
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

/*****************************/


function load_related_photos() {

    $photo_id = intval($_POST['photo_id']);
    $categories = array_map('intval', explode(',', $_POST['categories']));
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 2,
        'orderby'        => 'rand',
        'post__not_in'   => array($photo_id),
        'tax_query'      => array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'term_id',
                'terms'    => $categories,
            ),
        ),
    );

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) :

        while ($query->have_posts()) :
            $query->the_post();

            $photo_file_id = SCF::get('photo_file');
            $image = wp_get_attachment_url($photo_file_id);
            ?>

            <article class="related-photo">
                <a href="<?php the_permalink(); ?>">
                    <img
                        src="<?php echo esc_url($image); ?>"
                        alt="<?php the_title_attribute(); ?>"
                    >
                </a>
            </article>

            <?php

        endwhile;

    endif;

    wp_reset_postdata();

    echo ob_get_clean();

    wp_die();
}
add_action('wp_ajax_load_related_photos', 'load_related_photos');
add_action('wp_ajax_nopriv_load_related_photos', 'load_related_photos');

/*********API WP pour le chargement des photos (endpoint)*********/


add_action('rest_api_init', function(){

register_rest_route(
    'photos/v1',
    '/load/',
    array(
        'methods'=>'GET',
        'callback'=>'load_more_photos'
    )
);

});

/*******Fonction de chargement initial de la page*******/


function load_contain($post_type, $post_categorie = '', $format = '', $order = 'DESC', 
                        $post_number = 8, $page = 1) {

    $args = array(
    'post_type'      => $post_type,
    'posts_per_page' => $post_number,
    'paged'          => $page,
    'meta_key'       => 'photo_year', //tri avec le champs de SCF et pas la date WP
    'orderby'        => array(
        'meta_value_num' => $order, //pour traiter la valeur comme un nombre (pas une chaine)
        'ID'             => $order, //tri aussi par id
    ),
);

    if (!empty($post_categorie)) {

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => $post_categorie,
            )
        );

    }

    if (!empty($format)) {

        $args['meta_query'] = array(
            array(
                'key'     => 'photo_format',
                'value'   => $format,
                'compare' => '='
            )
        );

    }

    return new WP_Query($args);
}


/* Fonction de re-chargement via les select et le bouton 'charger plus'*/

function load_more_photos($request){

    $page = (int) ($request->get_param('paged') ?? 1);//en cas de pb page 1 forcée
    $categorie = $request->get_param('category') ?? '';
    $format = $request->get_param('format') ?? '';
    $order = strtoupper($request->get_param('sort') ?? 'DESC');
        if (!in_array($order, ['ASC', 'DESC'])) {//valeur de $order valide
            $order = 'DESC';
        }

    $post_type = 'photo';
    $post_number = 8;

    $query = load_contain(
        $post_type,
        $categorie,
        $format,
        $order,
        $post_number,
        $page
    );

    if ($query && $query->have_posts()) {

        while ($query->have_posts()) {
            $query->the_post();

            $image_id = SCF::get('photo_file', get_the_ID());
            $image_ref = SCF::get('photo_reference');
            
            $cat = get_the_terms(get_the_ID(), 'categorie');
		    $image_cats = [];
		    if ($cat && !is_wp_error($cat)) {
    		    foreach ($cat as $cat_index) {
        		    $image_cats[] = $cat_index->name;
    		    }
			    $image_cat = implode(', ', $image_cats);
		    }
            
            $image_url = wp_get_attachment_image_url($image_id, 'full');

            $photos[] = [
                'id'    => get_the_ID(),
                'title' => get_the_title(),
                'image' => $image_url,
                'reference' => $image_ref,
                'categorie' => $image_cat,
                'url'   => get_permalink()
            ];
        }

        wp_reset_postdata();
    }

    return [
        'photos'    => $photos,
        'max_pages' => $query ? $query->max_num_pages : 0
    ];
}