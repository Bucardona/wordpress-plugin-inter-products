<?php
/*
Plugin Name: Inter Products
Plugin URI: https://joyeriainter.com
Description: Plugin para la gestión personalizada de productos en la tienda online de Joyería Inter con Headless CMS
Version: 0.0.1
Author: Sebastian Cardona
Author URI: https://scardona.me
License: GPL2
*/

// Asegurarse de que no se pueda acceder directamente al archivo.
defined('ABSPATH') or die('No script kiddies please!');

// Incluir las funciones de reescritura y plantillas.
require_once(plugin_dir_path(__FILE__) . 'includes/rewrite-rules.php');
require_once(plugin_dir_path(__FILE__) . 'includes/template-handler.php');

// Activar las reglas de reescritura al activar el plugin.
register_activation_hook(__FILE__, 'flush_rewrite_rules');

// Limpiar las reglas de reescritura al desactivar el plugin.
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
