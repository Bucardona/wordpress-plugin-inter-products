<?php
// Hook para agregar un widget en el dashboard de WordPress
add_action('wp_dashboard_setup', 'inter_trm_add_dashboard_widgets');
// Hook para actualizar con ajax la TRM
add_action('wp_ajax_inter_inter_update_trm_widget', 'inter_update_trm_ajax_handler');

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
  echo '<p>TRM Almacenada en WordPress: COP $<span id="inter_update_trm_result">' . number_format($interTRM->getTrmInter(), 2, ',', '.')  . '</span></p>';
  echo '<p>TRM de la API: COP $' . number_format($interTRM->getTrmApi(), 2, ',', '.') . '</p>';
  echo "<button id='inter_update_trm_button' class='button button-secundary'>Actualizar TRM manualmente</button>";

  // Incluir JavaScript para manejar el evento del clic del botón
?>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('#inter_update_trm_button').on('click', function(e) {

        const textButton = e.target.textContent;
        e.preventDefault();
        e.target.disabled = true;
        e.target.textContent = 'Actualizando...';
        e.target.classList.add('button-disabled');
        e.target.classList.remove('button-secundary');
        $.ajax({
          url: ajaxurl, // 'ajaxurl' es una variable global definida por WordPress para usar en AJAX
          type: 'POST',
          data: {
            'action': 'inter_update_trm_widget', // El hook de acción que WordPress ejecutará en el backend
          },
          success: function(response) {
            let trmRes = JSON.parse(response);
            let trm = trmRes.value ? Number(trmRes.value) : 0;

            trm = new Intl.NumberFormat('es-CO', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }).format(trm)

            $('#inter_update_trm_button').html(trmRes.message); // Mostrar la respuesta del servidor en el div
            $('#inter_update_trm_result').html(trm); // Actualizar el valor de la TRM en el widget

            $('#inter_update_trm_button').html(textButton);
            e.target.classList.add('button-secundary');
            e.target.classList.remove('button-disabled');
            e.target.disabled = false;
          },
          error: function() {
            $('#inter_update_trm_button').html('Error al intentar actualizar');
            setTimeout(() => {
              $('#inter_update_trm_button').html(textButton)
              e.target.classList.add('button-secundary');
              e.target.classList.remove('button-disabled');
              e.target.disabled = false;
            }, 3000);
          }
        });
      });
    });
  </script>
<?php

}

function inter_update_trm_ajax_handler()
{
  // Suponiendo que tienes una clase y método para actualizar la TRM
  $result = (new InterTRM())->updateTrmInter();  // Llama al método que actualiza la TRM
  $message = '';

  if ($result) {
    $message = "TRM actualizada correctamente.";
  } else {
    $message = "Error al actualizar la TRM.";
  }
  //retornar objeto con la respuesta en el atributo value, y el mensaje en el atributo message
  echo json_encode(array('value' => $result, 'message' => $message));

  wp_die();  // Termina la ejecución de la solicitud de AJAX correctamente
}
