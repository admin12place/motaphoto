
<?php
	get_header();

	//récupération de l'image du hero avec SCF
	$image_id = (int) SCF::get('bg_header_hero', 85);
	$image_url = wp_get_attachment_image_url($image_id, 'full');

	//récupération de tous les formats existants utilisés au moment de la requete
	$formats = [];
	$photos = get_posts([
		'post_type'      => 'photo',
		'posts_per_page' => -1,
		'fields'         => 'ids']);

	foreach ($photos as $photo_id) {
    $format = SCF::get('photo_format', $photo_id);
		if (!empty($format)) {
			$formats[$format] = $format;
		}
	}

	//récupération de toutes les catégories
	$categories = get_terms([
    	'taxonomy'   => 'categorie',
    	'hide_empty' => true,
	]);
	
?>
<?php
	while ( have_posts() ) :
    	the_post();
		if (is_front_page() ) :
			?>
			<div class="header-image" style="background-image: url('<?php echo esc_url($image_url); ?>');"><!--L'image sur le background-->
				<h1 class="header-title">PHOTOGRAPHE EVENT</h1>
			</div>
	
<!--Le html du catalogue de photos-->
<section id="photos-catalogue">
	<div class="search-sort">
		<div class="search">
			<div class="select-form">
				<label for="categories-search">CATÉGORIES</label>
				<select id="categories-search" name="categories-search">
					<option value="">Toutes les catégories</option>
					<?php
						foreach ($categories as $category) : 
					?>
        			<option value="<?php echo esc_attr($category->slug); ?>">
            			<?php echo esc_html($category->name); ?>
        			</option>
    					<?php endforeach; ?>
				</select>
			</div>

			<div class="select-form">
				<label for="formats-search">FORMATS</label>
				<select id="formats-search" name="formats-search">
					<option value="">Tous les formats</option>
					<?php
						foreach ($formats as $format) : 
					?>
        			<option value="<?php echo esc_attr($format); ?>">
            			<?php echo esc_html($format); ?>
        			</option>
    					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="sort">
			<div class="select-form">
				<label for="sort-photos">TRIER PAR</label>
				<select id="sort-photos" name="sort-photos">
					<option value="desc">À partir des plus récentes</option>
					<option value="asc">À partir des plus anciennes</option>
				</select>
			</div>
		</div>
	</div>

	<div class="photos-thumbnail">

	</div>
</section>

<?php
		endif;

	endwhile;
	
	the_content();

	get_footer();
