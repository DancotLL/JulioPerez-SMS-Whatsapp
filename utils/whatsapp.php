<?php

require_once('../constants.php');

use Twilio\Rest\Client;

$twilio = new Client(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);

function enviar_whatsapp($destino, $mensaje)
{
  try {
    global $twilio;

    $message = $twilio->messages
      ->create(
        "whatsapp:" . $destino,
        array(
          "from" => TWILIO_WHATSAPP_NUMBER,
          "body" => $mensaje
        )
      );
    return "Mensaje enviado correctamente";
  } catch (Throwable $e) {
    return $e->getMessage();
  }
}
