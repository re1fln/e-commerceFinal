<?php
include 'includes/config.php';
include 'includes/auth_functions.php';

check_auth();

$query = $_GET['query'] ?? '';
$results = [];

if (!empty($query)) {
    $search = "%$query%";
    $stmt = $dbh->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
    $stmt->execute([$search, $search]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

include 'includes/header.php';
?>

<div class="container mt-4">
    <h2 class="mb-4">Resultados de búsqueda para "<?= htmlspecialchars($query) ?>"</h2>
    
    <?php if(empty($results)): ?>
        <div class="alert alert-info">
            No se encontraron productos que coincidan con tu búsqueda.
            <a href="products.php">Ver todos los productos</a>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach($results as $product): ?>
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
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>