<?php
// Get the header of the WordPress theme.
get_header();

// Prueba temporal
$page_slug = get_query_var('inter_custom_page', false);
if ($page_slug && $page_slug === 'productos-categorias') {
  $product_loop = get_query_var('inter_product_loop', false);
  $product_category = get_query_var('inter_product_loop_name', false);

  if ($product_loop && $product_category) {

    echo do_shortcode('[elementor-template id="940"]');
  }
}

// Get the footer of the WordPress theme.
get_footer();
