
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
	endwhile;
?>

<!--Le html du catalogue de photos-->
<section id="photos-catalogue">
	<div class="search-sort">
		<div class="search">
			<label for="categories-search">CATÉGORIES</label>
			<select id="categories-search" name="categories-search">

			</select>

			<label for="formats-search">FORMATS</label>
			<select id="formats-search" name="formats-search">

			</select>
		</div>

		<div class="sort">
			<label for="sort-photos">TRIER PAR</label>
			<select id="sort-photos" name="sort-photos">
		</div>
	</div>

	<div class="photos-thumbnail">

	</div>
</section>

<?php
	get_footer();
?>
