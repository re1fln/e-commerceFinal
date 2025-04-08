<?php
include 'includes/config.php';
include 'includes/auth_functions.php';

check_auth();

include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0"><i class="fas fa-tachometer-alt"></i> Panel de Control</h4>
            </div>
            <div class="card-body">
                <h5>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?>!</h5>
                <p class="mb-4">Desde aquí puedes acceder a todas las funciones del sistema.</p>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-box-open fa-3x text-primary mb-3"></i>
                                <h5>Productos</h5>
                                <a href="products.php" class="btn btn-outline-primary mt-2">Ver Productos</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-shopping-cart fa-3x text-success mb-3"></i>
                                <h5>Carrito</h5>
                                <a href="carrito.php" class="btn btn-outline-success mt-2">Ver Carrito</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if(is_admin()): ?>
                <div class="mt-4 pt-3 border-top">
                    <h5 class="mb-3">Funciones de Administrador</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="admin/products/add.php" class="btn btn-primary w-100">
                                <i class="fas fa-plus"></i> Agregar Producto
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="admin/" class="btn btn-secondary w-100">
                                <i class="fas fa-cog"></i> Panel de Administración
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>