
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
	//récupération des 8 premières photos
	$photos_gallery = load_contain('photo');
?>
<?php
	while ( have_posts() ) :
    	the_post();
		if (is_front_page() ) :
			?>
			<div class="header-image" style="background-image: url('<?php echo esc_url($image_url); ?>');"><!--L'image sur le background-->
				<h1 class="header-title">PHOTOGRAPHE EVENT</h1>
			</div>
	
<!--Le html des champs de filtres et du tri-->
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
					<option value="DESC">À partir des plus récentes</option>
					<option value="ASC">À partir des plus anciennes</option>
				</select>
			</div>
		</div>
	</div>

	<!--Le html du catalogue de photos-->

	<div id="gallery" class="photos-thumbnail">

	<?php while($photos_gallery->have_posts()) : $photos_gallery->the_post();
		$image_id = SCF::get('photo_file');
		$image_title = SCF::get('photo_title');
		$image_url = wp_get_attachment_image_url($image_id, 'full');

		$cat = get_the_terms(get_the_ID(), 'categorie');//les catégories depuis le CPT personnalisé
		$image_cats = [];
		if ($cat && !is_wp_error($cat)) {
    		foreach ($cat as $cat_index) {
        		$image_cats[] = $cat_index->name;
    		}
			$image_cat = implode(', ', $image_cats);
		}

		$image_ref = SCF::get('photo_reference');
	?>

		<div class="single-link">
			<img class="gallery" 
				data-reference="<?php echo esc_attr($image_ref); ?>"
				data-categorie="<?php echo esc_attr($image_cat); ?>"
				data-title="<?php echo esc_attr($image_title); ?>"
				src="<?php echo esc_url($image_url); ?>" alt="<?php echo $image_title; ?>" title="<?php echo $image_title; ?>"/>

			<a href="<?php the_permalink();?>">
				<span class="dashicons dashicons-visibility" title="Voir les détails de <?php echo $image_title;?>" data-id="<?php echo get_the_ID(); ?>"></span>
			</a>
			<span class="dashicons dashicons-fullscreen-alt" title="Plein écran"></span>	
		</div>

		<?php
			endwhile; 
			wp_reset_postdata();
		?>

	</div>

	<!--Le html du bouton 'Charger plus'-->

	<div class="button-more">
		<button class="more-photos">Charger plus</button>
	</div>
	
</section>

<?php
		endif;

	endwhile;
	
	the_content();

	get_footer();
