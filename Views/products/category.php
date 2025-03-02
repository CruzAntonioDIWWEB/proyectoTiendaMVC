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

<!-- Contenido Principal -->
<section class="content">
    <div class="sidebar">
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
    </div>

    <section class="central">
        <?php if (!empty($products)): ?>
            <?php foreach($products as $product): ?>
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
            <p>No hay productos disponibles en esta categoría</p>
        <?php endif; ?>
    </section>
</section>