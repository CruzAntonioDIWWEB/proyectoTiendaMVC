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
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($categorias)): ?>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?php $categoria['id'] ?></td>
                    <td><?php $categoria['nombre'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No hay categorías disponibles</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>