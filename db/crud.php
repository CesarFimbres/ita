<?php
include_once 'conn.php';
$obj = new Connection();
$conexion = $obj->Conectar();

$_POST = json_decode(file_get_contents("php://input"), true);
$option = (isset($_POST['option'])) ? $_POST['option'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$producto = (isset($_POST['producto'])) ? $_POST['producto'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$ean = (isset($_POST['ean'])) ? $_POST['ean'] : '';
$busca = (isset($_POST['busca'])) ? $_POST['busca'] : '';
 
 

switch ($option) {
	case "listar":
		$consulta = "SELECT id, producto, nombre, ean, desCorta, descLarga, imgCorta 
						FROM producto 
						WHERE nombre = '1SDA067397R1' 
						ORDER BY id ASC LIMIT 3";
		$resultado = $conexion->prepare($consulta);
		$resultado->execute();
		$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
		break;
	case "buscar":
		$consulta = " SELECT * FROM producto 
						WHERE producto LIKE '%$busca%' 
 						OR desCorta LIKE '%$busca%'						
 						OR descLarga LIKE '%$busca%'						
						OR nombre LIKE '%$busca%' 
						OR ean LIKE '%$busca%' 
						ORDER BY id DESC ";
		$resultado = $conexion->prepare($consulta);
		$resultado->execute();
		$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
		break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
