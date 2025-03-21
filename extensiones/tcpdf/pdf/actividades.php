<?php 
require_once "../../../controladores/bitacora.controlador.php";
require_once "../../../modelos/bitacoras.modelo.php";
require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";
require_once "../../../controladores/prospecto.controlador.php";
require_once "../../../modelos/prospectos.modelo.php";


class imprimirActividad{
    
	public $codigo;

	public function traerImpresionActividades(){

/*=============================================
 TRAEMOS LA INFORMACION DE LA VENTA
 =============================================*/
 	date_default_timezone_set('America/Mexico_City');

	$fecha = date("d / m / Y");
	$item = "idProspecto";
	$valor = $this->codigo;

	$respuestaActividades = ControladorBitacora::ctrMostrarBitacorasVendedor($item, $valor);

	foreach ($respuestaActividades as $key => $actividadesBitacoras) {
		

	

/*=============================================
 TRAEMOS LA INFORMACION DEL VENDEDOR
 =============================================*/
$itemVendedor = "id";
$valorVendedor = $actividadesBitacoras["idUsuario"];	

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuariosAjax($itemVendedor, $valorVendedor);

$vendedor = $respuestaVendedor["nombre"];
$perfil = $respuestaVendedor["perfil"];


/*=============================================
 TRAEMOS LA INFORMACION DEL PROSPECTO
 =============================================*/

 $itemProspecto = "id";
 $valorProspecto = $actividadesBitacoras["idProspecto"];


 $respuestaProspecto = ControladorProspecto::ctrMostrarProspectos($itemProspecto, $valorProspecto);

 $razonSocial = $respuestaProspecto["razonSocial"];
 $comercial = $respuestaProspecto["nombreComercial"];
 $rfc = $respuestaProspecto["rfc"];
 $direccionFiscal = $respuestaProspecto["direccionFiscal"];
 $direccionComercial = $respuestaProspecto["direccionComercial"];
 $paginaweb = $respuestaProspecto["pagina"];  
 $tel1 = $respuestaProspecto["telOficina"];
 $tel2 = $respuestaProspecto["telDirecto"];
 $tel3 = $respuestaProspecto["telMovil"];
 $contacto = $respuestaProspecto["nombreContacto"];
 $emailContacto = $respuestaProspecto["emailContacto"];
 $logo = $respuestaProspecto["logo"];

}



require_once('tcpdf_include.php');


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

// 540px hoja     150 140 140 110
$bloque1 = <<<EOF
	
	<table>

		<tr>
			<td style="width:150px"><br><img src="images/logotipo-colores.png"></td>
		
			<td style="width:390px; background-color:white; "> 
				
				<div style="font-size:10px;font-family:Century Gothic,Arial; text-align:center; line-height:12px">
					<br>
					SISTEMA DE PROSPECCION DE CLIENTES
					<br>
					Grupo Empresarial Riovalle S.A. de C.V.
					<br>
					Carretera Tepotzotlán - La Aurora, km 1 OCPL 3, Cuautitlan Izcalli, Méx.
				</div>
			</td>

		</tr>

		

	</table>

EOF;


$pdf->writeHTML($bloque1, false, false, false, false, '');

/*!--=====================================
=            BLOQUE 2            =
======================================--*/

$bloque2 = <<<EOF
	
	<table>

		<tr>
	
			<td style="width:540px"><img src="images/back.jpg"></td>
	
		</tr>
	
	</table> 

	<table style="font-size:8px; padding:3px 8px;"> 

		<tr>
			<td style="border: 1px solid #666;font-size:15px; width:390px; text-align:center;background-color:#efefef">
				<br><br>
				<b>FICHA TECNICA</b>

			</td>


			<td style="border:1px solid #666; width:150px; text-align:center">
				
				<img src="../../../$logo" width="150px" height="50px">
			</td> 
			
			

		</tr>


		<tr>
			<td style="border: 1px solid #666; background-color:white; width:390px">

				<b>Razón Social:</b> $razonSocial
			</td>
			
			<td style="border:1px solid #666; background-color:white; width:150px; text-align:left">
				<b>Fecha: </b> $fecha
			</td> 

		</tr>
		
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:390px">

				<b>Nombre Comercial:</b> $comercial

			</td>

				<td style="border:1px solid #666; background-color:white; width:150px; text-align:left">
				<b>RFC: </b> $rfc
			</td> 
		</tr>
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:390px">

				<b>Dirección Fiscal:</b> $direccionFiscal

			</td>

				<td style="border:1px solid #666; background-color:white; width:150px; text-align:left">
				<b>Sitio web: </b> $paginaweb
			</td> 
		</tr>

		<tr>
			<td style="border: 1px solid #666; background-color:white; width:390px">

				<b>Dirección Comercial:</b> $direccionComercial<br>
				<b>Teléfonos: </b> $tel1 / $tel2 / $tel3

			</td>

			<td style="border:1px solid #666; background-color:white; width:150px; text-align:left">
			
				<b>Contacto: </b> $contacto <br>
				<b>Email:</b> $emailContacto
			
			</td>

		</tr>


		<tr style="background-color:#efefef">
			
			<td style="border:1px solid #666; width:390px; text-align:left"> 
			
				<b>Vendedor a cargo:</b> $vendedor
			
			</td>

			<td style="border:1px solid #666; width:150px; text-align:left">
			
				<b> Perfil:</b> $perfil
			
			</td>


		</tr>

		<tr>
			<td style="border-bottom: 1px solid #666; background-color:white;width:540px"></td>
		</tr>

	</table>

	<table style="font-size:8px; paddin:5px 10px;">
		<tr>
			<td style="border: 1px solid #666; background-color:#efefef;font-weight:bold; width:30px; text-align:center"># No </td>
			<td style="border: 1px solid #666; background-color:#efefef; font-weight:bold; width:90px; text-align:center">Fecha Actividad </td>
			<td style="border: 1px solid #666; background-color:#efefef;font-weight:bold; width:90px; text-align:center">Actividad Realizada </td>
			<td style="border: 1px solid #666; background-color:#efefef;font-weight:bold;width:90px; text-align:center">Actividad a Realizar </td>
			<td style="border: 1px solid #666; background-color:#efefef;font-weight:bold;width:90px; text-align:center">Fecha Sig. Actividad </td>
			<td style="border: 1px solid #666; background-color:#efefef;font-weight:bold;width:150px; text-align:center">Status </td> 
		</tr>
	</table>	




EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');



foreach ($respuestaActividades as $key => $value) {

	$valorKey = $key + 1;

	$prioridadColor = array (
                      			'0'=> '#D6E651', 
                      			'1'=> '#56E2EF',
				                '2'=> '#239DF2',
				                '3'=> '#0AC820',
				                '4'=> '#65F44E',
				                '5'=> '#F82929',
				                '6'=> '#FD6F6F'
				                );

	$colores = $prioridadColor[$value["status"]];

	$status = $value["status"];

	if($status == "0"){

		$seguimiento = "Segumiento Iniciado";

	}else if($status == "1"){

		$seguimiento = "Actividad en Monitoreo";

	}else if($status == "2"){

		$seguimiento = "Actividad realizada en fecha y hora programada";

	}else if($status == "3"){

		$seguimiento = "Actividad en fecha y hora anticipada";
	
	}else if($status == "4"){

		$seguimiento = " Actividad realizada en hora programada anticipada";

	}else if($status == "5"){

		$seguimiento =  "Actividad no realizada en fecha y hora programada";

	}else if($tatus == "6"){

		$seguimiento = "Actividad no realizada en hora programada";
	}


$bloque3 = <<<EOF

	

		<table style="font-size:8px; paddin:5px 10px;">
		<tr style="background-color: $colores">
			<td style="border: 1px solid #666; width:30px; text-align:center">
		
				 $valorKey

			</td>

			<td style="border: 1px solid #666; width:90px; text-align:center">
			
				$value[fechaActividad]

			</td>

			<td style="border: 1px solid #666; width:90px; text-align:center">
			
				$value[actividadRealizada]
			
			</td>
			
			<td style="border: 1px solid #666; width:90px; text-align:center">
		
				$value[actividadARealizar]
			
			</td>
			
			<td style="border: 1px solid #666; width:90px; text-align:center">
			
				$value[fechaSigActividad]

			</td>
			
			<td style="border: 1px solid #666; width:150px; text-align:center">
				$seguimiento
			</td> 
		</tr>
	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');
ob_end_clean();
}






//SALIDA DEL ARCHIVO
$pdf->Output('actividades-'.date('Ymd H:i:s').'.pdf','D');
	

	}

}

$actividades = new imprimirActividad();
$actividades -> codigo = base64_decode($_GET["codigo"]);
$actividades -> traerImpresionActividades();

 ?>