<?php
function inter_products_add_rewrite_rules()
{
  add_rewrite_rule('productos/?$', 'index.php?inter_custom_page=productos', 'top');
  add_rewrite_rule('productos/([^/]*)/?$', 'index.php?inter_custom_page=productos_single&inter_product_name=$matches[1]', 'top');
  add_rewrite_rule('productos/([^/]*)/([^/]*)/?$', 'index.php?inter_custom_page=productos-$matches[1]&inter_product_loop=$matches[1]&inter_product_loop_name=$matches[2]', 'top');
}

function inter_products_query_vars($vars)
{
  $vars[] = 'inter_custom_page';
  $vars[] = 'inter_product_name';
  $vars[] = 'inter_product_loop';
  $vars[] = 'inter_product_loop_name';
  return $vars;
}

add_action('init', 'inter_products_add_rewrite_rules');
add_filter('query_vars', 'inter_products_query_vars');
