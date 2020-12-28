<?php

function validate_parameters(&$xml)
{
  $missing_params = array();

  if (!$xml->destination_number) $xml->destination_number = $_POST['destination_number'];
  if (!$xml->message) $xml->message = $_POST['message'];
  if (!$xml->send_sms) $xml->send_sms = $_POST['send_sms'];
  if (!$xml->send_whatsapp) $xml->send_whatsapp = $_POST['send_whatsapp'];

  if (empty($xml->destination_number)) $missing_params[] = "destination_number";
  if (empty($xml->message)) $missing_params[] = "message";
  if (empty($xml->send_sms)) $missing_params[] = "send_sms";
  if (empty($xml->send_whatsapp)) $missing_params[] = "send_whatsapp";

  if (count($missing_params)) {
    echo json_encode([
      'missing_params' => $missing_params,
      'xml' => $xml,
      'form_data' => $_POST
    ]);
    http_response_code(400);
    die();
  }

  if ($xml->send_sms == "false" && $xml->send_whatsapp == "false") {
    echo json_encode([
      'error' => "send_sms o send_whatsapp debe estar en true",
      'xml' => $xml,
      'form_data' => $_POST
    ]);
    http_response_code(400);
    die();
  }
}
