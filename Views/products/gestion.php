
<?php 
use Models\Product;
use Controllers\ProductController;

$controller = new Product();
$productos = $controller->getAll();
?>

<h1>Gestionar productos</h1>

<?php if (isset($_SESSION['product'])): ?>
    <div class="alert success">
        <?php echo $_SESSION['product'] ?>
    </div>
    <?php \Lib\Utils::deleteSession('product'); ?>
<?php endif; ?>

<?php if (isset($_SESSION['product_error'])): ?>
    <div class="alert error">
        <?php echo $_SESSION['product_error'] ?>
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
            <!-- PARA EL FUTURO CRUD -->
            <!-- <?php if (\Lib\Utils::isAdmin()): ?>
                <th>ACCIONES</th>
            <?php endif; ?> -->
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo $producto['id'] ?></td>
                    <td><?php echo $producto['nombre'] ?></td>
                    <td><?php echo $producto['precio'] ?></td>
                    <td><?php echo $producto['stock'] ?></td>
                    <?php if (\Lib\Utils::isAdmin()): ?>
                        <td>
                            <!-- Assuming delete and edit actions are not implemented yet -->
                            <a href="index.php?controller=product&action=delete&id=<?php echo $producto['id'] ?>" 
                               class="button" 
                               onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                Eliminar
                            </a>
                            <a href="index.php?controller=product&action=edit&id=<?php echo $producto['id'] ?>" 
                               class="button" >
                                Editar
                            </a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="<?php echo \Lib\Utils::isAdmin() ? 5 : 4 ?>">No hay productos disponibles</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>