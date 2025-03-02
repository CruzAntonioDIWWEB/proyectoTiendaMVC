<h1>Gestionar productos</h1>

<?php if (isset($_SESSION['product'])): ?>
    <div class="alert success">
        <?= $_SESSION['product'] ?>
    </div>
    <?php \Lib\Utils::deleteSession('product'); ?>
<?php endif; ?>

<?php if (isset($_SESSION['product_error'])): ?>
    <div class="alert error">
        <?= $_SESSION['product_error'] ?>
    </div>
    <?php \Lib\Utils::deleteSession('product_error'); ?>
<?php endif; ?>

<div class="button-container">
    <?php if (\Lib\Utils::isAdmin()): ?>
        <a href="index.php?controller=product&action=create" class="button">Crear producto</a>
    <?php endif; ?>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>PRECIO</th>
            <th>STOCK</th>
            <?php if (\Lib\Utils::isAdmin()): ?>
                <th>ACCIONES</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($products) && !empty($products)): ?>
            <?php foreach ($products as $producto): ?>
                <tr>
                    <td><?= $producto['id'] ?></td>
                    <td><?= $producto['nombre'] ?></td>
                    <td><?= $producto['precio'] ?></td>
                    <td><?= $producto['stock'] ?></td>
                    <?php if (\Lib\Utils::isAdmin()): ?>
                        <td>
                            <a href="index.php?controller=product&action=delete&id=<?= $producto['id'] ?>"
                                class="button"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                Eliminar
                            </a>
                            <a href="index.php?controller=product&action=edit&id=<?= $producto['id'] ?>"
                                class="button">
                                Editar
                            </a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="<?= \Lib\Utils::isAdmin() ? 5 : 4 ?>">No hay productos disponibles</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>