<?php
// Get the header of the WordPress theme.
get_header();

// Use the shortcode of the Elementor template designed for product lists.
//echo do_shortcode('[tu_shortcode_de_elementor]');

// Prueba temporal
$page_slug = get_query_var('inter_custom_page', false);
if ($page_slug) {
  echo $page_slug;
}

// Get the footer of the WordPress theme.
get_footer();
