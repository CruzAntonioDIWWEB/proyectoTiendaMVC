<?php

use Models\Category;

// Obtener las categorías para el menú
$categoryModel = new Category();
$menuCategories = $categoryModel->getAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Instrumentos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <section class="container">
        <!-- Cabecera -->
        <header class="header">
            <section class="logo">
                <img src="../assets/img/logotipo_tienda.webp" alt="Logotipo">
                <a href="index.php">Instrumentos de Música</a>
            </section>
        </header>

        <!-- Menú de navegación -->
        <nav class="menu">
            <ul>
                <!-- Categorías del menú -->
                <?php if (!empty($menuCategories)): ?>
                    <li>
                        <?php foreach ($menuCategories as $categoria): ?>
                    <li>
                        <a href="index.php?controller=product&action=category&id=<?= $categoria['id'] ?>">
                            <?= $categoria['nombre'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                </li>
            <?php endif; ?>

            <!-- Enlaces de usuario -->
            <li><a href="index.php?controller=user&action=registro">Registro</a></li>
            <li><a href="index.php?controller=user&action=loginForm">Iniciar sesión</a></li>
            </ul>
        </nav>