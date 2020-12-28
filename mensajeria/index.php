<?php
//index.php

$connect = new PDO("mysql:host=localhost:3306;dbname=boxsyste_miami", "boxsystem", "5sng22091979");
$query = "SELECT * FROM clientes ORDER BY ID";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

?>
<!DOCTYPE html>
<html>
	<head>
		<title>ENVIO DE MENSAJERIA - CORREOS ELECTRONICOS CLIENTES MBX</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<h3 align="center">ENVIO DE MENSAJERIA - CORREOS ELECTRONICOS CLIENTES MBX</h3>
			<br />
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
				    	<tr>
						<td colspan="3"></td>
						<td><button type="button" name="bulk_email" class="btn btn-info email_button" id="bulk_email" data-action="bulk">Enviar a Seleccionados</button></td></td>
					</tr>
					<tr>
						<th>NOMBRE CLIENTE</th>
						<th>CORREO</th>
						<th>CODIGO</th>
						<th>SELECCIONE</th>
						<th>ACCION</th>
					</tr>
				<?php
				$count = 0;
				foreach($result as $row)
				{
					echo '
					<tr>
						<td>'.$row["nombre"].'</td>
						<td>'.$row["electronico"].'</td>
						<td>'.$row["codigo"].'</td>
						<td>
							<input type="checkbox" name="single_select" class="single_select" data-email="'.$row["electronico"].'" data-name="'.$row["nombre"].'" />
						</td>
						<td>
							<button type="button" name="email_button" class="btn btn-info btn-xs email_button" id="'.$count.'" data-email="'.$row["electronico"].'" data-name="'.$row["nombre"].'" data-action="single">Enviar Correo</button>
							<button type="button" name="message_button" class="btn btn-info btn-xs message_button" id="sms_'.$count.'" data-destination_number="'.$row["telefono"].'" data-message="Te informamos que el paquete está en camino" data-send_sms="true" data-send_whatsapp="false">Enviar SMS</button>
							<button type="button" name="message_button" class="btn btn-info btn-xs message_button" id="whatsapp_'.$count.'" data-destination_number="'.$row["telefono"].'" data-message="Te informamos que el paquete está en camino" data-send_sms="false" data-send_whatsapp="true">Enviar WhatsApp</button>
						</td>
					</tr>
					';

					$count = $count + 1;
				}
				?>
					<tr>
						<td colspan="3"></td>
						<td><button type="button" name="bulk_email" class="btn btn-info email_button" id="bulk_email" data-action="bulk">Enviar a Seleccionados</button></td></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>

<script>
$(document).ready(function(){
	$('.email_button').click(function(){
		$(this).attr('disabled', 'disabled');
		var id  = $(this).attr("id");
		var action = $(this).data("action");
		var email_data = [];
		if(action == 'single')
		{
			email_data.push({
				email: $(this).data("email"),
				name: $(this).data("cliente")
			});
		}
		else
		{
			$('.single_select').each(function(){
				if($(this).prop("checked") == true)
				{
					email_data.push({
						email: $(this).data("email"),
						name: $(this).data('cliente')
					});
				}
			});
		}

		$.ajax({
			url:"send_mail.php",
			method:"POST",
			data:{email_data:email_data},
			beforeSend:function(){
				$('#'+id).html('Enviando...');
				$('#'+id).addClass('btn-danger');
			},
			success:function(data){
				if(data == 'ok')
				{
					$('#'+id).text('Success');
					$('#'+id).removeClass('btn-danger');
					$('#'+id).removeClass('btn-info');
					$('#'+id).addClass('btn-success');
				}
				else
				{
					$('#'+id).text(data);
				}
				$('#'+id).attr('disabled', false);
			}
		})

	});

	$('.message_button').click(function(){
		const id  = $(this).attr("id");
		const hasSuccess = $(this).attr('class').split(' ').includes('btn-success');

		if (hasSuccess) return;

		$(this).attr('disabled', 'disabled');

		$.ajax({
			url:"/message/index.php",
			method:"POST",
			data: {
				destination_number: $(this).data("destination_number"),
				message: $(this).data("message"),
				send_sms: $(this).data("send_sms").toString(),
				send_whatsapp: $(this).data("send_whatsapp").toString(),
			},
			beforeSend:function(){
				$('#'+id).html('Enviando...');
				$('#'+id).addClass('btn-danger');
			},
			success:function(data, textStatus, xhr){
				$('#'+id).text(xhr.status);
				$('#'+id).text('Success');
				$('#'+id).removeClass('btn-danger');
				$('#'+id).removeClass('btn-info');
				$('#'+id).addClass('btn-success');
				$('#'+id).attr('disabled', false);
			}
		})

	});
});
</script>





