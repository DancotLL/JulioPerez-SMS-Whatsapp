<?php

use Twilio\Rest\Client;

$twilio = new Client(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);

function send_whatsapp_message($to_number, $message)
{
  try {
    global $twilio;

    $message = $twilio->messages
      ->create(
        "whatsapp:" . $to_number,
        array(
          "from" => TWILIO_WHATSAPP_NUMBER,
          "body" => $message
        )
      );
    return "Mensaje enviado correctamente";
  } catch (Throwable $e) {
    return $e->getMessage();
  }
}
