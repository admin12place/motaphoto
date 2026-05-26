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
    wp_enqueue_style('styles-perso', get_stylesheet_directory_uri() . '/styles/styles.css',
    filemtime(get_stylesheet_directory() . '/styles/styles.css'), true);
};

/*************************** */

add_action( 'wp_enqueue_scripts', 'mota_enqueue_fonts' );

function mota_enqueue_fonts() {//Les fonts importées depuis Google
    wp_enqueue_style(
        'space-mono-poppins-font',
        'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        array(),
        null);
};

/**************************** */

add_action( 'wp_enqueue_scripts', 'mota_enqueue_scripts_perso' );

function mota_enqueue_scripts_perso() { //le js perso
    wp_enqueue_script('scripts', get_stylesheet_directory_uri() . '/js/scripts.js',
    filemtime(get_stylesheet_directory() . '/js/scripts.js'), null, true);
};


