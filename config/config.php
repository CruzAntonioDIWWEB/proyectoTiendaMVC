<?php

require __DIR__ . 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // carga el archivo .env 
$dotenv->load(); // carga las variables de entorno

// Configuración de la base de datos
define('DBHOST', $_ENV['DBHOST']);
define('DBNAME', $_ENV['DBNAME']);
define('DBUSER', $_ENV['DBUSER']);
define('DBPASSWORD', $_ENV['DBPASSWORD']);

?>