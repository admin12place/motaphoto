<?php
register_nav_menus([
    'primary' => 'Menu principal',
    'footer'  => 'Menu footer',
]);

add_action( 'wp_enqueue_scripts', 'wpm_enqueue_styles' );

function wpm_enqueue_styles() {//Ref au theme parent
	wp_enqueue_style( 
		'mota_photo', 
		get_stylesheet_uri()
	);
}

/***************************/

add_action('wp_enqueue_scripts', 'mota_enqueue_style');

function mota_enqueue_style() { //le css perso
    wp_enqueue_style(
        'styles-perso',
        get_stylesheet_directory_uri() . '/styles/styles.css',
        array(),
        filemtime(get_stylesheet_directory() . '/styles/styles.css'));
};

/*****************************/

add_action( 'wp_enqueue_scripts', 'mota_enqueue_scripts_perso' );

function mota_enqueue_scripts_perso() { //le js perso
    wp_enqueue_script(
        'scripts',
        get_stylesheet_directory_uri() . '/js/scripts.js',
        array(),
        filemtime(get_stylesheet_directory() . '/js/scripts.js'), true);

    wp_localize_script(
        'scripts',
        'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php')
        )
    );
}

/*****************************/

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

function theme_enqueue_scripts() {
    wp_enqueue_script('jquery');
}

/*****************************/

add_action('wp_ajax_load_related_photos', 'load_related_photos');
add_action('wp_ajax_nopriv_load_related_photos', 'load_related_photos');

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

/*******************************/

function load_contain($post_type, $post_categorie = '', $format = '', $order = 'DESC', $post_number = -1) {
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $post_number,
        'order'         => $order );

    if (!empty($post_categorie)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'categorie',
                    'field'    => 'slug',
                    'terms'    => $post_categorie
                )
            );
        }

    if (!empty($format)) {
        $args['meta_query'][] = [
            'key'   => 'photo_format',
            'value' => $format,
            'compare'   => '=',
        ];
    }

    $query_load_contain = new WP_Query($args);

    $photos = array();

    while ($query_load_contain->have_posts()) {

        $query_load_contain->the_post();
        $photo_categorie = array();
        $cats = get_the_terms(get_the_ID(), 'categorie');

        if ($cats && !is_wp_error($cats)) {
            foreach ($cats as $cat) {
                $photo_categorie[] = $cat->name;
            }
        }

        $photos[] = array(
            'id'         => get_the_ID(),
            'permalink'  => get_permalink(),
            'url'        => wp_get_attachment_url(SCF::get('photo_file')),
            'title'      => SCF::get('photo_title'),
            'reference'  => SCF::get('photo_reference'),
            'year'       => SCF::get('photo_year'),
            'type'       => SCF::get('photo_type'),
            'format'     => SCF::get('photo_format'),
            'categories' => $photo_categorie
        );
    }

    wp_reset_postdata();

    return $photos;
}