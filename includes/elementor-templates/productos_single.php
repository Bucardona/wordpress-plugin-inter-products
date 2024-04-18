<?php
// Get the header of the WordPress theme.
get_header();

// Prueba temporal
$page_slug = get_query_var('inter_custom_page', false);
if ($page_slug) {
  echo $page_slug;
}

// Get the footer of the WordPress theme.
get_footer();
