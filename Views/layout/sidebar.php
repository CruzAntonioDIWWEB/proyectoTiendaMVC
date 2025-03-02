<div class="sidebar">
    <div class="block_aside">
        <?php if(isset($_SESSION['usuario'])): ?>
            <h3>Bienvenido, <?= $_SESSION['usuario']['nombre'] ?></h3>
            <a href="index.php?controller=user&action=logout" class="button">Cerrar sesión</a>
            
            <?php if(isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] == 'admin'): ?>
                <a href="index.php?controller=category&action=index">Gestionar categorías</a>
                <a href="index.php?controller=product&action=gestion">Gestionar productos</a>
            <?php endif; ?>
        <?php else: ?>
            <h3>No se ha identificado</h3>
        <?php endif; ?>
    </div>
</div>