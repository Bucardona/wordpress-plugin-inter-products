<?php

class InterTRM
{

  public function getTrmApiUrl()
  {
    return 'https://trm.joyeriainter.com/api/?date=today';
  }
  //Función para obtener la TRM desde la API
  public function getTrmApi()
  {
    $apiUrl = $this->getTrmApiUrl();

    $headers = array(
      'user-agent' => 'WordPress TRM API Client',
      'headers' => array(
        'Accept' => 'application/json',
        'Cache-Control' => 'no-cache',
      )
    );
    $response = wp_remote_get($apiUrl, $headers);

    if (is_wp_error($response)) {
      error_log('Error fetching TRM: ' . $response->get_error_message());
      return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['data']) && $data['data']['value']) {
      $trm = (float) $data['data']['value'];
      return ceil(round($trm) / 5) * 5;  // Redondeo a múltiplo de 5
    } else {
      error_log('Invalid TRM data received');
      return false;
    }
  }

  //Función para obtener la TRM almacenada
  public function getTrmInter()
  {
    $trm = get_transient('inter_trm');
    if (!$trm) {
      $trm = get_option('inter_trm', 0); // Obtiene la TRM almacenada
      set_transient('inter_trm', $trm, DAY_IN_SECONDS); // Guarda en el cache por un día
    }
    return $trm;
  }

  //Función para convertir de COP a USD
  public function usdToCop($price)
  {
    $trm = $this->getTrmInter(); // Obtiene la TRM almacenada
    return $price * $trm; // Realiza la conversión del precio
  }

  //Función para almacenar la TRM en la base de datos
  public function updateTrmInter()
  {
    $trm = $this->getTrmApi();
    if ($trm) {
      update_option('inter_trm', $trm);
      set_transient('inter_trm', $trm, DAY_IN_SECONDS);
      wp_cache_delete('inter_trm', 'options');
    }
    return $trm;
  }
}


//Función para almacenar la TRM en la base de datos
/*function inter_updateTrmInter()
{
  $trm = inter_getTrmInterApi();
  if ($trm) {
    update_option('inter_trm', $trm);
    set_transient('inter_trm', $trm, DAY_IN_SECONDS);
    wp_cache_delete('inter_trm', 'options');
  }
}*/

//Función para obtener la TRM desde la API
/*function inter_getTrmInterApi()
{
  $apiUrl = 'https://api-trm-inter.onrender.com/api/?date=today';
  $response = wp_remote_get($apiUrl, array('headers' => ['Cache-Control' => 'no-cache']));

  if (is_wp_error($response)) {
    error_log('Error fetching TRM: ' . $response->get_error_message());
    return false;
  }

  $body = wp_remote_retrieve_body($response);
  $data = json_decode($body, true);

  if (isset($data['data']) && $data['data']['value']) {
    $trm = (float) $data['data']['value'];
    return ceil(round($trm) / 5) * 5;  // Redondeo a múltiplo de 5
  } else {
    error_log('Invalid TRM data received');
    return false;
  }
}*/
