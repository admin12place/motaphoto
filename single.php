<?php
$photo_file = SCF::get('photo_file');
$photo_title = SCF::get('photo_title');
$photo_reference = SCF::get('photo_reference');
$photo_year = SCF::get('photo_year');
$photo_type = SCF::get('photo_type');
$photo_id = (int) SCF::get('photo_file');
$photo_url = wp_get_attachment_image_url($photo_id, 'full');

get_header();




echo 'Année : ' . $photo_year;

echo '<img src="' . esc_url($photo_url) . '" alt="' . $photo_title . '"/>';

get_footer();
