
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
<!--Le html du catalogue de photos-->
<section id="photos-catalogue">
	<div class="search-sort">
		<div class="search">
			<div class="select-form">
				<label for="categories-search">CATÉGORIES</label>
				<select id="categories-search" name="categories-search"></select>
			</div>

			<div class="select-form">
				<label for="formats-search">FORMATS</label>
				<select id="formats-search" name="formats-search"></select>
			</div>
		</div>

		<div class="sort">
			<div class="select-form">
				<label for="sort-photos">TRIER PAR</label>
				<select id="sort-photos" name="sort-photos"></select>
			</div>
		</div>
	</div>

	<div class="photos-thumbnail">

	</div>
</section>

<?php
	endwhile;

	get_footer();
