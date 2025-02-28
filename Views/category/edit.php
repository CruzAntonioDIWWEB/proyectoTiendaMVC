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
        <input type="hidden" name="id" value="<?= $categoria->getId() ?>">
        
        <label for="nombre">Nombre de la categoría</label>
        <input type="text" name="nombre" value="<?= $categoria->getNombre() ?>" required>
        
        <input type="submit" value="Actualizar categoría">
    </form>
</div>

<div class="links">
    <a href="index.php?controller=category&action=index">Volver a categorías</a>
</div>