<?php
function inter_products_template_redirect($template)
{
  $page_slug = get_query_var('inter_custom_page', false);

  if ($page_slug) {
    $template = locate_template("elementor-templates/{$page_slug}.php");
  }

  return $template;
}

add_filter('template_include', 'inter_products_template_redirect');
