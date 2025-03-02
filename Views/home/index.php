<!-- Contenido -->
<section class="content">
    <!-- Mensaje de exito o fracaso en el registro -->
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
        <div class="block_aside">
            <?php if(isset($_SESSION['usuario'])): ?>
                <h3>Bienvenido, <?= $_SESSION['usuario']['nombre'] ?></h3>
                <a href="index.php?controller=user&action=logout" class="button">Cerrar sesión</a>
                
                <?php if(isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] == 'admin'): ?>
                    <a href="index.php?controller=category&action=index">Gestionar categorías</a>
                    <a href="index.php?controller=product&action=index">Gestionar productos</a>
                <?php endif; ?>
            <?php else: ?>
                <h3>No se ha identificado</h3>
            <?php endif; ?>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <section class="central">
        <article class="product">
            <img src="../assets/img/violin_1.jpg" alt="Producto">
            <h2>Violin</h2>
            <p>50€</p>
            <a href="#">Comprar</a>
        </article>

        <article class="product">
            <img src="../assets/img/flauta_1.jpg" alt="Producto">
            <h2>Flauta</h2>
            <p>25€</p>
            <a href="#">Comprar</a>
        </article>

        <article class="product">
            <img src="../assets/img/trompeta_1.jpg" alt="Producto">
            <h2>Trompeta</h2>
            <p>20€</p>
            <a href="#">Comprar</a>
        </article>
    </section>
</section>