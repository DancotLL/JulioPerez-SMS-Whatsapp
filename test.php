<?php

$telefono = "12345678901";

if (strlen($telefono) < 11) {
  $telefono = "502" . $telefono;
}

echo $telefono;
