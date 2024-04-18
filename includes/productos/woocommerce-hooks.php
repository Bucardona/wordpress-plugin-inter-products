<?php
function inter_products_remove_woocommerce_hooks()
{
  $custom_page = get_query_var('inter_custom_page', false);

  if ($custom_page) {
    if ($custom_page == 'productos') {
      remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
      remove_action('woocommerce_after_single_product', 'woocommerce_upsell_display', 15);
    }
  }
}

add_action('wp', 'inter_products_remove_woocommerce_hooks');
