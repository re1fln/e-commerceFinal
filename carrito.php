<?php
include 'includes/config.php';
include 'includes/auth_functions.php';

check_auth();

// Procesar acciones del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++;
        } else {
            $stmt = $dbh->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                $_SESSION['cart'][$product_id] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'quantity' => 1
                ];
            }
        }
        
        header("Location: carrito.php");
        exit();
    }
    
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $product_id => $quantity) {
            if (isset($_SESSION['cart'][$product_id])) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
                } else {
                    unset($_SESSION['cart'][$product_id]);
                }
            }
        }
        
        header("Location: carrito.php");
        exit();
    }
}

// Procesar eliminación de producto
if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    
    header("Location: carrito.php");
    exit();
}

// Procesar vaciar carrito
if (isset($_GET['empty'])) {
    unset($_SESSION['cart']);
    header("Location: carrito.php");
    exit();
}

include 'includes/header.php';
?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-shopping-cart"></i> Tu Carrito de Compras</h2>
    
    <?php if(empty($_SESSION['cart'])): ?>
        <div class="alert alert-info">
            Tu carrito está vacío. <a href="products.php">Ver productos</a>
        </div>
    <?php else: ?>
        <form method="POST" action="carrito.php">
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach($_SESSION['cart'] as $product_id => $item): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td>
                                    <img src="uploads/<?= htmlspecialchars($item['image']) ?>" 
                                         width="50" 
                                         class="me-2"
                                         alt="<?= htmlspecialchars($item['name']) ?>">
                                    <?= htmlspecialchars($item['name']) ?>
                                </td>
                                <td>$<?= number_format($item['price'], 2) ?></td>
                                <td>
                                    <input type="number" 
                                           name="quantity[<?= $product_id ?>]" 
                                           value="<?= $item['quantity'] ?>" 
                                           min="1" 
                                           class="form-control" 
                                           style="width: 70px;">
                                </td>
                                <td>$<?= number_format($subtotal, 2) ?></td>
                                <td>
                                    <a href="carrito.php?remove=<?= $product_id ?>" 
                                       class="btn btn-sm btn-danger"
                                       title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total:</td>
                            <td colspan="2" class="fw-bold">$<?= number_format($total, 2) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="d-flex justify-content-between mt-3">
                <a href="carrito.php?empty=1" class="btn btn-outline-danger">
                    <i class="fas fa-broom"></i> Vaciar Carrito
                </a>
                
                <div>
                    <button type="submit" name="update_cart" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-sync-alt"></i> Actualizar
                    </button>
                    <a href="checkout.php" class="btn btn-success">
                        <i class="fas fa-credit-card"></i> Proceder al Pago
                    </a>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>