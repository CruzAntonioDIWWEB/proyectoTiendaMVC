<?php
use Models\Category;
?>

<h1>Editar categoría</h1>

<?php if (isset($_SESSION['category_error'])): ?>
    <div class="alert error">
        <?= $_SESSION['category_error'] ?>
    </div>
    <?php \Lib\Utils::deleteSession('category_error'); ?>
<?php endif; ?>

<div class="form_container">
    <form action="index.php?controller=category&action=update" method="POST">
    <input type="hidden" name="id" value="<?= $categoriaEncontrada->getId() ?>">
        
        <label for="nombre">Nombre de la categoría</label>
        <input type="text" name="nombre" value="<?= $categoriaEncontrada->getNombre() ?>" required maxlength="100" pattern="[A-Za-zÀ-ÖØ-öø-ÿ0-9\s\-\.]{3,100}">
        <small>El nombre debe tener entre 3 y 100 caracteres alfanuméricos.</small>
        
        <input type="submit" value="Actualizar categoría">
    </form>
</div>


<div class="links">
    <a href="index.php?controller=category&action=index">Volver a categorías</a>
</div>