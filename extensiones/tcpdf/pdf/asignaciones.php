<?php 
ob_start();
require_once "../../../controladores/asignacion.controlador.php";
require_once "../../../modelos/asignacion.modelo.php";
require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";
require_once "../../../controladores/mobiliario.controlador.php";
require_once "../../../modelos/mobiliario.modelo.php";
require_once "../../../controladores/ubicaciones.controlador.php";
require_once "../../../modelos/ubicaciones.modelo.php";
require_once "../../../controladores/areas.controlador.php";
require_once "../../../modelos/areas.modelo.php";
require_once "../../../controladores/categorias.controlador.php";
require_once "../../../modelos/categorias.modelo.php";
require_once "../../../controladores/unidades.controlador.php";
require_once "../../../modelos/unidades.modelo.php";



class imprimirSolicitud{

	public $cod;

	public function traerSolicitud(){

		setlocale(LC_TIME, 'es_ES.UTF-8');
		date_default_timezone_set("America/Mexico_City");

		$fechaCorta = date("d-m-Y H:i:s");
		$fechaActual = (strftime("%A %d de %B del %Y"));

		//LLAMADO DEL LA ASIGNACION
		$itemFolio = "folio";
		$valorFolio = $_GET["cod"];
		$orden = "DESC";

		$respuestaAsignacion = ControladorAsignaciones::ctrMostrarAsignaciones($itemFolio, $valorFolio, $orden);

		// var_dump($respuestaAsignacion);

		$observaciones = $respuestaAsignacion["observaciones"];
		$fechaAsignacion = $respuestaAsignacion["created_at"];

		$mobiliarios = json_decode($respuestaAsignacion["item"], true);
		var_dump($mobiliarios);


		//LLAMADO DEL USUARIO DEL SISTEMA
		$itemUsuario = "id";
		$valorUsuario = $respuestaAsignacion["usuario_id"];
		$respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
		$nombreUsuario = $respuestaUsuario["nombre"];
		
		//LLAMADO DE LA UBICACION DEL SISTEMA
		$itemUbicacion = "idUbicacion";
		$valorUbicacion = $respuestaAsignacion["ubicacion"];
		$respuestaUbicacion = ControladorUbicaciones::ctrMostrarUbicaciones($itemUbicacion, $valorUbicacion);
		$nombreUbicacion = $respuestaUbicacion["ubicacion"];

		//LLAMADO DE LA UBICACION DEL SISTEMA
		$itemArea = "idArea";
		$valorArea = $respuestaAsignacion["area"];
		$respuestaAreas = ControladorAreas::ctrMostrarAreas($itemArea, $valorArea);
		$nombreArea = $respuestaAreas["area"];


		//LLAMADO DE LA UNIDAD DEL SISTEMA
		$itemUnidad = "idUnidad";
		$valorUnidad = $respuestaAsignacion["unidad_id"];
		$respuestaUnidades = ControladorUnidades::ctrMostrarUnidades($itemUnidad, $valorUnidad);
		$nombreUnidad = $respuestaUnidades["unidad"];

		//LLAMADO DE LA UBICACION DEL SISTEMA
		$itemCategoria = "idCategoria";
		$valorCategoria = $respuestaAsignacion["categoria_id"];
		$respuestaCategorias = ControladorCategorias::ctrMostrarCategorias($itemCategoria, $valorCategoria);
		$nombreCategoria = $respuestaCategorias["categoria"];





	}
}



if(isset($_GET["cod"])){

	$printSol = new imprimirSolicitud();
	$printSol ->  cod = $_GET["cod"];
	$printSol -> traerSolicitud();
	
	
}


?>
