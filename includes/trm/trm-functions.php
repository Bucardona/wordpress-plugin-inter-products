<?php

class InterTRM
{

  public function getTrmApiUrl()
  {
    return 'https://interapitrm.mdigital-2f5.workers.dev?date=today';
  }
  //Función para obtener la TRM desde la API
  public function getTrmApi()
  {
    $apiUrl = $this->getTrmApiUrl();

    // Inicializa una sesión cURL
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
      'accept-language: es-419,es;q=0.9,en;q=0.8',
      'cache-control: max-age=0',
      'sec-ch-ua: \"Google Chrome\";v=\"125\", \"Chromium\";v=\"125\", \"Not.A/Brand\";v=\"24\"',
      'sec-ch-ua-mobile: ?0',
      'sec-ch-ua-platform: \"Windows\"',
      'sec-fetch-dest: document',
      'sec-fetch-mode: navigate',
      'sec-fetch-site: none',
      'sec-fetch-user: ?1',
      'upgrade-insecure-requests: 1',
      'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36'
    ]);

    // Ejecuta la solicitud cURL y obtiene la respuesta
    $response = curl_exec($ch);

    // Cierra la sesión cURL
    curl_close($ch);

    /*$response = wp_remote_get($apiUrl, array('headers' => ['Cache-Control' => 'no-cache',]));

    if (is_wp_error($response)) {
      error_log('Error fetching TRM: ' . $response->get_error_message());
      return false;
    }

    $body = wp_remote_retrieve_body($response);*/
    $data = json_decode($response, true);

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
