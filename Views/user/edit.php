<h1>Editar mi perfil</h1>

<?php if (isset($_SESSION['user_update'])): ?>
    <div class="alert success">
        <?= $_SESSION['user_update'] ?>
    </div>
    <?php unset($_SESSION['user_update']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['user_error'])): ?>
    <div class="alert error">
        <?= $_SESSION['user_error'] ?>
    </div>
    <?php unset($_SESSION['user_error']); ?>
<?php endif; ?>

<div class="form_container">
    <form action="index.php?controller=user&action=update" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="<?= $user_data->getNombre() ?>" required minlength="3" maxlength="100">

        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" value="<?= $user_data->getApellidos() ?>" required minlength="3" maxlength="100">

        <label for="email">Email</label>
        <input type="email" name="email" value="<?= $user_data->getEmail() ?>" required>

        <label for="password">Contraseña (dejar en blanco para mantener la actual)</label>
        <input type="password" name="password" minlength="6">

        <?php if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] == 'admin'): ?>
            <label for="rol">Rol</label>
            <select name="rol">
                <option value="user" <?= $user_data->getRol() == 'user' ? 'selected' : '' ?>>Usuario</option>
                <option value="admin" <?= $user_data->getRol() == 'admin' ? 'selected' : '' ?>>Administrador</option>
            </select>
        <?php endif; ?>

        <input type="submit" value="Actualizar datos" class="button">
    </form>
</div>

<div class="links">
    <a href="index.php">Volver a inicio</a>
</div>