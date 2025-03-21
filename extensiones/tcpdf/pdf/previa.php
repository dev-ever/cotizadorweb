<?php 

ob_start();
require_once "../../../controladores/ordenes.controlador.php";
require_once "../../../modelos/ordenes.modelo.php";
require_once "../../../controladores/solicitud-pagos.controlador.php";
require_once "../../../modelos/solicitud-pagos.modelo.php";
require_once "../../../controladores/empresa.controlador.php";
require_once "../../../modelos/empresas.modelo.php";
require_once "../../../controladores/proveedores.controlador.php";
require_once "../../../modelos/proveedores.modelo.php";
require_once "../../../controladores/rutas.controlador.php";
require_once "../../../controladores/unidad-medida.controlador.php";
require_once "../../../modelos/unidad-medida.modelo.php";
require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "tcpdf_include.php";

class imprimirOrdenPrevia extends TCPDF{

	public $q;


	public function Footer(){

		$itemSolicitudes = "ordenPago";
		$valorSolicitudes = $_GET["q"];
		$campo = "idPagos";
		$orden = "DESC";

		$sol = ControladorSolicitudPagos::ctrMostrarSolicitudPagos($itemSolicitudes, $valorSolicitudes, $campo, $orden);

		// USUARIOS COntacto
		$itemAutorizador = "id";
		$valorAutorizador = $sol["autorizador"];

		$respuestaAutorizador = ControladorUsuarios::ctrMostrarUsuarios($itemAutorizador, $valorAutorizador);
		$usuarioAutorizador = strtoupper($respuestaAutorizador["nombre"]);

		// var_dump($sol);

		$uso1 = strtoupper($sol["uso"]);
		$motivo1 =  strtoupper($sol["concepto"]);



		$this->SetY(-15);
		$imagen_footer = 'images/bottom.jpg';
		$this->Image($imagen_footer, 0, 268, 290);

		$this->html = '<table style="text-align:center;font-size:10px;">
						 <tr><td style="font-weight:bold;">AUTORIZA</td><td style="font-weight:bold;">USO</td></tr>
						 <tr><td style="font-size:7px;">'.$usuarioAutorizador.'</td><td style="font-size:7px;">'.$uso1.'</td></tr>
		               </table>';

		$this->SetY(265);
		
		$this->writeHTML($this->html, true, false, true, false, '');
	}


 
// public $q;

public function traerSolicitudOrden(){

date_default_timezone_set("America/Mexico_City");

setlocale(LC_TIME, 'es_ES.UTF-8');

$fechaCorta = date("d-m-Y H:i:s");
$fechaActual = utf8_encode(strftime("%A %d de %B del %Y"));


//LLAMADO DE LAS SOLICITUD 
$itemOrden = "solicitudPago";
$valorOrden = $this->q;
$campo = "idOrden";
$orden = "DESC";

$ordenesCreadas = ControladorOrdenes::ctrMostrarOrdenes($itemOrden, $valorOrden, $campo, $orden);


//DATOS DE LA EMPRESA
$itemEmpresa = "idEmpresa";
$valorEmpresa = $ordenesCreadas["empresa_id"];

$respuestaEmpresa = ControladorEmpresas::ctrMostrarEmpresas($itemEmpresa, $valorEmpresa);
$nombreEmpresa = $respuestaEmpresa["nombreComercial"];

$respuestaEmpresaCliente = ControladorEmpresas::ctrMostrarEmpresas($itemEmpresa, $ordenesCreadas["cliente_id"]);
$empresaCliente = $respuestaEmpresaCliente["nombreComercial"];





if($respuestaEmpresa["logotipo"]){

	 $logoEmpresa = $respuestaEmpresa["logotipo"];

}else{

	 $logoEmpresa = "vistas/img/empresas/default/no-disponible.png";

}



//DATOS DEL PROVEEDOR

$itemProveedor = "idProveedor";
$valorProveedor = $ordenesCreadas["proveedor_id"];

$respuestaProveedor = ControladorProveedores::ctrMostrarProveedores($itemProveedor, $valorProveedor);

$nombreComercial = $respuestaProveedor["nombreComercial"];

//DATOS DE GRALES DE COMPRA
$noOrden = $ordenesCreadas["idOrden"];
$fechaSolicitud = date('d / m / Y', strtotime($ordenesCreadas["dateCreated"]));
$vencimiento = date('d / m / Y', strtotime($ordenesCreadas["fechaVencimiento"])); 
//DESCRIPCIONES


//LLAMADO DE DATOS DE SOLICITUDES
$itemSolicitudes = "ordenPago";
$valorSolicitudes = $ordenesCreadas["solicitudPago"];
$campo = "idPagos";
$orden = "DESC";

$respuestaSolicitud = ControladorSolicitudPagos::ctrMostrarSolicitudPagos($itemSolicitudes, $valorSolicitudes, $campo, $orden);
$banco = $respuestaSolicitud["banco"];
$tipoPago = $respuestaSolicitud["formaPago"];
$uso = $respuestaSolicitud["uso"];
$motivo = $respuestaSolicitud["concepto"];
$items = json_decode( $respuestaSolicitud["items"], true );


$montoTotal = "$ ".number_format($respuestaSolicitud["montoTotal"],2,".",",");
$iva = "$ ".number_format($respuestaSolicitud["iva"],2,".",",");
$tasa =  $respuestaSolicitud["tasa"];
$retenciones =  "$ ".number_format($respuestaSolicitud["retenciones"],2,".",",");
$tasaISR =  $respuestaSolicitud["tasaISR"];
$retencionesISR =  "$ ".number_format($respuestaSolicitud["retISR"],2,".",",");
$subtotal = "$ ".number_format($respuestaSolicitud["subtotal"],2,".",",");


// USUARIOS COntacto
$itemUsuario = "id";
$valorUsuario = $respuestaSolicitud["session_id"];

$respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
$usuarioContacto = strtoupper($respuestaUsuario["nombre"]);



$pdf = new imprimirOrdenPrevia(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// $pdf->SetMargins(10, 25, 25);
// $pdf->SetHeaderMargin(20);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
$pdf->SetAutoPageBreak(true);

$pdf->AddPage('P','A4');

$bloque1 = <<<EOF

<table>

	
	<tr>
	   <td><img src="images/line.png"></td>
	</tr>



	<tr>
		<td rowspan="5" style="width:270px;"><img src="https://www.hubfrasangroup.com/cxpagar/$logoEmpresa" width="150px"></td>
		<td style="width:270px;text-align:right;font-weight:bold;font-size:16px;">ORDEN DE COMPRA </td>
	</tr>

	<tr>

		<td><img src="images/line.png"></td>

	</tr>

	<tr>
		
		<td style="width:95px;text-align:right;font-weight:bold;text-transform:uppercase;border-bottom:0.3px solid #A1A1A1;font-size:10px;padding:5px;">FOLIO SOLICITUD:</td>
		<td style="width:10px;border-right:0.5px solid #A1A1A1;border-bottom:0.5px solid #A1A1A1;"></td>
		<td style="width:120px;text-align:center;font-weight:bold;text-transform:uppercase;border-bottom:0.5px solid #A1A1A1;font-size:10px;"> $noOrden</td>
		<td style="width:40px;"></td>

	</tr>

	<tr>

		<td style="width:95px;text-align:right;font-weight:bold;text-transform:uppercase;border-bottom:0.3px solid #A1A1A1;font-size:10px;">FECHA:</td>
		<td style="width:10px;border-right:0.5px solid #A1A1A1;border-bottom:0.5px solid #A1A1A1;"></td>
		<td style="width:120px;text-align:center;font-weight:bold;text-transform:uppercase;border-bottom:0.5px solid #A1A1A1;font-size:10px;">$fechaSolicitud</td>
		<td style="width:40px;"></td>
		
	</tr>




	

</table>


EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');


$bloque2 = <<<EOF

<table style="padding:5px 5px;">

	<tr>
	   <td><img src="images/line.png"></td>
	</tr>

	<tr>
		<td style="width:540px;font-size:9px;text-align:center;"><b>CLIENTE:</b> $empresaCliente</td>
	</tr>
	
	<tr>
		<td style="width:270px;background-color:#efefef;text-align:center;font-weight:bold;border:0.5px solid #333;font-size:9px;">PROVEEDOR</td>
		<td style="width:270px;background-color:#efefef;text-align:center;font-weight:bold;border:0.5px solid #333;font-size:9px;">CONTACTO</td>

	</tr>

	<tr>
		<td style="width:270px;"></td>
		<td style="width:270px;"></td>
	</tr>

	<tr>
		<td style="width:270px;text-align:center;font-size:10px;font-weight:bold;">$nombreComercial</td>
		<td style="width:270px;text-align:center;font-size:10px;font-weight:bold;">$usuarioContacto</td>
	</tr>

	<tr>
		<td style="width:270px;"></td>
		<td style="width:270px;"></td>
	</tr>

	<tr>
		<td style="width:270px;background-color:#efefef;text-align:center;font-weight:bold;border:0.5px solid #333;font-size:9px;">INFORMACION BANCARIA DEL PROVEEDOR</td>
		<td style="width:270px;background-color:#efefef;text-align:center;font-weight:bold;border:0.5px solid #333;font-size:9px;">CONDICIONES DE PAGO</td>
	</tr>

	<tr>
		<td style="width:270px;"></td>
		<td style="width:270px;"></td>
	</tr>

	<tr>
		<td style="width:270px;text-align:center;font-size:10px;font-weight:bold;">$banco</td>
		<td style="width:270px;text-align:center;font-size:10px;font-weight:bold;">$tipoPago</td>
	</tr>

	<tr>
		<td style="width:270px;"></td>
		<td style="width:270px;"></td>
	</tr>


</table>


EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');




$bloque3 = <<<EOF

<table style="padding:2px 2px;">

	<tr>
		<td style="width:40px;background-color:#d3d3d3;text-align:center;font-weight:bold;border:0.5px solid #d3d3d3;font-size:9px;">Part.</td>
		<td style="width:200px;background-color:#d3d3d3;text-align:center;font-weight:bold;border:0.5px solid #d3d3d3;font-size:9px;">Descripción</td>
		<td style="width:60px;background-color:#d3d3d3;text-align:center;font-weight:bold;border:0.5px solid #d3d3d3;font-size:9px;">UME</td>
		<td style="width:60px;background-color:#d3d3d3;text-align:center;font-weight:bold;border:0.5px solid #d3d3d3;font-size:9px;">Cant.</td>
		<td style="width:80px;background-color:#d3d3d3;text-align:center;font-weight:bold;border:0.5px solid #d3d3d3;font-size:9px;">Prec. Unit.</td>
		<td style="width:100px;background-color:#d3d3d3;text-align:center;font-weight:bold;border:0.5px solid #d3d3d3;font-size:9px;">Total</td>

	</tr>


</table>


EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');


foreach ($items as $key => $value) {

	$valorKey = $key + 1;

	$respuestaUnidad = ControladorUnidadMedidas::ctrMostrarUnidadMedidas("idMedida",$value["unidadMedida"]);
	$unidad = $respuestaUnidad["clave"];

	$subTotal = number_format($value["subtotal"], 2,".",",");
	$unitario = number_format($value["unitario"], 2,".",",");

$bloque4 = <<<EOF

<table style="padding:2px 2px;">

	<tr>
		<td style="width:40px;text-align:center;font-weight:100;border:0.5px solid #d3d3d3;font-size:9px;">$valorKey</td>
		<td style="width:200px;text-align:center;font-weight:100;border:0.5px solid #d3d3d3;font-size:9px;">$value[descripcion]</td>
		<td style="width:60px;text-align:center;font-weight:100;border:0.5px solid #d3d3d3;font-size:9px;">$unidad</td>
		<td style="width:60px;text-align:center;font-weight:100;border:0.5px solid #d3d3d3;font-size:9px;">$value[cantidad]</td>
		<td style="width:80px;text-align:center;font-weight:100;border:0.5px solid #d3d3d3;font-size:9px;">$ $unitario</td>
		<td style="width:100px;text-align:center;font-weight:100;border:0.5px solid #d3d3d3;font-size:9px;">$ $subTotal</td>

	</tr>


</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');


}



if($respuestaSolicitud["iva"] >= 0.1 && $respuestaSolicitud["tasa"] >= 1 && $respuestaSolicitud["tasaISR"] >= 1){

	$bloque5 = <<<EOF

	<table style="font-size:8px; padding:2px 2px;margin:0 auto;">

		<tr>
			<td rowspan="5" style="width:360px;text-align:center;"><b>Detalles:</b> <br> $motivo</td>
			<td style="width:80px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;background-color:#efefef;font-weight:bold;">Subtotales</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;"">$subtotal</td>
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">IVA 16%</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;"">$iva</td>
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Ret. de IVA $tasa%</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;"">$retenciones</td>	
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Ret. de ISR $tasaISR%</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;"">$retencionesISR</td>	
		</tr>
			

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Total Neto:</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;"">$montoTotal</td>	
		</tr>



	</table>


EOF;

}else if($respuestaSolicitud["iva"] >= 0.1 && $respuestaSolicitud["tasa"] >= 1){


$bloque5 = <<<EOF

	<table style="font-size:8px; padding:2px 2px;margin:0 auto;">

		<tr>
			<td rowspan="4" style="width:360px;text-align:center;"><b>Detalles:</b> <br> $motivo</td>
			<td style="width:80px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;background-color:#efefef;font-weight:bold;">Subtotal</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$subtotal</td>
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;"> IVA 16 %</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$iva</td>	
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Ret de IVA $tasa %</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$retenciones</td>	
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Total Neto:</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$montoTotal</td>	
		</tr>

	</table>


EOF;


}else if($respuestaSolicitud["iva"] >= 0.1 && $respuestaSolicitud["tasaISR"] >= 1){

	$bloque5 = <<<EOF

	<table style="font-size:8px; padding:2px 2px;margin:0 auto;">

		<tr>
			<td rowspan="4" style="width:360px;text-align:center;"><b>Detalles:</b> <br> $motivo</td>
			<td style="width:80px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;background-color:#efefef;font-weight:bold;">Subtotal</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$subtotal</td>
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">IVA 16%</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$iva</td>	
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Ret de ISR $tasaISR %</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$retencionesISR</td>	
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Total Neto:</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$montoTotal</td>	
		</tr>

	</table>
EOF;


}else if($respuestaSolicitud["iva"] == 0 && $respuestaSolicitud["tasa"] >= 1 && $respuestaSolicitud["tasaISR"] >= 1){

$bloque5 = <<<EOF

	<table style="font-size:8px; padding:2px 2px;margin:0 auto;">

		<tr>
			<td rowspan="4" style="width:360px;text-align:center;"><b>Detalles:</b> <br> $motivo</td>
			<td style="width:80px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;background-color:#efefef;font-weight:bold;">Subtotal</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$subtotal</td>
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Ret de IVA $tasa %</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$retenciones</td>	
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Ret de IVA $tasaISR %</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$retencionesISR</td>	
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Total Neto:</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$montoTotal</td>	
		</tr>

	</table>

EOF;


}else if($respuestaSolicitud["iva"] == 0 && $respuestaSolicitud["tasa"] >= 1){

$bloque5 = <<<EOF

	<table style="font-size:8px; padding:2px 2px;margin:0 auto;">

		<tr>
			<td rowspan="3" style="width:360px;text-align:center;"><b>Detalles:</b> <br> $motivo</td>
			<td style="width:80px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;background-color:#efefef;font-weight:bold;">Subtotal</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$subtotal</td>
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Ret de IVA $tasa %</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$retenciones</td>	
		</tr>

		<tr>
			
			<td style="width:80x;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Total Neto:</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$montoTotal</td>	
		</tr>

	</table>

EOF;

}else if($respuestaSolicitud["iva"] == 0 && $respuestaSolicitud["tasaISR"] >= 1){

$bloque5 = <<<EOF

	<table style="font-size:8px; padding:2px 2px;margin:0 auto;">

		<tr>
			<td rowspan="3" style="width:360px;text-align:center;"><b>Detalles:</b> <br> $motivo</td>
			<td style="width:80px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;background-color:#efefef;font-weight:bold;">Subtotal</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$subtotal</td>
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Ret de ISR $tasaISR %</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$retencionesISR</td>	
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Total Neto:</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$montoTotal</td>	
		</tr>

	</table>

EOF;

}else if($respuestaSolicitud["iva"] >= 0.1){

$bloque5 = <<<EOF

	<table style="font-size:8px; padding:2px 2px;margin:0 auto;">

		<tr>
			<td rowspan="3" style="width:360px;text-align:center;"><b>Detalles:</b> <br> $motivo</td>
			<td style="width:80px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;background-color:#efefef;font-weight:bold;">Subtotal</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$subtotal</td>
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;"> IVA 16 %</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$iva</td>	
		</tr>

		<tr>
			
			<td style="width:80px;border:0.5px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:9px;font-weight:bold;">Total Neto:</td>
			<td style="width:100px;border:0.5px solid #d3d3d3;text-align:center;font-size:9px;font-weight:bold;">$montoTotal</td>	
		</tr>

	</table>

EOF;


}



$pdf->writeHTML($bloque5, false, false, false, false, '');

ob_end_clean();


 $pdf->Output('previa-'.$valorOrden."-".date('Ymd H:i:s').'.pdf','I');


	}
}



if(isset($_GET["q"])){

	$printOrden = new imprimirOrdenPrevia();
	$printOrden ->  q = $_GET["q"];
	$printOrden -> traerSolicitudOrden();
	

	
}




 ?>