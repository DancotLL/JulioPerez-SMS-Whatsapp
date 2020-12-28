<?php

$nom = $_POST['nom'];
$tra = $_POST['tra'];
$mail = $_POST['mail'];
$ng = $_POST['ng'];
$vf = $_POST['vf'];
$tc = $_POST['tc'];
$lib = $_POST['lib'];
$des = $_POST['des'];

if($tc == "Trafico")
{
	$asunto    = 'Notificación de Paquetes';
$cabeceras = 'From: servicioalcliente2@miamiboxgt.com' . "\r\n" .
             'Reply-To: servicioalcliente2@miamiboxgt.com' . "\r\n" .
             'X-Mailer: PHP/' . phpversion();
 	
	$mensaje = "Sr(a). $nom
	
	Por este medio le informamos que su paquete con tracking $tra se encuentra en tránsito. Por favor enviar su adjunto a nuestro Whatsapp o por este medio, al correo; servicioalcliente2@miamiboxgt.com.
	
	Si usted ya envío su adjunto, hacer caso omiso de este mensaje.";
	
}

if($tc == "Venta")
{

$asunto    = 'Notificación de Paquetes';

$cabeceras  = "MIME-Version: 1.0\r\n";
$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";

$cabeceras .= 'From: miamiboxgt.programacion@gmail.com' . "\r\n" .
             'Reply-To: miamiboxgt.programacion@gmail.com' . "\r\n" .
             'X-Mailer: PHP/' . phpversion();
 	
	$mensaje = "Sr(a). $nom
	<br><br>
	Por este medio le informamos que tenemos los siguientes paquetes disponibles para entregar
	<br><br>
	<table border = 1 cellspacing = 0 cellspadding = 0>
	<tr style  = 'background-color: #2E64FE;'>
	<td>NO. GUIA</td>
	<td>DESCRIPCION</td>
	<td>PESO EN  LIBRAS</td>
	<td>TRACKING</td>
	<td>VENTA FINAL</td>
	</tr>
	
	<tr>
	<td>$ng</td>
	<td>$des</td>
	<td>$lib</td>
	<td>$tra</td>
	<td>$vf</td>
	</tr>
	
	</table>
	<br><br>
	Formas de pago son las siguientes:<br><br>
Banco Industrial<br>
USD<br>
BAC<br>
Tarjeta en linea<br>
Paypal
	<br><br>
	* Este es un mensaje automatico, cualquier duda favor comunicarse a miamibox@miamiboxgt.com o al 23023902 por telefono o Whatsapp.
	<br><br>
	Favor confirmar si lo recibira en Oficina Central en Zona 14, Oficina Aeropuerto Z.13 o desea servicio a domicilio. el día de mañana, sábado 12 de junio, estaremos en oficina
	de 9 a 12 horas.
<br><br>
Saludos cordiales";
	

}


	if(mail($mail, $asunto, $mensaje, $cabeceras)) 
	{
		
	}
	
	$mensaje = $mensaje."
	
	Enviado a $mail";

	if(mail("servicioalcliente2@miamiboxgt.com", $asunto, $mensaje, $cabeceras)) 
	{
		
	}

echo $mensaje;

?>