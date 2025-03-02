<?php if (isset($_SESSION['product'])): ?>
    <div class="alert success">
        <?= $_SESSION['product'] ?>
    </div>
    <?php \Lib\Utils::deleteSession('product'); ?>
<?php endif; ?>

<?php if (isset($_SESSION['product_error'])): ?>
    <div class="alert error">
        <?= $_SESSION['product_error'] ?>
    </div>
    <?php \Lib\Utils::deleteSession('product_error'); ?>
<?php endif; ?>

<h1>Categoría: <?= $category_name ?></h1>

<!-- Sidebar -->
<?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

<!-- Contenido Principal -->
    <section class="central">
        <?php if (!empty($products)): ?>
            <?php foreach($products as $product): ?>
                <article class="product">
                    <?php if(!empty($product['imagen'])): ?>
                        <img src="<?= '../assets/img/' . $product['imagen'] ?>" alt="<?= $product['nombre'] ?>">
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
            <p>No hay productos disponibles en esta categoría</p>
        <?php endif; ?>
    </section>
</section>