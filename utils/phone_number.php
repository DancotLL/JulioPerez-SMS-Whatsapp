<?php

function formatear_telefono(&$telefono)
{
  if (strlen($telefono) < 11) {
    $telefono = "502" . $telefono;
  }
  $telefono = "+" . $telefono;
}
