<?php
require_once "conexion.php";



class ModeloCotizacion{

	static public function mdlMostrarCotizaciones($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt ->fetchAll();

		}

	}





	static public function mdlIngresarCotizacion($tabla, $datos){



		$stmt =  Conexion::conectar()->prepare("INSERT INTO $tabla(codigo,id_cliente,nombreCliente,id_vendedor,emailCliente,productos,impuesto,neto,total,observaciones) VALUES (:codigo, :id_cliente, :nombreCliente, :id_vendedor, :emailCliente, :productos, :impuesto, :neto, :total,:observaciones)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":nombreCliente", $datos["nombreCliente"],PDO::PARAM_STR);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":emailCliente", $datos["emailCliente"],PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos["productos"],PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"],PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"],PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"],PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"],PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}


		$stmt->close();

		$stmt = null;


	}







/*=============================================

=            EDITAR COTIZACION          =

=============================================*/



	static public function mdlEditarCotizacion($tabla, $datos){

		$stmt =  Conexion::conectar()->prepare("UPDATE $tabla SET id_cliente = :id_cliente, nombreCliente = :nombreCliente, id_vendedor = :id_vendedor, emailCliente = :emailCliente, productos = :productos, impuesto = :impuesto, neto = :neto, total = :total, observaciones = :observaciones WHERE codigo = :codigo");
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":nombreCliente", $datos["nombreCliente"],PDO::PARAM_STR);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":emailCliente", $datos["emailCliente"],PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos["productos"],PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"],PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"],PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"],PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"],PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;

	}





	static public function mdlUltimoCodigo($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		if($stmt -> execute()){

			return $stmt->rowCount();

		}else{

			return "error";
		}


		$stmt ->close();
		$stmt = null;


	}



	/*--=====================================
	=            CONTAR TOTAL DE USUARIOS            =
	======================================--*/
	static public function MdlContarCotizacion($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT count(codigo) as totalCotizacion FROM cotizador");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt->close();

		$stmt->null;

	}






}





?>