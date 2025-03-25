<?php

require_once "models/connection.php";
require_once "controllers/post.controller.php";

if(!isset($_POST)){
	echo json_encode('Error: should be POST');
	return;
}
/*=============================================
Crear arreglo con todas las columnas que recibimos del body.
=============================================*/
$columns = array();
foreach (array_keys($_POST) as $key => $value) {
	array_push($columns, $value);
}
//echo json_encode($columns);
//return;
/*=============================================
Validar la tabla y las columnas
=============================================*/

if(empty(Connection::getColumnsData($table, $columns))){
	$json = array(
		'status' => 400,
		'results' => "Error: Fields in the form do not match the database"
	);
	echo json_encode($json);
	return;
}

$response = new PostController();
/*=============================================
Peticion POST para registrar usuario
=============================================*/	
	
if(isset($_GET["register"]) && $_GET["register"] == true){
		$suffix = $_GET["suffix"] ?? "user";
		$response -> postRegister($table,$_POST,$suffix);
		return;
}

//Login de usuario
if(isset($_GET["login"]) && $_GET["login"] == true){
	$suffix = $_GET["suffix"] ?? "user";
	$response -> postLogin($table,$_POST,$suffix);
	return;
}
//Para todos los demas procesos se requiere autorización
if(!isset($_GET["token"])){
	$json = array(
		'status' => 400,
		'results' => "Error: Authorization required"
	);
	echo json_encode($json);
	return;
}
/*=============================================
Peticion POST para usuarios no autorizados
=============================================*/

if($_GET["token"] == "no" && isset($_GET["except"])){
	/*=============================================
	Validar la tabla y las columnas
	=============================================*/

	$columns = array($_GET["except"]);
    
	if(empty(Connection::getColumnsData($table, $columns))){

		$json = array(
			'status' => 400,
			'results' => "Error: Fields in the form do not match the database"
		);
		echo json_encode($json);
		return;
	}
    /*=============================================
	Solicitamos respuesta del controlador para crear datos en cualquier tabla
	=============================================*/		

	$response -> postData($table,$_POST);
    return;
}
/*=============================================
Peticion POST para usuarios autorizados
=============================================*/
$tableToken = $_GET["table"] ?? "users";
$suffix = $_GET["suffix"] ?? "user";

$validate = Connection::tokenValidate($_GET["token"],$tableToken,$suffix);

/*=============================================
Solicitamos respuesta del controlador para crear datos en cualquier tabla
=============================================*/		

if($validate == "ok"){
	$response -> postData($table,$_POST);
}

/*=============================================
Error cuando el token ha expirado
=============================================*/	

if($validate == "expired"){
	$json = array(
		'status' => 303,
		'results' => "Error: The token has expired"
	);
	echo json_encode($json);
	return;
}

/*=============================================
Error cuando el token no coincide en BD
=============================================*/	

if($validate == "no-auth"){
	$json = array(
		'status' => 400,
		'results' => "Error: The user is not authorized"
	);
	echo json_encode($json);
	return;
}
