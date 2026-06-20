<?php


require_once 'libs/router/router.php';
require_once 'app/controllers/servicios_api_controller.php';


// crea el router
$router = new Router();

// define la tabla de ruteo
$router->addRoute('servicios', 'GET', 'servicios_api_controller', 'getServicios');
$router->addRoute('servicio/:id', 'GET', 'servicios_api_controller', 'getServicioById');
$router->addRoute('servicio/:id', 'DELETE', 'servicios_api_controller', 'eliminarServicioById');
$router->addRoute('servicio', 'POST', 'servicios_api_controller', 'addServicio');
$router->addRoute('servicio/:id', 'PUT', 'servicios_api_controller', 'updateServicio');
$router->addRoute('servicio/:id', 'PATCH', 'servicios_api_controller', 'patchServicio');

// rutea según recurso y método de la solicitud
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);




?>