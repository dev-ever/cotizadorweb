<?php 

	require_once "plugins/PHPmailer/_lib/PHPMailerAutoload.php";

	date_default_timezone_get("American/Mexico_City");

	$nombre = $_POST["nombreContacto"];
	$telefono = $_POST["telefonoContacto"];
	$email = $_POST["correoContacto"];
	$mensaje = $_POST["mensajeContacto"];

	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->CharSet = "utf-8";
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "single-9060.banahosting.com";
	$mail->Username = "notificaciones@gersa.org.mx";
	$mail->Password = "@963Log1sT1c5";
	$mail->Port = 465;
	$mail->From = "notificaciones@gersa.org.mx";
	$mail->FromName= "Notificaciones Cotizaciones.";
	$mail->AddAddress("e.mauro@gersa.org.mx");
	$mail->IsHTML(true);				
	$mail->Subject = "Nueva cotización de Ferreteria '-----' ";
	$mail->WordWrap = 50;

	$mail->msgHTML('
			<div style="width: 100%; background: #eee; position: relative; font-family: sans-serif;padding: 40px">

				

				<div style="position: relative;margin: auto;width: 600px; background: white; padding: 20px">

				<center>
				
				
				<img src="http://gersalogistics.com.mx/front/imagenes/logotipo-colores.png" alt="" style="padding: 20px; width: 20%"><br> 
				<h3 style="font-weight: 100; color: #444; font-family: Century-Gothic,Arial";>	NOTIFICACIONES GERSA LOGISTICS <BR>	Tienes una nueva notificación de: '.utf8_decode($nombre).'</h3>

		
 
				<div>
					<label for="" style="text-transform: uppercase;font-weight: bold;background:#444;"<b> Nombre:</b></label>
					<p>'.utf8_decode($nombre).'</p>
				</div>
				<div>
					<label for="" style="text-transform: uppercase;font-weight: bold;background:#444;"><b> Teléfono:</b></label>
					<p>'.$telefono.'</p>
				</div>
				<div>
					<label for="" style="text-transform: uppercase;font-weight: bold;background:#444;"><b> Email:</b></label>
					<p>'.$email.'</p>
				</div>
				<div>
					<label for="" style="text-transform: uppercase;font-weight: bold;background:#444;"><b> Mensaje:/<b></label>
					<p>'.utf8_decode($mensaje).'</p>
				</div>

				<hr style="border: 1px solid #ccc; width: 80%">

				<h4 style="font-weight: 100; color:#444; padding: 0 20px; font-family: Century-Gothic,Arial"> Expedido desde la página oficial www.gersalogistics.com.mx   </h4>
				<h4 style="font-weight: 100; color:#444; padding: 0 20px; font-family: Century-Gothic,Arial"><b> ¡ Favor de dar continuidad ! </b></h4>


				</center>
											
			</div>

		</div>
	');

								
	$envio = $mail->Send();

	if(!$envio){


		$respuesta ="<center><div style='color:#A40606;font-weight:bold;text-align:center;'><strong>Error!!!</strong>  Intenta mas tarde! </div></center>".$mail->ErrorInfo;

		echo $respuesta;

	}else{

		$respuesta ="
		            <h3 style='color:#fff;text-align:center;'>
						Tus datos se han enviado correctamente !, 
						<strong> 
							¡ Nos pondremos pronto en contacto!
						</strong>
					</h3>
		           ";

		echo $respuesta;

	}




 ?>