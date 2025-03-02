<div class="form_container">
    <h1>Iniciar Sesión</h1>

    <!-- Mensajes de error o éxito -->
    <?php if (isset($_SESSION['errorLogin'])): ?>
        <div class="alert error">
            <?= $_SESSION['errorLogin'] ?>
        </div>
        <?php unset($_SESSION['errorLogin']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['loginExito'])): ?>
        <div class="alert success">
            <?= $_SESSION['loginExito'] ? 'Has iniciado sesión correctamente' : '' ?>
        </div>
        <?php unset($_SESSION['loginExito']); ?>
    <?php endif; ?>

    <form action="index.php?controller=user&action=loginAction" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" required
            value="<?= isset($_COOKIE['emailLogin']) ? $_COOKIE['emailLogin'] : '' ?>">

        <label for="password">Contraseña</label>
        <input type="password" name="password" required>

        <div class="checkbox-container">
            <input type="checkbox" name="recuerdame" id="recuerdame"
                <?= isset($_COOKIE['remember_me']) ? 'checked' : '' ?>>
            <label for="recuerdame">Recuérdame</label>
        </div>

        <input type="submit" value="Iniciar Sesión">
    </form>

    <div class="links">
        <p>¿No tienes cuenta? <a href="index.php?controller=user&action=registro">Regístrate aquí</a></p>
    </div>
</div>