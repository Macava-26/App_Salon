<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\loginController;
use MVC\Router;

$router = new Router();


//Iniciar sesion

$router->get('/', [loginController::class, 'login']);
$router->post('/', [loginController::class, 'login']);
$router->get('/logout', [loginController::class, 'logout']);

//Recuperar Password
$router->get('/olvide', [loginController::class, 'olvide']);
$router->post('/olvide', [loginController::class, 'olvide']);
$router->get('/recuperar', [loginController::class, 'recuperar']);
$router->post('/recuperar', [loginController::class, 'recuperar']);


//Crear cuenta
$router->get('/crear-cuenta', [loginController::class, 'crear']);
$router->post('/crear-cuenta', [loginController::class, 'crear']);




// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();