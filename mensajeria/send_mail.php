<?php
//send_mail.php

if(isset($_POST['email_data']))
{
	require 'class/class.phpmailer.php';
	$output = '';
	foreach($_POST['email_data'] as $row)
	{
		$mail = new PHPMailer;
		$mail->IsSMTP();								//Sets Mailer to send message using SMTP
		$mail->Host = 'smtp.gmail.com';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
		$mail->Port = '465';								//Sets the default SMTP server port
		$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
		$mail->Username = 'mensajeriambx@gmail.com';					//Sets SMTP username
		$mail->Password = 'Moon22()';					//Sets SMTP password
		$mail->SMTPSecure = 'ssl';							//Sets connection prefix. Options are "", "ssl" or "tls"
		$mail->From = 'mensajeriambx@gmail.com';			//Sets the From email address for the message
		$mail->FromName = 'MIAMI BOX GUATEMALA';					//Sets the From name of the message
		$mail->AddAddress($row["email"], $row["nombre"]);	//Adds a "To" address
		$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
		$mail->IsHTML(true);							//Sets message type to HTML
		$mail->Subject = 'NOT REPLY'; //Sets the Subject of the message
		//An HTML or plain text message body
		$mail->Body = ' 
		<p>Miami Box Guatemala</p>
		<!--<p>Fecha de creacion: 9/21/2020 11:19:22 AM No. de guia:GUA4520019139</p>-->

<div class="table-responsive-lg">
<!--<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
     
      <th scope="col">REMITENTE</th>
      <th scope="col">DESTINATARIO</th>
      <th scope="col">TOTAL FACTURA</th>
    </tr>
  </thead>
  <tbody>
    <tr>
    
      <td>Miami Box Guatemala </td>
      <td>CLIENTE: XXXX</td>
      <td>TOTAL: XXX</td>
    </tr>
    <tr>

      <td>PAGAR TOTAL: XXXXX</td>
      <td>TRACKING:</td>
      <td>PAGAR AHORA: $$$</td>
    </tr>
   
  </tbody>
</table>
</table>-->
		
		Sr(a). Diego Asturias
	
	Por este medio le informamos que su paquete con tracking TBA9344808601 se encuentra en tránsito. Por favor enviar su adjunto a nuestro Whatsapp o por este medio, al correo; servicioalcliente2@miamiboxgt.com.
	
	Si usted ya envío su adjunto, hacer caso omiso de este mensaje.';

		$mail->AltBody = '';

		$result = $mail->Send();						//Send an Email. Return true on success or false on error

		if($result["code"] == '400')
		{
			$output .= html_entity_decode($result['full_error']);
		}

	}
	if($output == '')
	{
		echo 'ok';
	}
	else
	{
		echo $output;
	}
}

?>