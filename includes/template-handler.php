<?php
function inter_products_template_redirect($template)
{
  $custom_page = get_query_var('custom_page', false);

  if ($custom_page) {
    $template = locate_template("elementor-templates/{$custom_page}.php");
  }

  return $template;
}

add_filter('template_include', 'inter_products_template_redirect');
