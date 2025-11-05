<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIController;
use MVC\Router;
use Controllers\citaController;
use Controllers\loginController;

$router = new Router();


//Iniciar sesion

$router->get('/', [loginController::class, 'login']);
$router->post('/', [loginController::class, 'login']);
$router->get('/logout', [loginController::class, 'logout']);

//Recuperar Password
$router->get('/restablecer', [loginController::class, 'restablecer']);
$router->post('/restablecer', [loginController::class, 'restablecer']);
$router->get('/recuperar', [loginController::class, 'recuperar']);
$router->post('/recuperar', [loginController::class, 'recuperar']);


//Crear cuenta
$router->get('/crear-cuenta', [loginController::class, 'crear']);
$router->post('/crear-cuenta', [loginController::class, 'crear']);


//Confirmar cuenta
$router->get('/confirmar-cuenta', [loginController::class, 'confirmar']);
$router->get('/mensaje', [loginController::class, 'mensaje']);


//Area de Usuario
$router->get('/cita',[citaController::class, 'index']);


//API de Citas
$router->get('/api/servicios', [APIController::class, 'index']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();