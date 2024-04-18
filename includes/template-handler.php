<?php
function inter_products_template_redirect($template)
{
  $page_slug = get_query_var('inter_custom_page', false);

  var_dump($page_slug);

  if ($page_slug) {
    // Construye la ruta al archivo de plantilla dentro del plugin
    $plugin_path = plugin_dir_path(__FILE__); // Obtiene la ruta del directorio del archivo actual
    $template_file = $plugin_path . 'elementor-templates/' . $page_slug . '.php';

    // Comprueba si el archivo de plantilla existe
    if (file_exists($template_file)) {
      $template = $template_file;
    }
  }

  return $template;
}

add_filter('template_include', 'inter_products_template_redirect');
