<!-- Contenido -->
<section class="content">

    <?php if (isset($_SESSION['register'])): ?>
        <div class="alert <?= $_SESSION['register'] == 'Registro Completado' ? 'success' : 'error' ?>">
            <?= $_SESSION['register'] ?>
        </div>
        <?php unset($_SESSION['register']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['register_error'])): ?>
        <div class="alert error">
            <?= $_SESSION['register_error'] ?>
        </div>
        <?php unset($_SESSION['register_error']); ?>
    <?php endif; ?>

    <aside class="sidebar">
        <div class="login block_aside">
            <h3>Identifícate</h3>
            <form action="#" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" required>
                <label for="password">Contraseña</label>
                <input type="password" name="password" required>
                <input type="submit" value="Enviar">
            </form>
            <a href="#">Mis pedidos</a>
            <a href="#">Gestionar pedidos</a>
            <a href="#">Gestionar categorías</a>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <section class="central">
        <article class="product">
            <img src="../assets/img/logotipo.jpg" alt="Producto">
            <h2>Producto 1</h2>
            <p>30€</p>
            <a href="#">Comprar</a>
        </article>

        <article class="product">
            <img src="../assets/img/logotipo.jpg" alt="Producto">
            <h2>Producto 1</h2>
            <p>30€</p>
            <a href="#">Comprar</a>
        </article>

        <article class="product">
            <img src="../assets/img/logotipo.jpg" alt="Producto">
            <h2>Producto 1</h2>
            <p>30€</p>
            <a href="#">Comprar</a>
        </article>
    </section>
</section>