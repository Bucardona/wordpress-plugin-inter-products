<?php
// Incluir las definiciones de funciones adicionales
include_once('trm-functions.php');

// Programar la actualización de la TRM al inicializar WordPress
add_action('init', 'inter_programar_actualizacion_trm');

function inter_programar_actualizacion_trm()
{
  if (!wp_next_scheduled('inter_updateTrmInter_event')) {
    wp_schedule_event(strtotime('today 05:00:00'), 'daily', 'inter_updateTrmInter_event');
  }
}

// Añadir acción para actualizar la TRM según el evento programado
add_action('inter_updateTrmInter_event', function () {
  $trm = new interTRM();
  $trm->updateTrmInter();
});
