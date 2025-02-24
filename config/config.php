<?php

namespace config;
use PDO;
use PDOException;

require_once __DIR__ . '/../vendor/autoload.php'; // carga el autoload de composer

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // carga el archivo .env 
$dotenv->load(); // carga las variables de entorno

// Configuración de la base de datos
define('DBHOST', $_ENV['DBHOST']);
define('DBNAME', $_ENV['DBNAME']);
define('DBUSER', $_ENV['DBUSER']);
define('DBPASSWORD', $_ENV['DBPASSWORD']);

//Conexión a la base de datos usando PDO
try {
    $dsn = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=utf8';
    $pdo = new PDO($dsn, DBUSER, DBPASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa con la base de datos";
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

?>