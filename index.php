<?php



/*=============================================

Mostrar errores

=============================================*/


date_default_timezone_set('America/Mexico_City');

ini_set('display_errors', 1);

ini_set("log_errors", 1);

//configurar aqui donde se va a guardar el archivo que generar el log de errore

//cada que se escriba un error_log se almacenara ahi.

ini_set("error_log",  "./php_error_log");


/*=============================================

CORS

=============================================*/



header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Headers: Authorization,Origin, X-Requested-With, content-type, Accept");

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header("Allow: GET, POST, OPTIONS, PUT, DELETE");


header('content-type: application/json; charset=utf-8');





/*=============================================

Requerimientos

=============================================*/


require_once "controllers/routes.controller.php";



$index = new RoutesController();

$index -> index();