<?php

add_action( 'wp_enqueue_scripts', 'wpm_enqueue_styles' );

function wpm_enqueue_styles() {//Ref au theme parent
	wp_enqueue_style( 
		'mota_photo', 
		get_stylesheet_uri()
	);
}

/*************************** */

add_action('wp_enqueue_scripts', 'mota_enqueue_style');

function mota_enqueue_style() { //le css perso
    wp_enqueue_style(
        'styles-perso',
        get_stylesheet_directory_uri() . '/styles/styles.css',
        array(),
        filemtime(get_stylesheet_directory() . '/styles/styles.css'));
};

/*************************** */

add_action( 'wp_enqueue_scripts', 'mota_enqueue_scripts_perso' );

function mota_enqueue_scripts_perso() { //le js perso
    wp_enqueue_script(
        'scripts',
        get_stylesheet_directory_uri() . '/js/scripts.js',
        array(),
        filemtime(get_stylesheet_directory() . '/js/scripts.js'), true);
};

/*MENU D'ADMINISTRATION DU THEME N.MOTA*/

function mota_add_admin_pages() {
add_menu_page(__('Paramètres du thème N.Mota', 'nmota'), __('N.Mota', 
'nmota'), 'manage_options', 'nmota-settings', 'nmota_theme_settings', 'dashicons-admin-settings', 60);
}

function nmota_theme_settings() {
echo '<h1>'.get_admin_page_title().'</h1>';
}

add_action('admin_menu', 'mota_add_admin_pages', 10);

function mota_register_menus() {
    register_nav_menus(array(
        'primary' => 'Menu principal',
        'footer'  => 'Menu footer'
    ));
}
add_action('after_setup_theme', 'mota_register_menus');



