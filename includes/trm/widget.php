<?php
add_action('wp_dashboard_setup', 'inter_trm_add_dashboard_widgets');

function inter_trm_add_dashboard_widgets()
{
  wp_add_dashboard_widget(
    'inter_trm_dashboard_widget', // Widget slug.
    'Información de la TRM', // Título del Widget.
    'inter_trm_dashboard_widget_function' // Función de visualización.
  );
}

function inter_trm_dashboard_widget_function()
{
  $interTRM = new InterTRM();
  echo '<p>TRM Almacenada en WordPress: USD $' . number_format($interTRM->getTrmInter(), 2, ',', '.')  . '</p>';
  echo '<p>TRM de la API: USD $' . number_format($interTRM->getTrmApi(), 2, ',', '.') . '</p>';
}
