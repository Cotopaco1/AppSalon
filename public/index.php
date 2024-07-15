<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;
use Controllers\ServiciosController;
use MVC\Router;

$router = new Router();

//Iniciar sesion.
//login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);

$router->get('/logout', [LoginController::class, 'logout']);
$router->post('/logout', [LoginController::class, 'logout']);
//olvide
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
//Recuperar contrase'a
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);
//Crear cuenta
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);

$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

//Area privada
$router->get('/cita', [CitaController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

//API REST
$router->get('/api/servicios', [ServiciosController::class, 'servicios']);
$router->post('/api/citas', [ServiciosController::class, 'guardar']);
$router->post('/api/eliminar', [ServiciosController::class, 'eliminar']);

//CRUD
$router->get('/servicios',[ServicioController::class, 'index']);
$router->get('/servicios/crear',[ServicioController::class, 'crear']);
$router->post('/servicios/crear',[ServicioController::class, 'crear']);
$router->get('/servicios/actualizar',[ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar',[ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar',[ServicioController::class, 'eliminar']);




// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();