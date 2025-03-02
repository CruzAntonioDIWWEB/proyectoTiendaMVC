<?php
session_start();

//Cargo la configuración y el autoload
require_once '../config/config.php';
require_once '../vendor/autoload.php';

//Defino controlador y acción por defecto
$controllerName = 'Dashboard';
$action = 'index';

//Si existen parámetros en la URL se obtienen 
if (isset($_GET['controller'])) {
    $controllerName = ucfirst($_GET['controller']);
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

//Se define el nombre del controlador y la acción a ejecutar
$controllerClass = "Controllers\\{$controllerName}Controller";

//Uso del Autoload para cargar el controlador solicitado
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();

    if (method_exists($controller, $action)) {
        //Ejecución de la acción solicitada
        $controller->$action();
    } else {
        //Si la acción no existe se usa el método index del Dashboard
        $dashboard = new Controllers\DashboardController();
        $dashboard->index();
    }
} else {
    //Si el controlador no existe se carga el Dashboard por defecto
    $dashboard = new Controllers\DashboardController();
    $dashboard->index();
}
