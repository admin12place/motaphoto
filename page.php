
<?php
	get_header();

	//récupération de l'image du hero avec SCF
	$image_id = (int) SCF::get('bg_header_hero', 85);
	$image_url = wp_get_attachment_image_url($image_id, 'full');
	
?>
<?php
	while ( have_posts() ) :
    	the_post();
		if (is_front_page() ) :
			?>
			<div class="header-image" style="background-image: url('<?php echo esc_url($image_url); ?>');"><!--L'image sur le background-->
				<h1 class="header-title">PHOTOGRAPHE EVENT</h1>
			</div>
			<?php
				endif;
			?>

			<?php

		the_content();
	endwhile;

get_footer();
