
<?php
	get_header();

	//récupération de l'image du hero avec SCF
	$image_id = (int) SCF::get('bg_header_hero', 85);
	$image_url = wp_get_attachment_image_url($image_id, 'full');
	
?>

<div class="header-image" style="background-image: url('<?php echo esc_url($image_url); ?>');"><!--L'image sur le background-->
	<h1 class="header-title">PHOTOGRAPHE EVENT</h1>
</div>
<?php
/* Start the Loop */
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/content/content-page' );
	the_content();
	// If comments are open or there is at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endwhile; // End of the loop.

get_footer();
