<?php
include 'includes/config.php';
include 'includes/auth_functions.php';

check_auth();

// Paginación
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 6;
$offset = ($page - 1) * $per_page;

// Obtener productos
$stmt = $dbh->prepare("SELECT * FROM products LIMIT :offset, :per_page");
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':per_page', $per_page, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar total de productos para paginación
$total_stmt = $dbh->query("SELECT COUNT(*) FROM products");
$total_products = $total_stmt->fetchColumn();
$total_pages = ceil($total_products / $per_page);

include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Nuestros Productos</h2>
        
        <?php if(is_admin()): ?>
            <a href="admin/products/add.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Agregar Producto
            </a>
        <?php endif; ?>
    </div>
    
    <!-- Barra de búsqueda -->
    <form action="search.php" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Buscar productos...">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </form>
    
    <!-- Listado de productos -->
    <div class="row">
        <?php if(empty($products)): ?>
            <div class="col-12">
                <div class="alert alert-info">No hay productos disponibles.</div>
            </div>
        <?php else: ?>
            <?php foreach($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 product-card">
                        <img src="uploads/<?= htmlspecialchars($product['image']) ?>" 
                             class="card-img-top product-image" 
                             alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($product['description']) ?></p>
                            <p class="text-success fw-bold">$<?= number_format($product['price'], 2) ?></p>
                            
                            <div class="d-flex justify-content-between">
                                <?php if(is_admin()): ?>
                                    <a href="admin/products/edit.php?id=<?= $product['id'] ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="admin/products/delete.php?id=<?= $product['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </a>
                                <?php else: ?>
                                    <form method="POST" action="carrito.php" class="w-100">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <button type="submit" name="add_to_cart" class="btn btn-primary w-100">
                                            <i class="fas fa-cart-plus"></i> Agregar al carrito
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- Paginación -->
    <?php if($total_pages > 1): ?>
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php if($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            
            <?php if($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>