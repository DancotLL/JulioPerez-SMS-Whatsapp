<?php

require_once('../constants.php');

use Twilio\Rest\Client;

$client = new Client(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);

function enviar_sms($destino, $mensaje)
{
  try {
    global $client;

    $client->messages->create(
      $destino,
      array(
        'from' => TWILIO_SMS_NUMBER,
        'body' => $mensaje
      )
    );
    return "Mensaje enviado correctamente";
  } catch (Throwable $e) {
    return $e->getMessage();
  }
}
