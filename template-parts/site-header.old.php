<?php
$wrapper_classes  = 'site-header';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= ( true === get_theme_mod( 'display_title_and_tagline', true ) ) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';
?>

<header id="masthead" class="">
    
	<?php get_template_part( 'template-parts/site-branding' ); ?><!--Logo du header-->
	<?php get_template_part( 'template-parts/site-nav' ); ?><!--Menu principal-->
