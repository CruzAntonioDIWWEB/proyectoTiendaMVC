<?php
use Models\Category;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Chotos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <section class="container">
        <!-- Cabecera -->
        <header class="header">
            <section class="logo">
                <img src="../assets/img/logotipo.jpg" alt="Logotipo">
                <a href="index.php">Tienda de Chotos</a>
            </section>
        </header>

        <!-- Menú de navegación -->
        <nav class="menu">
            <ul>
                <li><a href="index.php?controller=user&action=registro">Registro</a></li>
                <li><a href="index.php?controller=user&action=loginForm">Iniciar sesión</a></li>
            </ul>
        </nav>