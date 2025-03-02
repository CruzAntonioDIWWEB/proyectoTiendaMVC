<h1>Crear nueva categoría</h1>

<?php if (isset($_SESSION['category_error'])): ?>
    <div class="alert error">
        <?= $_SESSION['category_error'] ?>
    </div>
    <?php \Lib\Utils::deleteSession('category_error'); ?>
<?php endif; ?>


<div class="form_container">
    <form action="index.php?controller=category&action=save" method="POST">
        <label for="nombre">Nombre de la categoría</label>
        <input type="text" name="nombre" required maxlength="100" pattern="[A-Za-zÀ-ÖØ-öø-ÿ0-9\s\-\.]{3,100}">
        <small>El nombre debe tener entre 3 y 100 caracteres alfanuméricos.</small>

        <input type="submit" value="Guardar categoría">
    </form>
</div>

<div class="links">
    <a href="index.php?controller=category&action=index">Volver a categorías</a>
</div>