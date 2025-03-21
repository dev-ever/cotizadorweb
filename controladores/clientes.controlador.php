<?php


class ControladorClientes{


	static public function ctrMostrarClientes($item, $valor){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla,$item,$valor);

		return $respuesta;
	}





/*=============================================
	MOSTRAR TOTAL USUARIOS
=============================================*/

	static public function ctrContarClientes(){

		$tabla = "clientes";

		$respuesta = ModeloClientes::MdlContarClientes($tabla);

		return $respuesta;
	}




}





?>