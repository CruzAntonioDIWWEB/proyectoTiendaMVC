<?php

use Models\Category;
?>

<h1>Gestionar categorías</h1>

<?php if (isset($_SESSION['category'])): ?>
    <div class="alert success">
        <?= $_SESSION['category'] ?>
    </div>
    <?php \Lib\Utils::deleteSession('category'); ?>
<?php endif; ?>

<?php if (isset($_SESSION['category_error'])): ?>
    <div class="alert error">
        <?= $_SESSION['category_error'] ?>
    </div>
    <?php \Lib\Utils::deleteSession('category_error'); ?>
<?php endif; ?>

<div class="button-container">
    <?php if (\Lib\Utils::isAdmin()): ?>
        <a href="index.php?controller=category&action=create" class="button">Crear categoría</a>
    <?php endif; ?>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <?php if (\Lib\Utils::isAdmin()): ?>
                <th>ACCIONES</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($categorias)): ?> <!-- Aqui uso la variable $categorias que se ha pasado desde el controlador -->
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?= $categoria['id'] ?></td>
                    <td><?= $categoria['nombre'] ?></td>
                    <?php if (\Lib\Utils::isAdmin()): ?>
                        <td>
                            <a href="index.php?controller=category&action=delete&id=<?= $categoria['id'] ?>"
                                class="button"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">
                                Eliminar
                            </a>
                            <a href="index.php?controller=category&action=edit&id=<?= $categoria['id'] ?>"
                                class="button">
                                Editar
                            </a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="<?= \Lib\Utils::isAdmin() ? 3 : 2 ?>">No hay categorías disponibles</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>