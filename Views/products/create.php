<h1>Crear nuevo producto</h1>

<?php if (isset($_SESSION['product_error'])): ?>
    <div class="alert error">
        <?= $_SESSION['product_error'] ?>
    </div>
    <?php \Lib\Utils::deleteSession('product_error'); ?>
<?php endif; ?>

<div class="form_container">
    <form action="index.php?controller=product&action=save" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre del producto</label>
        <input type="text" name="nombre" required>
        
        <label for="descripcion">Descripción del producto</label>
        <textarea name="descripcion" required></textarea>
        
        <label for="precio">Precio del producto</label>
        <input type="text" name="precio" required>
        
        <label for="stock">Stock del producto</label>
        <input type="number" name="stock" required>
        
        <label for="categoria">Categoría del producto</label>
        <select name="categoria" required>
        <?php if (isset($categories) && !empty($categories)): ?>
            <?php foreach ($categories as $categoria): ?>
                <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="">No hay categorías disponibles</option>
        <?php endif; ?>
        </select>
        
        <label for="imagen">Imagen del producto</label>
        <input type="file" name="imagen" required>

        <input type="submit" value="Guardar producto">
    </form>
</div>

<div class="links">
    <a href="index.php?controller=product&action=index">Volver a productos</a>
</div>