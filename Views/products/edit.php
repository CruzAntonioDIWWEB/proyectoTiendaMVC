<h1>Editar producto</h1>

<?php if (isset($_SESSION['product_error'])): ?>
    <div class="alert error">
        <?= $_SESSION['product_error'] ?>
    </div>
    <?php \Lib\Utils::deleteSession('product_error'); ?>
<?php endif; ?>

<div class="form_container">
    <form action="index.php?controller=product&action=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $productoEncontrado->getId() ?>">
        
        <label for="nombre">Nombre del producto</label>
        <input type="text" name="nombre" value="<?= $productoEncontrado->getNombre() ?>" required>
        
        <label for="descripcion">Descripción del producto</label>
        <textarea name="descripcion" required><?= $productoEncontrado->getDescripcion() ?></textarea>
        
        <label for="precio">Precio del producto</label>
        <input type="text" name="precio" value="<?= $productoEncontrado->getPrecio() ?>" required>
        
        <label for="stock">Stock del producto</label>
        <input type="number" name="stock" value="<?= $productoEncontrado->getStock() ?>" required>
        
        <label for="categoria">Categoría del producto</label>
        <select name="categoria" required>
        <?php if (isset($categories) && !empty($categories)): ?>
            <?php foreach ($categories as $categoria): ?>
                <option value="<?= $categoria['id'] ?>" <?= $productoEncontrado->getCategoriaId() == $categoria['id'] ? 'selected' : '' ?>>
                    <?= $categoria['nombre'] ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="">No hay categorías disponibles</option>
        <?php endif; ?>
        </select>
        
        <label for="imagen">Imagen actual: <?= $productoEncontrado->getImagen() ?></label>
        <?php if ($productoEncontrado->getImagen()): ?>
            <img src="uploads/images/<?= $productoEncontrado->getImagen() ?>" style="max-width: 200px;">
        <?php endif; ?>
        
        <label for="imagen">Cambiar imagen (opcional)</label>
        <input type="file" name="imagen">

        <input type="submit" value="Actualizar producto">
    </form>
</div>

<div class="links">
    <a href="index.php?controller=product&action=gestion">Volver a productos</a>
</div>