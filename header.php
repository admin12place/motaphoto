
<!--mise en place de l'image du header avec SCF-->
<?php
	$image_id = (int) SCF::get('bg_header_hero', 85);
	$image_url = wp_get_attachment_image_url($image_id, 'full');
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
</head>

<body>
<?php wp_body_open(); ?>
<div id="page" class="site">
	
	<header>
		<?php get_template_part( 'template-parts/site-branding' ); ?><!--Logo du header-->

		<button class="burger" aria-label="Ouvrir le menu">
			<span></span>
			<span></span>
			<span></span>
    	</button>
		
		<?php get_template_part( 'template-parts/site-nav' ); ?><!--Menu principal-->
	</header>

	<div class="header-image" style="background-image: url('<?php echo esc_url($image_url); ?>');"><!--L'image sur le background-->
		<h1 class="header-title">PHOTOGRAPHE EVENT</h1>
	</div>

	<div id="content" class="site-content">

		<div id="primary" class="content-area">

			<main id="main" class="site-main">