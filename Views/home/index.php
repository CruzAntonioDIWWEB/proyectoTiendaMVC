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

    <h1 class="titulo_index">Productos Destacados</h1>

    <!-- Incluir el sidebar -->
    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <!-- Contenido Principal -->
    <section class="central">

    <?php if (!empty($featuredProducts)): ?>
        <?php foreach($featuredProducts as $product): ?>
            <article class="product">
                <?php if(!empty($product['imagen'])): ?>
                    <img src="<?= 'uploads/images/' . $product['imagen'] ?>" alt="<?= $product['nombre'] ?>">
                <?php else: ?>
                    <img src="../assets/img/logotipo_tienda.webp" alt="Producto sin imagen">
                <?php endif; ?>
                
                <h2><?= $product['nombre'] ?></h2>
                <p><?= $product['precio'] ?>€</p>
                
                <?php if(isset($_SESSION['usuario'])): ?>
                    <button class="button">Comprar</button>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos disponibles para mostrar</p>
    <?php endif; ?>
</section>