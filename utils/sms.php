<?php

require_once('../constants.php');

use Twilio\Rest\Client;

$client = new Client(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);

function enviar_sms($destino, $mensaje)
{
  return "Ok";
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

function enviar_sms_test($destino, $mensaje)
{
  try {
    $url = 'https://api.twilio.com/2010-04-01/Accounts/' . TWILIO_ACCOUNT_SID . '/Messages.json';
    $data = array('To' => $destino, 'Body' => $mensaje);

    $options = array(
      'http' => array(
        'header' => array(
          "Content-type: application/x-www-form-urlencoded\r\n",
          "Authorization: Basic " . base64_encode(TWILIO_ACCOUNT_SID . ":" . TWILIO_AUTH_TOKEN),
        ),
        'method'  => 'POST',
        'content' => http_build_query($data)
      )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
      return $url;
    }
    return $result;
  } catch (Throwable $e) {
    return $e->getMessage();
  }
}
