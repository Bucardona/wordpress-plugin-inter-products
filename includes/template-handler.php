<?php
function inter_products_template_redirect($template)
{
  $page_slug = get_query_var('inter_custom_page', false);

  var_dump($page_slug);

  if ($page_slug) {
    $template = locate_template("elementor-templates/{$page_slug}.php");
    var_dump($template);
  }

  return $template;
}

add_filter('template_include', 'inter_products_template_redirect');
