<?php

use Twilio\Rest\Client;

$client = new Client(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);

function send_sms($to_number, $message)
{
  try {
    return "okkk";
    global $client;

    $client->messages->create(
      $to_number,
      array(
        'from' => TWILIO_SMS_NUMBER,
        'body' => $message
      )
    );
    return "Mensaje enviado correctamente";
  } catch (Throwable $e) {
    return $e->getMessage();
  }
}
