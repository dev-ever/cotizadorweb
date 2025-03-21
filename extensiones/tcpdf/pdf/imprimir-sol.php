<?php 

ob_start();
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

class imprimirSolicitud{
 
public $sol;

public function traerSolicitud(){

// setlocale(LC_TIME, "spanish"); 

setlocale(LC_TIME, 'es_ES.UTF-8');

date_default_timezone_set("America/Mexico_City");

$fechaCorta = date("d-m-Y H:i:s");
$fechaActual = (strftime("%A %d de %B del %Y"));


//LLAMADO DE LAS SOLICITUD 
$itemSolicitud = "idPagos";
$valorSolicitud = $this->sol;
$campo = "idPagos";
$orden = "DESC";

$solicitudesCreadas = ControladorSolicitudPagos::ctrMostrarSolicitudPagos($itemSolicitud, $valorSolicitud, $campo, $orden);

$itemSesion = "id";
$valorSesion = $solicitudesCreadas["session_id"];

$usuarios = ControladorUsuarios::ctrMostrarUsuarios($itemSesion, $valorSesion);
$sesionName = $usuarios["nombre"];

$orden = $solicitudesCreadas["ordenPago"];
$empresa = $solicitudesCreadas["empresa_id"];
$cliente = $solicitudesCreadas["cliente_id"];
$proveedor = $solicitudesCreadas["proveedor_id"];
$concepto = $solicitudesCreadas["concepto"];
$montoTotal = "$ ".number_format($solicitudesCreadas["montoTotal"],2,".",",");
$iva = "$ ".number_format($solicitudesCreadas["iva"],2,".",",");
$tasa =  $solicitudesCreadas["tasa"];
$retenciones =  "$ ".number_format($solicitudesCreadas["retenciones"],2,".",",");

$tasaISR =  $solicitudesCreadas["tasaISR"];
$retencionesISR =  "$ ".number_format($solicitudesCreadas["retISR"],2,".",",");

$surtido = $solicitudesCreadas["surtido"];
$observaciones =  $solicitudesCreadas["observaciones"];
$fechaHoraSolicitud = $solicitudesCreadas["fecha"];
$subtotal = "$ ".number_format($solicitudesCreadas["subtotal"],2,".",",");
$productos = json_decode($solicitudesCreadas["items"], true);
$autorizado = $solicitudesCreadas["autorizado"];
			
$ruta = Rutas::ctrRuta();
//LLAMADO DE LAS EMPRESA
$itemEmpesa ="idEmpresa";
$valorEmpresa = $empresa;
$empresas = ControladorEmpresas::ctrMostrarEmpresas($itemEmpesa, $valorEmpresa);

$empresasCliente = ControladorEmpresas::ctrMostrarEmpresas($itemEmpesa, $cliente);


$nombreEmpresa = $empresas["nombre"];
$logoEmpresa = $empresas["logotipo"];
$empresasCliente = $empresasCliente["nombre"];

if($empresas["logotipo"]){

	$logoEmpresa = $empresas["logotipo"];

}else{

	$logoEmpresa = "vistas/img/empresas/default/no-disponible.png";

}

$status = "";

if($autorizado == "0"){

	$status = "enviado para ser autorizada"; 

}else if($autorizado == "1"){

	$status = "solicitud autorizada"; 

}else if($autorizado == "2"){

	$status = "solicitud no autorizada"; 

}else{

	$status = "solicitud en proceso"; 
}



//LLAMADO DEL PROVEEDOR 
$itemProveedor ="idProveedor";
$valorProveedor = $proveedor;
$proveedores = ControladorProveedores::ctrMostrarProveedores($itemProveedor, $valorProveedor);
// var_dump($proveedores);
$nombreProveedor = $proveedores["nombre"];


require_once "tcpdf_include.php";


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->startPageGroup();

$pdf->AddPage();

$logo = $ruta.$logoEmpresa;

$bloque1 = <<<EOF

<table>
	<tr>
		<td style="width:120px">

			<img src="$logo">

		</td>

		<td style="width:420px; background-color:white; "> 

			<div style="font-size:10px;font-family:Century Gothic,Arial; text-align:center; line-height:12px">
			
			<br>
			
				<b>SOLICITUD DE PAGO $nombreEmpresa</b>
			
			<br>
			
				$fechaActual
			
			<br>Solicitud: $orden

		</div>
	</td>

</tr>


	

</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');


// $pdf->Image('images/marca2.png', 50, 50, 100, 100);

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = K_PATH_IMAGES.'marca4.png';
$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();


$bloque2 = <<<EOF

	<table style="font-size:8px; padding:5px 5px;margin:0 auto;">

		<tr>

			<td style="width:800px"><img src="images/line.png"></td>

		</tr>


	<tr>

		<td style="width:50px;"></td>
		<td style="width:100px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Solicitud:</td>	
		<td style="width:150px;border:1px solid #d3d3d3;text-align:center;font-size:8px;">$orden</td>
		<td style="width:230px;border:1px solid #d3d3d3;text-align:center;font-size:8px;"><b>Fecha solicitud:</b> $fechaHoraSolicitud</td>
	
	</tr>

	<tr>

		<td style="width:50px;"></td>
		<td style="width:100px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Proveedor:</td>	
		<td style="width:380px;border:1px solid #d3d3d3;text-align:center;font-size:8px;">$nombreProveedor</td>
	
	</tr>

	<tr>

		<td style="width:50px;"></td>
		<td style="width:100px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Unidad Negocio:</td>
		<td style="width:150px;border:1px solid #d3d3d3;text-align:center;font-size:8px;">$nombreEmpresa</td>
		<td style="width:230px;border:1px solid #d3d3d3;text-align:center;font-size:8px;"><b>Empresa Cliente:</b> $empresasCliente</td>	
		
	
	</tr>

	<tr>

		<td style="width:50px;"></td>
		<td style="width:100px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Solicitante:</td>	
		<td style="width:380px;border:1px solid #d3d3d3;text-align:center;font-size:8px;">$sesionName </td>
	
	</tr>
		   

	</table>


EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

$bloque3 = <<<EOF

	<table style="font-size:8px; padding:5px 5px;margin:0 auto;">

	<tr>

		<td style="width:800px"><img src="images/line.png"></td>

	</tr>

	<tr>

		<td style="width:200px;border:1px solid #d3d3d3;background-color:#efefef;text-align:left;font-size:8px;">Concepto</td>
		<td style="width:85px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Cant.</td>
		<td style="width:85px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Unidad</td>	
		
		<td style="width:85px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">P. Unitario</td>
		<td style="width:85px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Subtotal</td>

	</tr>


	</table>


EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');


// ---------------------------------------------------------

foreach ($productos as $key => $item) {

$partida = ($key+1);

$itemMedida = "idMedida";
$valorMedida = $item["unidadMedida"];


$subtotalFormated = "$ ".number_format($item["subtotal"],2,".",",");
$pUnitarioFormated = "$ ".number_format($item["unitario"],2,".",",");

$medidas = ControladorUnidadMedidas::ctrMostrarUnidadMedidas($itemMedida, $valorMedida);

$unidadMedida = $medidas["clave"];



$bloque4 = <<<EOF

	<table style="font-size:8px; padding:5px 5px;margin:0 auto;">

		<tr>

		<td style="width:200px;border:1px solid #d3d3d3;background-color:white;text-align:left;font-size:8px;">$partida.- $item[descripcion]</td>
		<td style="width:85px;border:1px solid #d3d3d3;background-color:white;text-align:center;font-size:8px;">$item[cantidad]</td>
		<td style="width:85px;border:1px solid #d3d3d3;background-color:white;text-align:center;font-size:8px;">$unidadMedida</td>
		<td style="width:85px;border:1px solid #d3d3d3;background-color:white;text-align:center;font-size:8px;">$pUnitarioFormated</td>
		<td style="width:85px;border:1px solid #d3d3d3;background-color:white;text-align:right;font-size:8px;">$subtotalFormated</td>

		</tr>

	</table>



EOF;


$pdf->writeHTML($bloque4, false, false, false, false, '');

}


if($solicitudesCreadas["iva"] >= 0.1 && $solicitudesCreadas["tasa"] >= 1 && $solicitudesCreadas["tasaISR"] >= 1){

	$bloque5 = <<<EOF

	<table style="font-size:8px; padding:5px 5px;margin:0 auto;">

	<tr>

		<td style="width:800px"><img src="images/line.png"></td>

	</tr>

	<tr>
		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;text-align:center;font-size:8px;background-color:#efefef;">Subtotales</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$subtotal</td>
	
	</tr>

	<tr>
		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">IVA 16%</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$iva</td>

	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Ret. de IVA $tasa%</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$retenciones</td>	
		
	
	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Ret. de ISR $tasaISR%</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$retencionesISR</td>	
		
	
	</tr>
		

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Total Neto:</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$montoTotal</td>	
		
	
	</tr>



	</table>


EOF;

}else if($solicitudesCreadas["iva"] >= 0.1 && $solicitudesCreadas["tasa"] >= 1){


$bloque5 = <<<EOF

	<table style="font-size:8px; padding:5px 5px;margin:0 auto;">

	<tr>

		<td style="width:800px"><img src="images/line.png"></td>

	</tr>

	<tr>
		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;text-align:center;font-size:8px;background-color:#efefef;">Subtotales</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$subtotal</td>
	
	</tr>


	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;"> IVA 16 %</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$iva</td>	
		
	
	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Ret de IVA $tasa %</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$retenciones</td>	
		
	
	</tr>


	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Total Neto:</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$montoTotal</td>	
		
	
	</tr>



	</table>


EOF;


}else if($solicitudesCreadas["iva"] >= 0.1 && $solicitudesCreadas["tasaISR"] >= 1){

	$bloque5 = <<<EOF

	<table style="font-size:8px; padding:5px 5px;margin:0 auto;">

	<tr>

		<td style="width:800px"><img src="images/line.png"></td>

	</tr>

	<tr>
		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;text-align:center;font-size:8px;background-color:#efefef;">Subtotales</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$subtotal</td>
	
	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">IVA 16%</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$iva</td>	
		
	
	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Ret de ISR $tasaISR %</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$retencionesISR</td>	
		
	
	</tr>



	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Total Neto:</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$montoTotal</td>	
		
	
	</tr>



	</table>


EOF;



}else if($solicitudesCreadas["iva"] == 0 && $solicitudesCreadas["tasa"] >= 1 && $solicitudesCreadas["tasaISR"] >= 1){

$bloque5 = <<<EOF

	<table style="font-size:8px; padding:5px 5px;margin:0 auto;">

	<tr>

		<td style="width:800px"><img src="images/line.png"></td>

	</tr>

	<tr>
		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;text-align:center;font-size:8px;background-color:#efefef;">Subtotales</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$subtotal</td>
	
	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Ret de IVA $tasa %</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$retenciones</td>	
		
	
	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Ret de IVA $tasaISR %</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$retencionesISR</td>	
		
	
	</tr>



	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Total Neto:</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$montoTotal</td>	
		
	
	</tr>



	</table>

EOF;



}else if($solicitudesCreadas["iva"] == 0 && $solicitudesCreadas["tasa"] >= 1){


$bloque5 = <<<EOF

	<table style="font-size:8px; padding:5px 5px;margin:0 auto;">

	<tr>

		<td style="width:800px"><img src="images/line.png"></td>

	</tr>

	<tr>
		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;text-align:center;font-size:8px;background-color:#efefef;">Subtotales</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$subtotal</td>
	
	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Ret de IVA $tasa %</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$retenciones</td>	
		
	
	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Total Neto:</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$montoTotal</td>	
		
	
	</tr>



	</table>

EOF;



}else if($solicitudesCreadas["iva"] == 0 && $solicitudesCreadas["tasaISR"] >= 1){



$bloque5 = <<<EOF

	<table style="font-size:8px; padding:5px 5px;margin:0 auto;">

	<tr>

		<td style="width:800px"><img src="images/line.png"></td>

	</tr>

	<tr>
		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;text-align:center;font-size:8px;background-color:#efefef;">Subtotales</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$subtotal</td>
	
	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Ret de ISR $tasaISR %</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$retencionesISR</td>	
		
	
	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Total Neto:</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$montoTotal</td>	
		
	
	</tr>



	</table>

EOF;




}else if($solicitudesCreadas["iva"] >= 0.1){

$bloque5 = <<<EOF

	<table style="font-size:8px; padding:5px 5px;margin:0 auto;">

	<tr>

		<td style="width:800px"><img src="images/line.png"></td>

	</tr>

	<tr>
		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;text-align:center;font-size:8px;background-color:#efefef;">Subtotales</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$subtotal</td>
	
	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;"> IVA 16 %</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$iva</td>	
		
	
	</tr>

	<tr>

		<td style="width:365px;text-align:left;font-size:8px;"></td>
		<td style="width:90px;border:1px solid #d3d3d3;background-color:#efefef;text-align:center;font-size:8px;">Total Neto:</td>
		<td style="width:85px;border:1px solid #d3d3d3;text-align:right;font-size:8px;">$montoTotal</td>	
		
	
	</tr>



	</table>

EOF;


}




$pdf->writeHTML($bloque5, false, false, false, false, '');


$bloque6 = <<<EOF

	<table style="font-size:8px; padding:5px 5px;margin:0 auto;">

	<tr>

		<td></td>

	</tr>

	<tr>

	   <td style="width:540px;border:1px solid #d3d3d3;background-color:#efefef;text-align:left;font-size:8px;">Observaciones / Estado: $status </td>

	</tr>

	<tr>
		<td style="width:540px;border:1px solid #d3d3d3;text-align:left;font-size:8px;">$observaciones</td>
	</tr>




	</table>


EOF;


$pdf->writeHTML($bloque6, false, false, false, false, '');


ob_end_clean();


$pdf->Output('Solicitud-'.$nombreEmpresa."-".date('Ymd H:i:s').'.pdf','I');


	}
}



// if(isset($_GET["sol"])){

	$printSol = new imprimirSolicitud();
	$printSol ->  sol = $_GET["sol"];
	$printSol -> traerSolicitud();
	

	
// }




 ?>