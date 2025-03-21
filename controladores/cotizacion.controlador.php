<?php
class ControladorCotizacion{
	static public function ctrMostrarCotizaciones($item, $valor){
		$tabla = "cotizador";
		$respuesta = ModeloCotizacion::mdlMostrarCotizaciones($tabla,$item,$valor);
		return $respuesta;
	} 
/*=============================================
=            CREAR COTIZACION           =
=============================================*/
static public function ctrCrearCotizacion(){

	if(isset($_POST['nuevaCotizacion'])){


		require_once "../vistas/modulos/email/class.phpmailer.php";
		require_once "../vistas/modulos/email/class.smtp.php";

		$tabla = "cotizador";
		/*=============================================
		=            LLAMAR ULTIMO ID-CODIGO         =
=		============================================*/
			$respuestaID = ModeloCotizacion::mdlUltimoCodigo($tabla);
			$nuevoID = ($respuestaID) + 1;
		/*=============================================
		=            CREAR COTiZACION           =
=		============================================*/
		$listaProductos = json_decode($_POST["listaProductos"], true);
		$datos = array ("id_vendedor"=>$_POST["idVendedor"],
						"id_cliente"=>$_POST["telefono"],
						"codigo"=>$nuevoID,
						"nombreCliente"=>$_POST["nombreCliente1"],
						"emailCliente"=>$_POST["emailCliente"],
						"productos"=>$_POST["listaProductos"],
						"impuesto"=>$_POST["nuevoPrecioImpuesto"],
						"neto"=>$_POST["nuevoPrecioNeto"],
						"total"=>$_POST["totalCotizacion"],
						"observaciones" => $_POST["observaciones"]);

		$respuesta = ModeloCotizacion::mdlIngresarCotizacion($tabla, $datos);

		if($respuesta == "ok"){

			$productos = json_decode($_POST["listaProductos"], true);

				date_default_timezone_set("America/Mexico_City");

					$mail = new PHPMailer;
					$mail->isSMTP();
					$mail->CharSet="utf-8";
					$mail->SMTPAuth= true;
					$mail->SMTPSecure ="ssl";
					$mail->Host = "smtp.hostinger.com";
					$mail->Username = "info@emauro.com.mx";
					$mail->Password = "$Hidedark0306";
					$mail->Port = 465;
					$mail->From = "info@emauro.com.mx";
					$mail->FromName= "Area de Ventas - Ferreteria XYZ - Nueva Cotización.";
					$mail->AddAddress("emr_123@hotmail.com");
					$mail->AddAddress($_POST["emailCliente"]);
					$mail->IsHTML(true);
					$mail->Subject = "Nueva cotización generada";
					$mail->WordWrap = 50;

					// $mail->msgHTML('
					$mails = '<div style="width: 100%; background: #eee; position: relative; font-family: sans-serif;padding: 40px">
								<center>
									<img src="vistas/img/plantilla/logo-negro-bloque.png" alt="" style="padding: 20px; width: 20%">
								</center>
										<div style="position: relative;margin: auto;width: 600px; background: white; padding: 20px">
											<center>
												<img src="vistas/img/plantilla/icono-negro.png" style="padding: 20px; width: 15%" >
												<h3 style="font-weight: 100; color: #444; font-family: Century-Gothic,Arial";>DEPARTAMENTO DE VENTAS <BR>Nueva Cotización Generada para : '.$_POST["nombreCliente1"].'</h3>
												<h3 style="font-weight: 100; color: #444; font-family: Century-Gothic,Arial";><b>Descripción de la Cotización:</b><br> Cotización #'.$nuevoID.'  </h3>
												<table style="font-size:10px; padding:5px 10px;">
												<tr>
													<td style="border:1px solid #666;background-color:white; width:120px; text-align:center;font-weight:bold;">Cantidad</td>
													<td style="border:1px solid #666;background-color:white; width:80px; text-align:center;font-weight:bold;">Unidad</td>
													<td style="border:1px solid #666;background-color:white; width:260px; text-align:center;font-weight:bold;">Descripción</td>
													<td style="border:1px solid #666;background-color:white; width:100px; text-align:center;font-weight:bold;">Tiempo Entrega</td>
													<td style="border:1px solid #666;background-color:white; width:100px; text-align:center;font-weight:bold;">Precio</td>
													<td style="border:1px solid #666;background-color:white; width:100px; text-align:center;font-weight:bold;">Total</td>
													
												</tr>';
								foreach ($productos as $key => $item) {
					$mails .= '				<tr style="border-bottom:1px solid #666">
													<td style="text-align:center">'.$item["cantidad"].'</td>
													<td style="text-align:center">'.$item["unidad"].'</td>
													<td style="text-align:center">'.$item["descripcion"].'</td>
													<td style="text-align:center">'.$item["entrega"].'</td>
													<td style="text-align:center">$ '.$item["precio"].'</td>
													<td style="text-align:center">$ '.$item["total"].'</td>
													
											</tr>';
														
											}
					$mails .= '		<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align:center;font-weight:bold;">Iva 16%: </td>
										<td style="border-bottom:1px solid #666;border-top:1px solid #666;text-align:center;font-weight:bold;">$ '.$_POST["nuevoPrecioImpuesto"].'</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align:center;font-weight:bold;">Neto: </td>
										<td style="border-bottom:1px solid #666;text-align:center;font-weight:bold;">$ '.$_POST["nuevoPrecioNeto"].'</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align:center;font-weight:bold;">Total: </td>
										<td style="border-bottom:1px solid #666;text-align:center;font-weight:bold;">$ '.$_POST["totalCotizacion"].'</td>
									</tr>
									<tr>
										<td></td>
										<td>Observaciones:</td>
										<td colspan="2" style="border:1px solid #666;text-align:center;">'.$_POST["observaciones"].'</td>
									</tr>
					</table>
												<hr style="border: 1px solid #ccc; width: 80%">
												<h4 style="font-weight: 100; color:#444; padding: 0 20px; font-family: Century-Gothic,Arial"> Para dar seguimiento a su cotización contactenos al <strong> (55) 6886 - 1175 o via email </strong> </h4>
												<h4 style="font-weight: 100; color:#444; padding: 0 20px; font-family: Century-Gothic,Arial"><b> ¡ Gracias por visitarnos ! </b></h4>
												<div>
													<a href="https://www.facebook.com/" target="_blank"><img  style="margin:15px;" src="vistas/img/plantilla/facebook.png" width="25px" alt=""></a> 
													<a href="https://www.twitter.com/" target="_blank"><img  style="margin:15px;" src="vistas/img/plantilla/gorjeo.png" width="25px" alt=""></a> 
													<a href="https://www.youtube.com/" target="_blank"><img  style="margin:15px;" src="vistas/img/plantilla/youtube.png" width="25px" alt=""></a> 
												    <a href="https://www.instagram.com/" target="_blank"><img style="margin:15px;" src="vistas/img/plantilla/instagram.png" width="25px" alt=""></a>
												</div>
											</center>
											
										</div>
									</div>';
					
					$mail->msgHTML($mails);
							
							
							$envio = $mail->Send();
							if(!$envio){
									echo '<script>
												swal({
													type: "error", 
													title: "¡Ha ocurrido un problema enviando notificación a: '.$_POST['emailCliente'].$mail->ErrorInfo.' !", 
													showConfirmButton: true,
													confirmButtonText: "Cerrar",
													closeOnConfirm: false
													}).then((result)=> {
														if(result.value){
															window.location = "cotizaciones";
														}
													}); 
												
											</script>';
									}else{
											echo '<script>
													swal({
														title: "¡OK!", 
														text: "Se ha notificado por email:'.$_POST["emailCliente"].' su nueva cotización",
														type:"success",
														confirmButtonText: "Cerrar",
														closeOnConfirm: false
														}).then(function(result){
																if(result.value){
																	window.location= "cotizaciones";
																}
														
														}); 
												   </script>';
									}
							}else{
								echo '
										 <script>
											swal({
												type: "danger",
												title: "¡ ERROR! !",
												showConfirmButton: true,
												confirmButtonText: "Cerrar"
												}).then(function(result){
													
													if(result.value){
													
														window.location = "cotizaciones";
													
													}
											 	});
										</script>';
							}
						
		}
	}
/*=============================================
=            EDITAR COTIZACION           =
=============================================*/
static public function ctrEditarCotizacion(){
	if(isset($_POST['editarCotizacion'])){
		/*=============================================
		=            EDITAR COTiZACION           =
=		============================================*/
		// $listaProductos = json_decode($_POST["listaProductos"], true);
		$tabla= "cotizador";
		$item = "codigo";
		$valor = $_POST["editarCotizacion"];
		$traerCotizacion = ModeloCotizacion::mdlMostrarCotizaciones($tabla,$item, $valor);
	
		if($_POST["listaProductos"] == ""){
		 	$listaProductos = $traerCotizacion["productos"];
		 	// var_dump($listaProductos);
		 }else{
			$listaProductos = $_POST["listaProductos"];
			// var_dump($listaProductos);
		}
	
		$datos = array ("id_vendedor"=>$_POST["idVendedor"],
						"id_cliente"=>$_POST["editarTelefono"],
						"codigo"=>$_POST["editarCotizacion"],
						"nombreCliente"=>$_POST["nombreCliente1"],
						"emailCliente"=>$_POST["emailCliente"],
						"productos"=>$listaProductos,
						"impuesto"=>$_POST["nuevoPrecioImpuesto"],
						"neto"=>$_POST["nuevoPrecioNeto"],
						"total"=>$_POST["totalCotizacion"],
						"observaciones"=>$_POST["observaciones"]
						);
		 $respuesta = ModeloCotizacion::mdlEditarCotizacion($tabla, $datos);
		if($respuesta == "ok"){
				
				$productos = json_decode($listaProductos, true);
					
				date_default_timezone_set("America/Mexico_City");
					$mail = new PHPMailer;
					$mail->isSMTP();
					$mail->CharSet="utf-8";
					$mail->SMTPAuth= true;
					$mail->SMTPSecure ="ssl";
					$mail->Host ="lek-system.com";
					$mail->Username="cotizaciones@lek-system.com";
					$mail->Password ="Kike04071987";
					$mail->Port = 465;
					$mail->From = "cotizaciones@lek-system.com";
					$mail->FromName= "Area de Ventas - Ferreteria XYZ - Nueva Cotización.";
					$mail->AddAddress("emr_123@hotmail.com");
					$mail->AddAddress("sanchenro@gmail.com");
					$mail->AddAddress($_POST["emailCliente"]);
					$mail->IsHTML(true);
					$mail->Subject = "Cotización Editada Generada!";
					$mail->WordWrap = 50;
					
						
					
					// $mail->msgHTML('
					$mails = '
							<div style="width: 100%; background: #eee; position: relative; font-family: sans-serif;padding: 40px">
								<center>
								
									<img src="vistas/img/plantilla/logo-negro-bloque.png" alt="" style="padding: 20px; width: 20%">
								
								</center>
								<div style="position: relative;margin: auto;width: 600px; background: white; padding: 20px">
								<center>
									<img src="vistas/img/plantilla/icono-negro.png" style="padding: 20px; width: 15%" >
										<h3 style="font-weight: 100; color: #444; font-family: Century-Gothic,Arial";>DEPARTAMENTO DE VENTAS <BR>Nueva Cotización Generada para : '.$_POST["nombreCliente1"].'</h3>
										<h3 style="font-weight: 100; color: #444; font-family: Century-Gothic,Arial";><b>Descripcion de la Cotización:</b><br> Cotización Cot- '.$_POST["editarCotizacion"].'  </h3>
										<table style="font-size:10px; padding:5px 10px;">
										<tr>
											<td style="border:1px solid #666;background-color:white; width:120px; text-align:center;font-weight:bold;">Cantidad</td>
											<td style="border:1px solid #666;background-color:white; width:80px; text-align:center;font-weight:bold;">Unidad</td>
											<td style="border:1px solid #666;background-color:white; width:260px; text-align:center;font-weight:bold;">Descripción</td>
											<td style="border:1px solid #666;background-color:white; width:100px; text-align:center;font-weight:bold;">Tiempo Entrega</td>
											<td style="border:1px solid #666;background-color:white; width:100px; text-align:center;font-weight:bold;">Precio</td>
											<td style="border:1px solid #666;background-color:white; width:100px; text-align:center;font-weight:bold;">Total</td>
										</tr>';
										foreach ($productos as $key => $item) {
											$mails .= '	<tr style="border-bottom:1px solid #666">
															<td style="text-align:center">'.$item["cantidad"].'</td>
															<td style="text-align:center">'.$item["unidad"].'</td>
															<td style="text-align:center">'.$item["descripcion"].'</td>
															<td style="text-align:center">'.$item["entrega"].'</td>
															<td style="text-align:center">$ '.$item["precio"].'</td>
															<td style="text-align:center">$ '.$item["total"].'</td>
														</tr>';
											}
					$mails .= '		<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align:center;font-weight:bold;">Iva 16%: </td>
										<td style="border-bottom:1px solid #666;border-top:1px solid #666;text-align:center;font-weight:bold;">$ '.$_POST["nuevoPrecioImpuesto"].'</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align:center;font-weight:bold;">Neto: </td>
										<td style="border-bottom:1px solid #666;text-align:center;font-weight:bold;">$ '.$_POST["nuevoPrecioNeto"].'</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align:center;font-weight:bold;">Total: </td>
										<td style="border-bottom:1px solid #666;text-align:center;font-weight:bold;">$ '.$_POST["totalCotizacion"].'</td>
									</tr>
									<tr>
										<td></td>
										<td>Observaciones:</td>
										<td colspan="2" style="border:1px solid #666;text-align:center;">'.$_POST["observaciones"].'</td>
									</tr>
				</table>
		 										<hr style="border: 1px solid #ccc; width: 80%">
		 										<h4 style="font-weight: 100; color:#444; padding: 0 20px; font-family: Century-Gothic,Arial"> Para dar seguimiento a su cotización contactenos al <strong> (55) 6886 - 1175 o via email </strong> </h4>
												<h4 style="font-weight: 100; color:#444; padding: 0 20px; font-family: Century-Gothic,Arial"><b> ¡ Gracias por visitarnos ! </b></h4>
												<div>
													<a href="https://www.facebook.com/" target="_blank"><img  style="margin:15px;" src="vistas/img/plantilla/facebook.png" width="25px" alt=""></a> 
													<a href="https://www.twitter.com/" target="_blank"><img  style="margin:15px;" src="vistas/img/plantilla/gorjeo.png" width="25px" alt=""></a> 
													<a href="https://www.youtube.com/" target="_blank"><img  style="margin:15px;" src="vistas/img/plantilla/youtube.png" width="25px" alt=""></a> 
												    <a href="https://www.instagram.com/" target="_blank"><img style="margin:15px;" src="vistas/img/plantilla/instagram.png" width="25px" alt=""></a>
												</div>
										</center>
											
									</div>
								</div>';
		 				$mail->msgHTML($mails);
							
							
		 		$envio = $mail->Send();
						if(!$envio){
									echo '<script>
												swal({
													type: "error", 
													title: "¡Ha ocurrido un problema enviando notificación a: '.$_POST['emailCliente'].$mail->ErrorInfo.' !", 
													showConfirmButton: true,
													confirmButtonText: "Cerrar",
													closeOnConfirm: false
													}).then((result)=> {
														if(result.value){
															window.location = "cotizaciones";
														}
													}); 
												
											</script>';
									}else{
											echo '<script>
													swal({
														title: "¡OK!", 
														text: "Se ha notificado por email: '.$_POST["emailCliente"].' su nueva edición de cotización",
														type:"success",
														confirmButtonText: "Cerrar",
														closeOnConfirm: false
														}).then(function(result){
																if(result.value){
																	window.location= "cotizaciones";
																}
														
														}); 
												   </script>';
									}
									
							}else{
								echo '
										 <script>
											swal({
												type: "danger",
												title: "¡ ERROR! !",
												showConfirmButton: true,
												confirmButtonText: "Cerrar"
												}).then(function(result){
													
													if(result.value){
													
														window.location = "cotizaciones";
													
													}
											 	});
										</script>';
							}
						
		 }
	}
/*=============================================
	MOSTRAR TOTAL USUARIOS
=============================================*/
	static public function ctrContarCotizacion(){
		$tabla = "cotizador";
		$respuesta = ModeloCotizacion::MdlContarCotizacion($tabla);
		return $respuesta;
	}
}
?>