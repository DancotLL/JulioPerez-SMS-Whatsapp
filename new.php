<?php
session_start();
date_default_timezone_set('America/Guatemala');

$fh = date('m/d/Y h:i:s A');

$opc = $_POST['opc'];
$val = $_POST['vd'];
$ng = $_POST['ng'];
$cc = $_POST['clie'];
$rem = $_POST['rem'];
$ship = $_POST['ship'];
$dir = $_POST['dir'];
$des = $_POST['des'];
$tra = $_POST['tra'];
$bul = $_POST['bul'];
$anc = $_POST['anc'];
$alt = $_POST['alt'];
$lar = $_POST['lar'];
$obs = $_POST['obs'];
$sac = $_POST['sac'];
$pl = $_POST['pl'];
$barcodeType="code128";
$barcodeDisplay="horizontal";
$barcodeSize=20;
 
$cyc = (explode(" - ",$cc));

$cli = $cyc[0];
$cas = $cyc[1];



if($cli == "0")
{
	$cli = $_SESSION['pattern'];
}

if($cas == "")
{
	$cas = "";
}


$pk = $pl/2;

if ($opc == "Guardar e Imprimir")
{
	
	echo '
	<script>
	
	function printHTML() { 
  if (window.print) { 
    window.print();
  }
}
document.addEventListener("DOMContentLoaded", function(event) {
  printHTML(); 
});
	
	function cerrar() { setTimeout(window.close,15000); }
	
	</script>
	';
	
	echo "<body onload = 'javascript:cerrar();'>";
	
	echo "<br><br><br><br><br><br><br><br><br><br>
	<div style = 'width: 3.98in; height: 2.98in;' width = 100%>

	<table style = 'font-family: Calibri; font-size: 11px;'>
	<tr>
	<td><img src = 'img/logo.png'></td>";
	echo '<td colspan = 2 style = "text-align: center;"><img style = "width: 3.98in; height: 1.5in;" alt="'.$ng.'"src="barcode.php?text='.$ng.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print="false"/><br><font style = "font-size: 32px;">'.$ng.'</font></td>
	</tr>';
	
	echo "<tr>
	<td>$cas</td>
	<td style = 'text-align: center;'>Casilleros / $fh</td>
	<td></td>
	</tr>";
	
	echo "<tr>
	<td></td>
	<td style = 'text-align: center;'>98072000000</td>
	<td></td>
	</tr>";
	
	echo "
	<tr>
	<td colspan = 2 style = 'text-align: center; border: 1px solid black'>Remitente: $rem</td>
	<td style = 'border: 1px solid black'><font style = 'font-size: 20px;'>$cli</font></td>
	</tr>
	<tr>
	<td colspan = 2 style = 'text-align: center; border: 1px solid black'>$dir</td>
	<td style = 'border: 1px solid black'></td>
	</tr>
	<tr>
	<td colspan = 2 style = 'text-align: center; border: 1px solid black'>USA-Lexington-040501</td>
	<td style = 'border: 1px solid black'>Guatemala</td>
	</tr>
	<tr>
	<td colspan = 2 style = 'text-align: center; border: 1px solid black'><font style = 'font-size: 20px;'>$des</font></td>
	<td style = 'border: 1px solid black'>Guatemala Guatemala City-100</td>
	</tr>
	<tr>
	<td colspan = 3 style = 'border: 1px solid black'>Tracking $tra</td>
	</tr>";
	
	echo "<tr>
	<td>Pago: COD(PorCobrar)</td>
	<td style = 'text-align: center;'>Peso(Lb): ".$english_format_number = number_format($pl, 2, '.', '')."</td>
	<td>Peso(Kg): ".$english_format_number = number_format($pk, 2, '.', '')."</td>
	</tr>";
	
	echo "</table>
	</div>
	</body>";
	
	//Insertar en base de datos
	
	$con = mysqli_connect("localhost:3306","boxsystem","5sng22091979","boxsyste_miami");
	
	$f = date("Y-m-d",strtotime($fh));
	$h = date("H:i:s",strtotime($fh));
	$a = date("A",strtotime($fh));
	
	$st = mysqli_query($con, "SELECT `tarifa`,`vendedor`,`electronico`,`nombre` FROM `clientes` WHERE `codigo` = '$cas'");
	$elec = '';
	$nomcli = '';
				while($mt = mysqli_fetch_array($st))
				{
					$tar = $mt[0];
					$vend = $mt[1];
					$elec = $mt[2];
					$nomcli = $mt[3];
				}
	
	//Formulas Real
			
			 $cifr = 0+$val+($val*0.02);
			 
			 $segr = $val*0.02;
			 
			 $impr = $cifr * ($arrr/100);
			 
			 $ivar = ($cifr + $impr)*0.12;
			 
			 $dair = ($cifr * 0);
			 
			 $tir = $impr + $ivar;
			 
	//Formulas Estimado
	 
			 $cif = 0+$val+($val*0.02);
			 
			 $seg = $val*0.02;
			 
			 $imp = $cif * ($arr/100);
			 
			 $iva = ($cif + $imp)*0.12;
			 
			 $dai = ($cif * 0);
			 
			 $ti = $imp + $iva;
			 
			 $val = $val; 
			 
			 $ven = $cif + $val;
			 
			if ($val >= 0 && $val <= 30){$desc = 1.5;}
			if ($val >= 31 && $val <= 100){$desc = 2.4;}
			if ($val >= 101 && $val <= 300){$desc = 4;}
			if ($val >= 301 && $val <= 500){$desc = 8;}
			if ($val >= 501 && $val <= 999){$desc = 12;}
			if ($val > 999){$desc = 65;}
			
			//Valores CIF
	
		
			$vcc = $val+($pl*0.5)+(($val+($pl*0.5))*0.022);	
			$vcm = $val+($pk*2.7)+(($val+($pk*2.7))*0.022);
	
	$bgd = mysqli_query($con, "SELECT * FROM `vuelosprov` WHERE `no_guia` = '$ng'");
	$cgd = mysqli_num_rows($bgd);
	
	if($cgd > 0)
	{
		$egd = mysqli_query($con, "DELETE FROM `vuelosprov` WHERE `no_guia` = '$ng'");
		$egdd = mysqli_query($con, "DELETE FROM `general` WHERE `no_guia` = '$ng'");
	}
	
	$btd = mysqli_query($con, "SELECT * FROM `vuelosprov` WHERE `tracking` = '$tra'");
	$ctd = mysqli_num_rows($btd);
	
	if($ctd > 0)
	{
		$etd = mysqli_query($con, "DELETE FROM `vuelosprov` WHERE `tracking` = '$tra'");
		$etdd = mysqli_query($con, "DELETE FROM `general` WHERE `tracking` = '$tra'");
	}
	
	$gd = mysqli_query($con, "INSERT INTO `vuelosprov` VALUES ('','MI','$tra','$ng','$cli','$des','$rem','$rem','$dir','$pl','$val','$cas','$anc','$alt','$lar','$bul','$obs','$f','$h','$a','No','$sac')");
	
	$ig = mysqli_query($con, "INSERT INTO `general` VALUES ('','MI','$f $h','$ng','$cli','$cas','$tar','GUATEMALA','$bul','$des','$rem','$bul','$pk','$pl','$val','$val','','$tra','$vend','0','0','0','0','0','$imp','$iva','$ti','$fle','$vcc','0','$vcm','0','$impr','$ivar','$tir','$fle','$fle','$impr','$segr','$desc','0','$ven','','','','','','','','','no','no','no','no','','','','','','','','','','','','','','','$obs','','')");
	
	if($elec!=''){
	    /*$cuerpo_m = '
	       <html>
	        <head><meta charset="gb18030"><title>Nuevo Paquete Miami Box</title></head>
            <body>
	            <font style="font-family:Calibri">Estimado Cliente Le informamos que hemos recibido el siguiente paquete en nuestras oficinas de Miami. Muy pronto usted podr®¢ ir en recogerlo a nuestra sucursal 
				 recuerde de enviarnos su factura, puede realizarlo en el siguiente link, www.miamiboxgt.com/alertar, puede ingresar al modulo de clientes para ver el status de sus paquetes.</font>
				 <br><br><hr>
				 <center>
				
				<table width="50%">
				<tbody><tr>
					<td><img src="https://ci3.googleusercontent.com/proxy/tOvo46pf-gVIIL7E6syqXc1BXw5cEWrnp58zvj2uzin9NmytIQzZmVcvaBpnDDyP_TWpp4EtWA=s0-d-e1-ft#http://boxsystem.net/images/logo.png" width="200px" height="100px" class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 0.01; left: 360.821px; top: 721.335px;"><div id=":2di" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Descargar el archivo adjunto " data-tooltip-class="a1V" data-tooltip="Descargar"><div class="wkMEBb"><div class="aSK J-J5-Ji aYr"></div></div></div></div></td>
					<td style="font-family:Calibri;text-align:right">Miami Box Guatemala<br>
					Servicio de courier entre Miami y Ciudad de
                    Guatemala.<br>
									18°„ Avenida 8-10 Zona 14, Ciudad de
                    Guatemala<br>
									+ (502) 2302-3903<br>
									<a href="mailto:info@miamiboxgt.com" rel="noreferrer noreferrer" target="_blank">info@miamiboxgt.com</a></td>
				</tr>
				</tbody></table>
				
				<form action="http://boxsystem.net/general/archivos.php" method="POST" enctype="multipart/form-data" target="_blank">
				<font style="font-family:Calibri">
				    Le recordamos que debe enviar el archivo de la factura de su proveedor. Puede adjuntarlo en la parte de abajo, o enviarlo por este medio a los correos <a href="mailto:servicioalcliente2@miamiboxgt.com" rel="noreferrer noreferrer" target="_blank">servicioalcliente2@miamiboxgt.<wbr>com</a> o <a href="mailto:miamibox@miamiboxgt.com" rel="noreferrer noreferrer" target="_blank">miamibox@miamiboxgt.com</a>, o a nuestro Whatsapp <a href="http://wa.me/50257191678" rel="noreferrer noreferrer" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://wa.me/50257191678&amp;source=gmail&amp;ust=1608239926133000&amp;usg=AFQjCNFMoOVLu0vfJDvCKxQyteDpifrrkA">dando clic en este enlace</a>. 
				</font>
				<br><br><center><input type="hidden" value="'.$tra.'" name="tra">
				<input type="hidden" value="'.$ng.'" name="gua">
				<input type="file" name="arc"><br><br>
				Observaciones ,dudas o comentarios...<br><textarea name="obs"></textarea><br><br>
				<button>Subir Archivo</button><font color="#888888">
				</font></center></form>
				
				<table border="1" cellspacing="0" width="50%">
				<tbody>
				<tr>
					<td style="background-color:#f7d358;font-family:Calibri"><b>Consignatorio</b></td>
					<td style="background-color:#f5f6ce;font-family:Calibri">'.$nomcli.'</td>
				</tr>
				<tr>
					<td style="background-color:#f7d358;font-family:Calibri"><b>Casillero</b></td>
					<td style="background-color:#f5f6ce;font-family:Calibri">'.$cas.'</td>
				</tr>
				<tr>
					<td style="background-color:#f7d358;font-family:Calibri"><b>Casillero Activo</b></td>
					<td style="background-color:#f5f6ce;font-family:Calibri">Si</td>
				</tr>
				<tr>
					<td style="background-color:#f7d358;font-family:Calibri"><b>Proveedor</b></td>
					<td style="background-color:#f5f6ce;font-family:Calibri">amazon</td>
				</tr>
				<tr>
					<td style="background-color:#f7d358;font-family:Calibri"><b>Descripci®Æn</b></td>
					<td style="background-color:#f5f6ce;font-family:Calibri">'.$des.'</td>
				</tr>
				<tr>
					<td style="background-color:#f7d358;font-family:Calibri"><b>Cantidad de Trackings</b></td>
					<td style="background-color:#f5f6ce;font-family:Calibri">1</td>
				</tr>
				<tr>
					<td style="background-color:#f7d358;font-family:Calibri"><b>Peso Total en Libras</b></td>
					<td style="background-color:#f5f6ce;font-family:Calibri">'.$pl.'</td>
				</tr>
				<tr>
					<td style="background-color:#f7d358;font-family:Calibri"><b>Valor Declarado en US$</b></td>
					<td style="background-color:#f5f6ce;font-family:Calibri">'.$val.'</td>
				</tr>	
				<tr>
					<td style="background-color:#f7d358;font-family:Calibri"><b>Status</b></td>
					<td style="background-color:#f5f6ce;font-family:Calibri">En Miami</td>
				</tr>
				<tr>
					<td style="background-color:#f7d358;font-family:Calibri"><b>Fecha Revisi®Æn</b></td>
					<td style="background-color:#f5f6ce;font-family:Calibri">17/12/2020</td>
				</tr>
				<tr>
					<td style="background-color:#f7d358;font-family:Calibri"><b>Observaciones</b></td>
					<td style="background-color:#f5f6ce;font-family:Calibri">'.$obs.'</td>
				</tr>	
				<tr>
					<td style="background-color:#f7d358;font-family:Calibri"><b>No. de Tracking</b></td>
					<td style="background-color:#f5f6ce;font-family:Calibri">'.$tra.'</td>
				</tr>	
				</tbody></table>
				
				<br><br>
				</center>
				<form action="http://boxsystem.net/general/archivos.php" method="POST" enctype="multipart/form-data" target="_blank">
				<font style="font-family:Calibri">
				    Le recordamos que debe enviar el archivo de la factura de su proveedor. Puede adjuntarlo en la parte de abajo, o enviarlo por este medio a los correos <a href="mailto:servicioalcliente2@miamiboxgt.com" rel="noreferrer noreferrer" target="_blank">servicioalcliente2@miamiboxgt.<wbr>com</a> o <a href="mailto:miamibox@miamiboxgt.com" rel="noreferrer noreferrer" target="_blank">miamibox@miamiboxgt.com</a>, o a nuestro Whatsapp <a href="http://wa.me/50257191678" rel="noreferrer noreferrer" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://wa.me/50257191678&amp;source=gmail&amp;ust=1608239926133000&amp;usg=AFQjCNFMoOVLu0vfJDvCKxQyteDpifrrkA">dando clic en este enlace</a>. 
				</font>
				<br><br><center><input type="hidden" value="'.$tra.'" name="tra">
				<input type="hidden" value="'.$ng.'" name="gua">
				<input type="file" name="arc"><br><br>
				Observaciones ,dudas o comentarios...<br><textarea name="obs"></textarea><br><br>
				<button>Subir Archivo</button><font color="#888888">
				</font></center></form>
		    </body>
           </html>';*/
            $cuerpo_m = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        
        <title>Miami Box Guatemala</title>
        <style type="text/css">
        
        
        
                         .pricingTable{
                            text-align: center;
                        }
                        .pricingTable .pricingTable-header{
                            color:#ff;
                            background: #ff8000;
                        }
                        .pricingTable .heading{
                            display: block;
                            padding-top: 25px;
                        }
                        .pricingTable .heading:after{
                            content: "";
                            border-top: 1px solid rgba(255, 255, 255 ,0.4);
                            display: inline-block;
                            width: 85%;
                        }
                        .pricingTable .heading > h3{
                            margin: 0;
                            text-transform: capitalize;
                            font-size: 20px;
                        }
                        .pricingTable .heading > span{
                            text-transform: capitalize;
                            font-size: 13px;
                            margin-top: 5px;
                            display: block;
                        }
                        .pricingTable .price-value{
                            padding-bottom: 25px;
                            display: block;
                            font-size: 34px;
                        }
                        .pricingTable-header > .price-value > .month{
                            font-size: 14px;
                            display: inline-block;
                            text-transform: uppercase;
                        }
                        .pricingTable .price-value > span{
                            display: block;
                            font-size: 14px;
                            line-height: 20px;
                        }
                        .pricingTable .pricingContent{
                            text-transform: capitalize;
                            background: #151515;
                            color:#fefeff;
                        }
                        .pricingTable .pricingContent > i{
                            font-size: 60px;
                            margin-top: 20px;
                        }
                        .pricingTable .pricingContent ul{
                            list-style: none;
                            padding: 0;
                            margin-bottom: 0;
                            text-align: left;
                        }
                        .pricingTable .pricingContent ul li{
                            padding: 12px 0;
                            border-bottom: 1px solid #000;
                            border-top: 1px solid #333;
                            width: 85%;
                            margin: 0 auto;
                        }
                        .pricingTable .pricingContent ul li:first-child{
                            border-top: 0px none;
                        }
                        .pricingTable .pricingContent ul li:last-child{
                            border-bottom: 0px none;
                        }
                        .pricingTable .pricingContent ul li:before{
                            content: "\f00c";
                            font-family: "Font Awesome 5 Free"; font-weight: 900;
                            margin-right: 10px;
                            transition:all 0.5s ease 0s;
                        }
                        .pricingTable .pricingContent ul li:hover:before{
                            margin-right: 20px;
                        }
                        .pricingTable .pricingTable-sign-up{
                            padding: 20px 0;
                            background: #151515;
                            color:#fff;
                            text-transform: capitalize;
                        }
                        .pricingTable .pricingTable-sign-up > span{
                            margin-top: 10px;
                            display: block;
                        }
                        .pricingTable .btn-block{
                            width: 40%;
                            margin: 0 auto;
                            background: #e67e22;
                            color:#fff;
                            text-transform: capitalize;
                            border: 0px none;
                            padding: 10px;
                            border-radius: 3px;
                            font-size: 17px;
                            transition:all 0.5s ease 0s;
                        }
                        .pricingTable .btn-block:hover{
                            border-radius: 12px;
                        }
                        .pricingTable .btn-block:before{
                            content: "\f07a";
                            font-family: "Font Awesome 5 Free"; font-weight: 900;
                            margin-right: 10px;
                        }
                        .pricingTable.pink .pricingTable-header{
                            background: #ed687c;
                        }
                        .pricingTable.orange .pricingTable-header{
                            background: #e67e22;
                        }
                        .pricingTable.green .pricingTable-header{
                            background: #008b8b;
                        }
                        @media screen and (max-width: 990px){
                            .pricingTable{
                                margin-bottom: 20px;
                            }
                        }
        
                     </style>
    </head>



        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <span class="heading">
                                
                               <center><img src="http://boxsystem.net/guia_florida/assets/img/logomiamibox.png"></center> 
                                <br>
                                <h2>Nuevo Paquete Recibido </h2>
                       
                                <h4>Estimado Cliente Le informamos que hemos recibido el siguiente paquete en nuestras oficinas de Miami, recuerde de enviarnos su factura.</h4>
                            </span>
                            <span class="price-value">Tracking #: '.$tra.'<span class="month"></span> <span>Favor adjunte su factura en en el siguiente link </span>
                            <span><div class="pricingTable-sign-up">
                            <a href="https://miamiboxgt.com/alertar/" class="btn btn-block btn-default">Adjuntar Factura</a>
                        </div><!-- BUTTON BOX--></span>
                        
                        <span>Ingrese a su panel de usuario para ver status de sus paquetes </span>
                        
                        <span><div class="pricingTable-sign-up">
                            <a  href="https://boxsystem.net/ap" class="btn btn-block btn-default">Ingresar al Panel</a>
                        </div><!-- BUTTON BOX--></span>
                        </div>
                        
                        
                        
                        <div class="pricingContent">
                            <ul>
                                <span><div class="pricingTable-sign-up">
                            <a  class="btn btn-block btn-default">Detalles de Paquete</a>
                        </div><!-- BUTTON BOX--></span></span>
                                <li>Consignatorio: '.$nomcli.'</li>
                                <li>Casillero: '.$cas.'</li>
                                <li class="disable">Proveedor: Amazon</li>
                                <li class="disable">Descripcion: '.$des.'</li>
                                <li class="disable">Peso en Libras: </li>
                                <li class="disable">Valor declarado en $: '.$val.'</li>
                                <li class="disable">Fecha de Ingreso: 17 Diciembre 2020</li>
                            </ul>
                        </div><!-- /  CONTENT BOX-->
                        <div class="pricingTable-sign-up">
                            <a href="#" class="btn btn-block btn-default">Adjuntar Factura</a>
                        </div><!-- BUTTON BOX-->
                    </div>
                </div>
            </div>
        </div>


        
    </body>
</html>';
	    $asunt_m = 'Nuevo Paquete Recibido en Miami';
	    //$headers_co = "MIME-Version: 1.0" . "\r\n";
	    $headers_co = "Content-type: text/html; charset=utf-8" . "\r\n From: Miami Box Guatemala". "\r\n CC: dasturias@miamiboxgt.com";
	    mail($elec,$asunt_m,$cuerpo_m,$headers_co);
	}
}

if ($opc == "Guardar y Descargar como Excel")
{
	
	//header('Content-Type: application/xls');
	//header('Content-Disposition: attachment; filename=Ticket '.$ng.'.xls');
	
	echo "<table>
	<tr>
	<td><img src = 'img/logo.png'></td>";
	echo '<td style = "text-align: center;"><img width = 232px height = 45px alt="'.$ng.'"src="barcode.php?text='.$ng.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='."true".'"/></td>';
	echo "<td style = 'text-align: center;'>&nbsp;&nbsp;&nbsp;<img src = 'img/adv.png'></td>
	</tr>";
	
	echo "<tr>
	<td><br>$cas</td>
	<td style = 'text-align: center;'><br>Casilleros / $fh</td>
	<td></td>
	</tr>";
	
	echo "<tr>
	<td></td>
	<td style = 'text-align: center;'>PEND</td>
	<td></td>
	</tr>";
	
	echo "<tr>
	<td colspan = 2 style = 'text-align: center; border: 1px solid black'>Remitente</td>
	<td style = 'border: 1px solid black'>Destinatario</td>
	</tr>
	<tr>
	<td colspan = 2 style = 'text-align: center; border: 1px solid black'>$rem</td>
	<td style = 'border: 1px solid black'>$cli</td>
	</tr>
	<tr>
	<td colspan = 2 style = 'text-align: center; border: 1px solid black'><br></td>
	<td style = 'border: 1px solid black'></td>
	</tr>
	<tr>
	<td colspan = 2 style = 'text-align: center; border: 1px solid black'>$dir</td>
	<td style = 'border: 1px solid black'></td>
	</tr>
	<tr>
	<td colspan = 2 style = 'text-align: center; border: 1px solid black'>USA-Lexington-040501</td>
	<td style = 'border: 1px solid black'>Guatemala</td>
	</tr>
	<tr>
	<td colspan = 2 style = 'text-align: center; border: 1px solid black'>Descripci√≥n: $des</td>
	<td style = 'border: 1px solid black'>Guatemala Guatemala City-100</td>
	</tr>
	<tr>
	<td colspan = 3 style = 'border: 1px solid black'>Tracking $tra</td>
	</tr>";
	
	echo "<tr>
	<td>Pago: COD(PorCobrar)</td>
	<td style = 'text-align: center;'>Peso(Lb): ".$english_format_number = number_format($pl, 2, '.', '')."</td>
	<td>Peso(Kg): ".$english_format_number = number_format($pk, 2, '.', '')."</td>
	</tr>";
	
	echo "</table>";
}
?>

</html>