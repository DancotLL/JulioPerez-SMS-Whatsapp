<?php

require __DIR__ . '/../vendor/autoload.php';

$xml = json_decode(file_get_contents('php://input'));
require_once('../constants.php');
require_once('request_validator.php');
require_once('../utils/sms.php');
require_once('../utils/whatsapp.php');

header('Content-Type: application/json');

validate_parameters($xml);

$response = array();
if ($xml->send_sms == "true") $response['sms_result'] = enviar_sms($xml->destination_number, $xml->message);
if ($xml->send_whatsapp == "true") $response['whatsapp_result'] = enviar_whatsapp($xml->destination_number, $xml->message);

echo json_encode($response);
