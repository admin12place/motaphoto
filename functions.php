<?php

add_action( 'wp_enqueue_scripts', 'wpm_enqueue_styles' );

function wpm_enqueue_styles() {
	wp_enqueue_style( 
		'mota_photo', 
		get_stylesheet_uri()
	);
}

add_action('wp_enqueue_scripts', 'mota_enqueue_style');

function mota_enqueue_style() {
    //le css perso
    wp_enqueue_style('styles-perso', get_stylesheet_directory_uri() . '/styles/styles.css',
    filemtime(get_stylesheet_directory() . '/styles/styles.css'), true);
};
