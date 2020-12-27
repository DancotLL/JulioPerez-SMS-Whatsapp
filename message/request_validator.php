<?php

function validate_parameters($xml)
{
  $missing_params = array();
  if (empty($xml->destination_number)) $missing_params[] = "destination_number";
  if (empty($xml->message)) $missing_params[] = "message";

  if (count($missing_params)) {
    echo json_encode([
      'missing_params' => $missing_params
    ]);
    http_response_code(400);
    die();
  }
}
