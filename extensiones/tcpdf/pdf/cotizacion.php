<?php 

ob_start();
require_once "../../../controladores/cotizacion.controlador.php";
require_once "../../../modelos/cotizacion.modelo.php";
require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";
require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";
require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

require_once "tcpdf_include.php";

date_default_timezone_set('America/Mexico_City');

class imprimirCotizacion{

	public $codigo;

	public function traerImpresionCotizacion(){

		$itemCotizacion = "codigo";
		$valorCotizacion = $this->codigo;
		$respuestaCotizacion = ControladorCotizacion::ctrMostrarCotizaciones($itemCotizacion, $valorCotizacion);
		$fecha = substr($respuestaCotizacion["fecha"], 0, -8);
		$telefono = $respuestaCotizacion["id_cliente"];
		$nombreCotizador = $respuestaCotizacion["nombreCliente"];
		$email = $respuestaCotizacion["emailCliente"];
		$productos = json_decode($respuestaCotizacion["productos"], true);
		$neto = number_format($respuestaCotizacion["neto"],2);
		$impuesto = number_format($respuestaCotizacion["impuesto"],2);
		$total = number_format($respuestaCotizacion["total"],2);
		$observaciones = $respuestaCotizacion["observaciones"];

	//TRAEMOS LA INFORMACION DEL CLIENTE
	$itemCliente = "id";
	$valorCliente = $respuestaCotizacion["id_cliente"];
	$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);


	//TRAEMOS LA INFORMACION DEL CLIENTE
	$itemVendedor = "id";
	$valorVendedor = $respuestaCotizacion["id_vendedor"];
	$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);




$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

/*==========================================================================================
=           PRIMER BLOQUE DEL PDF                                                          =
===========================================================================================*/
$bloque1 = <<<EOF
	<table>
		<tr>
			<td style="color:#FF0404;background-color:white;width:540px;text-align:center;font-size:8px;">Vigencia cotización 5 días hábiles, precio sujeto a cambio sin previo aviso.</td>
		</tr>
		<tr>
			<td style="width:150px"><img src="images/logo-negro-bloque.png"></td>
			<td style="background-color:white; width:140px">
			
				<div style="font-size:8.5px; text-align:center;line-height:15px;">
					<br>
					RFC: MARE860629FX1
					<br>
					Dirección: Calle 44B 92-11
				</div>
			</td> 
			<td style="background-color:white;width:140px">
				<div style="font-size:8.5px;text-align:center;line-height:15px">
					<br>
					Teléfono: 55-6886-1175
					<br>
					info@e2system-coding.com.mx
				</div>
			</td>
			<td style="background-color:white; width:110px;text-align:center;color:red"><br><br>Cotización N. <br>$valorCotizacion
				
			</td>
		</tr>
	</table> 
EOF;
$pdf->writeHTML($bloque1, false, false, false, false, '');
/*==========================================================================================
=           SEGUNDO BLOQUE DEL PDF                                                          =
===========================================================================================*/
$bloque2 = <<<EOF
	<table>
		<tr>
			<td style="width:540px"><img src="images/back.jpg"></td>
		</tr>
	</table>
	<table style="font-size:10px; padding:5px 10px;">
		
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:320px;">
				Teléfono : $telefono
			</td>
			<td style="border: 1px solid #666; background-color:white; width:220px;text-align:right;">
				Fecha : $fecha
			</td>
		</tr>
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:320px;">
				Cliente : $nombreCotizador. Email: $email
			</td>
			<td style="border: 1px solid #666; background-color:white; width:220px;text-align:right;">
				Vendedor : $respuestaVendedor[nombre]
			</td>
		</tr>
		
		
		<tr>
			<td style="border-bottom: 1px solid #666; background-color:white;width:540px;text-align:center;font-size:8px;"></td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');
/*==========================================================================================
=           TERCER BLOQUE DEL PDF                                                          =
===========================================================================================*/
$bloque3 = <<<EOF
	<table style="font-size:10px; padding:5px 10px;">
		
		<tr>
			<td style="border:1px solid #666; background-color:#efefef; width:60px; text-align:center;font-weight:bold;font-size:8px;">Cant.</td>
			<td style="border:1px solid #666; background-color:#efefef; width:60px; text-align:center;font-weight:bold;font-size:8px;">Unidad</td>
			<td style="border:1px solid #666; background-color:#efefef; width:180px; text-align:center;font-weight:bold;font-size:8px;">Descripción</td>
			<td style="border:1px solid #666; background-color:#efefef; width:100px; text-align:center;font-weight:bold;font-size:8px;">Observaciones</td>
			<td style="border:1px solid #666; background-color:#efefef; width:70px; text-align:center;font-weight:bold;font-size:8px;">P. Unitario</td>
			<td style="border:1px solid #666; background-color:#efefef; width:70px; text-align:center;font-weight:bold;font-size:8px;">Valor Total</td>
		
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque3, false, false, false, false, '');
/*==========================================================================================
=           	CUARTO BLOQUE DEL PDF                                                          =
===========================================================================================*/
foreach ($productos as $key => $value) {
// $itemProducto = "descripcion";
// $valorProducto = $item["descripcion"];
// $orden = null;
// $respuestaProducto = ControladorProductos::ctrMostrarProductos()
	$precioUnitario = number_format($value["precio"], 2);
	$precioTotal = number_format($value["total"], 2);
$bloque4 = <<<EOF
<table style="font-size:10px;padding:5px 10px;">
	
	<tr>
		<td style="border:1px solid #666; color:#333; background-color:white; width:60px;text-align:center;font-size:8px;">
          $value[cantidad]
		</td>
		<td style="border:1px solid #666; color:#333; background-color:white; width:60px;text-align:center;font-size:8px;">
          $value[unidad]
		</td>
		<td style="border:1px solid #666; color:#333; background-color:white; width:180px;text-align:center;font-size:8px;">
          $value[descripcion]
		</td>
		<td style="border:1px solid #666; color:#333; background-color:white; width:100px;text-align:center;font-size:8px;">
          $value[entrega]
		</td>
		
		<td style="border:1px solid #666; color:#333; background-color:white; width:70px;text-align:center;font-size:8px;">
         $ $precioUnitario
		</td>
		<td style="border:1px solid #666; color:#333; background-color:white; width:70px;text-align:center;font-size:8px;">
         $ $precioTotal
		</td>
	</tr>
</table>
	
EOF;
$pdf->writeHTML($bloque4, false, false, false, false, '');
}
/*==========================================================================================
=           	QUINTO BLOQUE DEL PDF                                                          =
===========================================================================================*/
$bloque5 = <<<EOF
	
	<table style="font-size:10px;padding:5px 10px;">
		<tr>
			<td style="background-color:white;width:400px;">Observaciones:</td>
			<td style="border-bottom: 1px solid #666; background-color:white;width:70px;"></td>
			<td style="border-bottom: 1px solid #666; background-color:white;width:70px;"></td>
		</tr>
		<tr>
			<td rowspan="3" style="border:1px solid #666; color:#333;background-color:white;width:380px;text-align:center">$observaciones</td>
			<td style="border-right:1px solid #666; background-color:white;width:20px;text-align:center;font-weight:bold;font-size:8px;"></td>
			<td style="border:1px solid #666; background-color:white;width:70px;text-align:center;font-weight:bold;font-size:8px;">
				Neto:
			</td>
			<td style="border:1px solid #666; background-color:white;width:70px;text-align:center;font-size:8px;">
				$ $neto
			</td>
		</tr>
		<tr>
			<td style="border-right:1px solid #666; background-color:white;width:20px;text-align:center;font-weight:bold;font-size:8px;"></td>
			<td style="border:1px solid #666; background-color:white;width:70px;text-align:center;font-weight:bold;;font-size:8px;">
				Impuesto:
			</td>
			<td style="border:1px solid #666; background-color:white;width:70px;text-align:center;font-size:8px;">
				$ $impuesto
			</td>
		</tr>
		<tr>
			<td style="border-right:1px solid #666; background-color:white;width:20px;text-align:center;font-weight:bold;font-size:8px;"></td>
			<td style="border:1px solid #666; background-color:white;width:70px;text-align:center;font-weight:bold;font-size:8px;">
				Total:
			</td>
			<td style="border:1px solid #666; background-color:white;width:70px;text-align:center;font-weight:bold;color:red;font-size:8px;">
				$ $total
			</td>
		</tr>
		
	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

ob_end_clean();

//SALIDA DEL ARCHIVO
$pdf->Output('Cotizacion-'.date('Ymd H:i:s').'.pdf');

	
	}
}


$cotizacion = new imprimirCotizacion();
$cotizacion -> codigo = $_GET["codigo"];
$cotizacion -> traerImpresionCotizacion();


 ?>