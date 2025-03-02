<div class="form_container">
    <h1>Registro de usuarios</h1>

    <!-- Mensajes de error o éxito -->
    <?php if (isset($_SESSION['register_error'])): ?>
        <div class="alert error">
            <?= $_SESSION['register_error'] ?>
        </div>
        <?php unset($_SESSION['register_error']); ?>
    <?php endif; ?>

    <form action="index.php?controller=user&action=save" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" required>

        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" required>

        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="password">Contraseña</label>
        <input type="password" name="password" required>

        <input type="submit" value="Registrarse">
    </form>

    <div class="links">
        <p>¿Ya tienes una cuenta? <a href="index.php?controller=user&action=loginForm">Inicia sesión aquí</a></p>
    </div>
</div>