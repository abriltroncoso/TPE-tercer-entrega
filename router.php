<?php

require_once './app/controladores/apiControlador.php';
require_once './libs/route.php';

$router = new Router();

$router->addRoute('sede',  'GET', 'apiControlador', 'obtenerTodas');
$router->addRoute('sede/:id', 'PUT', 'apiControlador', 'actualizar');
$router->addRoute('sede/:id', 'GET', 'ApiControlador', 'obtenerPorId');
$router->addRoute('sede', 'POST', 'ApiControlador', 'agregarSede');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
