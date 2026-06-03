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

function mota_register_menus() {
    register_nav_menus(array(
        'primary' => 'Menu principal',
        'footer'  => 'Menu footer'
    ));
}
add_action('after_setup_theme', 'mota_register_menus');


/*MENU D'ADMINISTRATION DU THEME N.MOTA*/

function nmota_add_admin_pages() {
add_menu_page(__('Paramètres du thème N.Mota', 'nmota'), __('N.Mota', 
'nmota'), 'manage_options', 'nmota-settings', 'nmota_theme_settings', 
'dashicons-admin-settings', 60);
}

    function nmota_theme_settings() {
    echo '<h1>'.get_admin_page_title().'</h1>';

    echo '<form action="options.php" method="post" name="nmota_settings">';
        echo '<div>';

        settings_fields('nmota_settings_fields');
        do_settings_sections('nmota_settings_section');

        submit_button();

        echo '</div>';
    echo '</form>';
    }


/*******************Ajouter des champs au formulaire******************* */

function nmota_settings_register() {
register_setting('nmota_settings_fields', 'nmota_settings_fields', 'nmota_settings_fields_validate');
add_settings_section('nmota_settings_section', __('Paramètres', 'nmota'), 'nmota_settings_section_introduction', 'nmota_settings_section');
add_settings_field('nmota_settings_field_siteTitle', __('Titre du site', 'nmota'), 'nmota_settings_field_siteTitle_output', 'nmota_settings_section', 'nmota_settings_section');
add_settings_field('nmota_settings_field_site_mailAdmin', __('Mail administrateur', 'nmota'), 'nmota_settings_field_site_mailAdmin_output', 'nmota_settings_section', 'nmota_settings_section');
add_settings_field('nmota_settings_field_site_mailContact', __('Mail de contact', 'nmota'), 'nmota_settings_field_site_mailContact_output', 'nmota_settings_section', 'nmota_settings_section');
}

function nmota_settings_section_introduction() {
    _e('Paramètrez les différentes options du thème N.Mota.', 'nmota');
}

function nmota_settings_field_siteTitle_output() {
    $value = get_option('nmota_settings_field_siteTitle');
    echo '<input name="nmota_settings_field_siteTitle" type="text" value="' . $value.'" />'; 
}

function nmota_settings_field_site_mailAdmin_output() {
    $value = get_option('nmota_settings_field_site_mailAdmin');
    echo '<input name="nmota_settings_field_site_mailAdmin" type="email" value="' . $value.'" />'; 
}

function nmota_settings_field_site_mailContact_output() {
    $value = get_option('nmota_settings_field_site_mailContact');
    echo '<input name="nmota_settings_field_site_mailContact" type="email" value="' . $value.'" />'; 
}


function nmota_settings_fields_validate($inputs) {
    if(!empty($_POST)) {

        if(!empty($_POST['nmota_settings_field_siteTitle'])) {
            update_option('nmota_settings_field_siteTitle', $_POST['nmota_settings_field_siteTitle']);
        }
        if(!empty($_POST['nmota_settings_field_site_mailAdmin'])) {
            update_option('nmota_settings_field_site_mailAdmin', $_POST['nmota_settings_field_site_mailAdmin']);
        }

        if(!empty($_POST['nmota_settings_field_site_mailContact'])) {
            update_option('nmota_settings_field_site_mailContact',$_POST['nmota_settings_field_site_mailContact']);
        }
    }
    return $inputs;
}

add_action('admin_menu', 'nmota_add_admin_pages', 10);
add_action('admin_init', 'nmota_settings_register');

?>