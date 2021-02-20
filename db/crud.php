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
$idTablero = (isset($_POST['idTablero'])) ? $_POST['idTablero'] : '';
$dataForm = (isset($_POST['data'])) ? $_POST['data'] :  false;
//$data = json_decode($dataForm);


switch ($option) {
	case "listar":
		$consulta = "SELECT id, producto, nombre, ean, desCorta, imgCorta FROM producto ORDER BY id DESC LIMIT 7";
		$resultado = $conexion->prepare($consulta);
		$resultado->execute();
		$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
		break;
	case "buscar":
		$consulta = " SELECT * FROM producto WHERE producto LIKE '%$busca%' OR nombre LIKE '%$busca%' OR ean LIKE '%$busca%' ORDER BY id DESC ";
		$resultado = $conexion->prepare($consulta);
		$resultado->execute();
		$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
		break;
	case "comentarios":
		// Recibir objeto e insertar comentarios en tabla comentarios
		$data = json_decode($dataForm, true);
		$dataList = $data["data"];

		if ($dataList) {
			$etapa = $dataList['etapa'];
			$responsable = $dataList['responsable'];
			$comentario = $dataList['comentario'];
			$solucion = $dataList['solucion'];

			$consulta = " INSERT INTO comentarios (id, idtablero, etapa, responsable, solucion, comentario, fecha) VALUES (NULL, '$idTablero', '$etapa', '$responsable', '$solucion', '$comentario', CURRENT_TIMESTAMP); ";
			echo $consulta . "<hr>";
			$resultado = $conexion->prepare($consulta);
			$resultado->execute();
		}
		break;

		/*	
    case "registro": // insertar en tabla registro
        // Recibir el objeto e insertar respuestas de formulario inspeccion
		break;
	*/
	case "seguridad": // insertar en tabla seguridad
		// Recibir el objeto e insertar respuestas de formulario seguridad
		$data = json_decode($dataForm);
		foreach ($data->checkbox as $key => $value) {
			if ($key) {
				$consulta = "INSERT INTO seguridad ( tag, valor, idTablero ) VALUES('$key', '$value', '$idTablero') ";
				echo $consulta;
				$resultado = $conexion->prepare($consulta);
				$resultado->execute();
			}
		}
		break;

	case "inspeccion": //insertar en tabla inspeccion
		// Recibir el objeto e insertar respuestas de formulario inspeccion
		$data = json_decode($dataForm);
		foreach ($data->checkbox as $key => $value) {
			if ($key) {
				$consulta = "INSERT INTO inspeccion (tag, valor, idTablero ) VALUES('$key', '$value', '$idTablero') ";
				$resultado = $conexion->prepare($consulta);
				$resultado->execute();
			}
		}
		foreach ($data->textbox as $key => $value) {
			if ($key) {
				$consulta = "INSERT INTO inspeccion (tag, valor, idTablero ) VALUES('$key', '$value', '$idTablero') ";
				$resultado = $conexion->prepare($consulta);
				$resultado->execute();
			}
		}
		foreach ($data->selectbox as $key => $value) {
			if ($key) {
				$consulta = "INSERT INTO inspeccion (tag, valor, idTablero ) VALUES('$key', '$value', '$idTablero') ";
				$resultado = $conexion->prepare($consulta);
				$resultado->execute();
			}
		}
		break;
	case "torques": // insertar en tabla torques
		// Recibir el objeto e insertar respuestas de formulario torques
		$data = json_decode($dataForm);
		foreach ($data->checkbox as $key => $value) {
			if ($key) {
				$consulta = "INSERT INTO torques ( tag, valor, idTablero ) VALUES('$key', '$value', '$idTablero') ";
				echo $consulta;
				$resultado = $conexion->prepare($consulta);
				$resultado->execute();
			}
		}
		break;

	case "continuidad": // insertar en tabla continuidad
		// Recibir el objeto e insertar respuestas de formulario inspeccion
		$data = json_decode($dataForm);
		foreach ($data->selectbox as $key => $value) {
			if ($key) {
				$consulta = "INSERT INTO continuidad ( tag, valor, idTablero ) VALUES( '$key', '$value', '$idTablero') ";
				$resultado = $conexion->prepare($consulta);
				$resultado->execute();
			}
		}
		break;

	case "aislamiento":
		// Recibir el objeto e insertar respuestas de formulario inspeccion
		$nQ = 5;
		$data = json_decode($dataForm, true);
		$dataList = $data["textbox"];
		$keyList = array_keys($dataList);
		$qSections = (count($dataList)) / $nQ;

		for ($i = 0; $i < $qSections; $i++) {
			$nS = ($i * $nQ);
			if ($keyList) {
				$seccion = $dataList[$keyList[0 + $nS]];
				$n = $dataList[$keyList[1 + $nS]];
				$f1 = $dataList[$keyList[2 + $nS]];
				$f2 = $dataList[$keyList[3 + $nS]];
				$f3 = $dataList[$keyList[4 + $nS]];

				$consulta = "INSERT INTO resistencia (id, idtablero, seccion, n, f1, f2, f3, fecha, status) VALUES (NULL, '$idTablero', '$seccion', '$n', '$f1', '$f2', '$f3', CURRENT_TIMESTAMP, 'statusAislamiento') ";
				$resultado = $conexion->prepare($consulta);
				$resultado->execute();
			}
		}
		break;

	case "hipot": // insertar en tabla hipot
		// Recibir el objeto e insertar respuestas de formulario Hipot
		$nQ = 9;
		$data = json_decode($dataForm, true);
		$dataList = $data["textbox"];
		$keyList = array_keys($dataList);
		$qSections = (count($dataList)) / $nQ;

		for ($i = 0; $i < $qSections; $i++) {
			$nS = ($i * $nQ);
			if ($keyList) {
				$seccion = $dataList[$keyList[0 + $nS]];
				$nohm = $dataList[$keyList[1 + $nS]];
				$f1ohm = $dataList[$keyList[2 + $nS]];
				$f2ohm = $dataList[$keyList[3 + $nS]];
				$f3ohm = $dataList[$keyList[4 + $nS]];
				$nvolt = $dataList[$keyList[5 + $nS]];
				$f1volt = $dataList[$keyList[6 + $nS]];
				$f2volt = $dataList[$keyList[7 + $nS]];
				$f3volt = $dataList[$keyList[8 + $nS]];

				$consulta = "INSERT INTO hipot (id, idtablero, seccion, f1ohm, f1volt, f2ohm, f2volt, f3ohm, f3volt, fecha, status) VALUES (NULL, '$idTablero', '$seccion', '$f1ohm', '$f1volt', '$f2ohm', '$f2volt', '$f3ohm', '$f3volt', CURRENT_TIMESTAMP, 'statusHipot'); ";

				$resultado = $conexion->prepare($consulta);
				$resultado->execute();
			}
		}
		break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
