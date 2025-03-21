<?php 

ob_start();
require_once "../../../controladores/ordenes.controlador.php";
require_once "../../../modelos/ordenes.modelo.php";
require_once "../../../controladores/empresa.controlador.php";
require_once "../../../modelos/empresas.modelo.php";

date_default_timezone_set('America/Mexico_City'); 

class imprimirReporteGeneral{

	public function traerReporte(){

		// date_default_timezone_set('Etc/GMT-6'); 
	 //    setlocale(LC_TIME, 'es_MX.UTF-8');

		date_default_timezone_set("America/Mexico_City"); 
		
		$fechaCorta = date("d-m-Y H:i:s");
		$fechaActual = utf8_encode(strftime("%A %d de %B del %Y"));


		$itemSaldoEstado = "statusSaldos";
		$valorProgramado = 1;
		$valorVigente = 2;
		$valorVencido = 3;
		$fase = "sProgramados";
		$fase1 = "sVigentes";
		$fase2 = "sVencidos";

		$respuestasProgramados = ControladorOrdenes::ctrMostrarOrdenesAcumulados($itemSaldoEstado, $valorProgramado, $fase);
		$respuestasVigentes = ControladorOrdenes::ctrMostrarOrdenesAcumulados($itemSaldoEstado, $valorVigente, $fase1);
		$respuestasVencidos = ControladorOrdenes::ctrMostrarOrdenesAcumulados($itemSaldoEstado, $valorVencido, $fase2);
		$totalSaldosAcumulados = $respuestasProgramados["x"] + $respuestasVigentes["x"] + $respuestasVencidos["x"];

		$programados = "$ ".number_format($respuestasProgramados["x"],2,".",",");
		$vigentes = "$ ".number_format($respuestasVigentes["x"],2,".",",");
		$vencidos = "$ ".number_format($respuestasVencidos["x"],2,".",",");
		$acumulado = "$ ".number_format($totalSaldosAcumulados,2,".",",");



		$tabla = "ordenCompra";
		$tabla2 = "empresas";


		$totalesProgramados = 0;
		$totalesVigentes = 0;
		$totalesVencidos = 0;
		$totalesVencidos30 = 0;
		$totalesVencidos60 = 0;
		$totalesVencidos90 = 0;
		$totalesVencidosMas90 = 0;

		$reporteGeneral = ModeloOrdenes::mdlDescargarReporteGeneral($tabla, $tabla2);




		require_once ('tcpdf_include.php');


		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setPrintHeader(false);
		$pdf->startPageGroup();
		$pdf->AddPage('L','A4');
		$pdf->SetMargins(10, 25, 10);

		$bloque1 = <<<EOF

		<table>

		  <tr>
		    
		 		
		 	 <td style="width:800px;">REPORTE GENERAL DE SALDOS</td>
		  </tr>

		   <tr>
		     <td style="width:800px;text-align:right;font-weight:normal;font-style: italic;font-size:8px;">Impreso: $fechaCorta</td>
		   </tr>
		   
		   <tr>
		      <td><img src="images/line.png"></td>
		   </tr>

		   <tr>
		   	   <td style="width:100px;"></td>
			   <td style="width:150px;border:1px solid #d3d3d3;background-color:#0FBE45;text-align:center;">$acumulado</td>	
			   <td style="width:150px;border:1px solid #d3d3d3;background-color:#43D2F1;text-align:center;">$programados</td>
			   <td style="width:150px;border:1px solid #d3d3d3;background-color:#0DA0FD;text-align:center;">$vigentes</td>
			   <td style="width:150px;border:1px solid #d3d3d3;background-color:#FF5454;text-align:center;">$vencidos</td>
		   </tr>
		   <tr>
		   	   <td style="width:100px;"></td>
			   <td style="width:150px;border:1px solid #d3d3d3;background-color:#0FBE45;text-align:center;font-size:10px;">Total General</td>	
			   <td style="width:150px;border:1px solid #d3d3d3;background-color:#43D2F1;text-align:center;font-size:10px;">Total Programados</td>
			   <td style="width:150px;border:1px solid #d3d3d3;background-color:#0DA0FD;text-align:center;font-size:10px;">Total Vigentes</td>
			   <td style="width:150px;border:1px solid #d3d3d3;background-color:#FF5454;text-align:center;font-size:10px;">Total Vencidos</td>
		   </tr>
		   
		</table>

EOF;

	$pdf->writeHTML($bloque1, false, false, false, false, '');


	$bloque2 = <<<EOF

	<table style="font-size:8px; padding:5px 5px;margin:0 auto;">

		<tr>

		<td style="width:800px"><img src="images/line.png"></td>

		</tr>

		
		<tr>
			<td style="width:30px;background-color:#efefef;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;vertical-align: middle;">#</td>
			<td style="width:92px;background-color:#efefef;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">Director</td>
			<td style="width:92px;background-color:#efefef;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">Empresa</td>
			<td style="width:72px;background-color:#efefef;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">Total Programados</td>
			<td style="width:72px;background-color:#efefef;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">Total Vigentes</td>
			<td style="width:72px;background-color:#efefef;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">Total Vencidos</td>
			<td style="width:72px;background-color:#efefef;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">Vencidos de 1 - 30 días</td>
			<td style="width:72px;background-color:#efefef;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">Vencidos de 31 - 60 días</td>
			<td style="width:72px;background-color:#efefef;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">Vencidos de 61 - 90 días</td>
			<td style="width:72px;background-color:#efefef;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">Vencidos a + 90 días días</td>
			<td style="width:72px;background-color:#efefef;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">Total por empresa</td>

		</tr>

	</table>

EOF;

	$pdf->writeHTML($bloque2, false, false, false, false, '');

	foreach ($reporteGeneral as $key => $value) {

		$id = $key+1;
		$totalesProgramados += $value["Programadosx"];
		$totalesVigentes += $value["Vigentesx"];
		$totalesVencidos += $value["Vencidosx"];
		$totalesVencidos30 += $value["importe_0_30_dias"];
		$totalesVencidos60 += $value["importe_31_60_dias"];
		$totalesVencidos90 += $value["importe_61_90_dias"];
		$totalesVencidosMas90 += $value["importe_mas_de_90_dias"];

		$tProgramados = "$ ".number_format($value["Programadosx"],2,".",",");
		$tVigentes = "$ ".number_format($value["Vigentesx"],2,".",",");
		$tVencidos = "$ ".number_format($value["Vencidosx"],2,".",",");
		$tVencidos30 = "$ ".number_format($value["importe_0_30_dias"],2,".",",");
		$tVencidos60 = "$ ".number_format($value["importe_31_60_dias"],2,".",",");
		$tVencidos90 = "$ ".number_format($value["importe_61_90_dias"],2,".",",");
		$tVencidosMas90 = "$ ".number_format($value["importe_mas_de_90_dias"],2,".",",");



		//FORMATO A MONEDA
		$totalesProgramados2 = "$ ".number_format($totalesProgramados,2,".",",");
		$totalesVigentes2 =  "$ ".number_format($totalesVigentes,2,".",",");
		$totalesVencidos2 =  "$ ".number_format($totalesVencidos,2,".",",");
		$totalesVencidos302 =  "$ ".number_format($totalesVencidos30,2,".",",");
		$totalesVencidos602 =  "$ ".number_format($totalesVencidos60,2,".",",");
		$totalesVencidos902 =  "$ ".number_format($totalesVencidos90,2,".",",");
		$totalesVencidosMas902 =  "$ ".number_format($totalesVencidosMas90,2,".",",");




		//TOTALES POR EMPRESA
		$tEmpresa = "$ ".number_format($value["Programadosx"] + $value["Vigentesx"] + $value["Vencidosx"], 2,".",",");

		$totalEmpresas += $value["Programadosx"] + $value["Vigentesx"] + $value["Vencidosx"];
		$totalEmpresas2 = "$".number_format($totalEmpresas,2,".",",");

	$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 5px;">

		<tr>

		  <td style="width:30px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">$id</td>
		  <td style="width:92px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">$value[responsable]</td>
		  <td style="width:92px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">$value[nombre]</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">$tProgramados</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">$tVigentes</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">$tVencidos</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">$tVencidos30</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">$tVencidos60</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">$tVencidos90</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">$tVencidosMas90</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;">$tEmpresa</td>

		</tr>

	</table>

EOF;

	$pdf->writeHTML($bloque3, false, false, false, false, '');

	
	

	}


	$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 5px;">

		<tr>

		  <td style="width:30px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;background-color:#efefef;"></td>
		  <td style="width:92px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;background-color:#efefef;"></td>
		  <td style="width:92px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;background-color:#efefef;">TOTALES:</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;background-color:#efefef;">$totalesProgramados2</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;background-color:#efefef;">$totalesVigentes2</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;background-color:#efefef;">$totalesVencidos2</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;background-color:#efefef;">$totalesVencidos302</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;background-color:#efefef;">$totalesVencidos602</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;background-color:#efefef;">$totalesVencidos902</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;background-color:#efefef;">$totalesVencidosMas902</td>
		  <td style="width:72px;border: 1px solid #666;text-align:center;font-size:8px;font-weight:bold;background-color:#efefef;">$totalEmpresas2</td>

		</tr>

	</table>

EOF;

	$pdf->writeHTML($bloque3, false, false, false, false, '');








		ob_end_clean();

		$pdf->Output('reporteGral-'.date('Ymd-His').'.pdf','I');

	}


}



$reporteGral = new imprimirReporteGeneral();
$reporteGral -> traerReporte();
	
	




?>