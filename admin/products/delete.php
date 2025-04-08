<?php
include '../../includes/config.php';
include '../../includes/auth_functions.php';

check_auth();
if (!is_admin()) {
    header("Location: ../../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Obtener información del producto para eliminar la imagen
    $stmt = $dbh->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        // Eliminar el producto
        $stmt = $dbh->prepare("DELETE FROM products WHERE id = ?");
        if ($stmt->execute([$product_id])) {
            // Eliminar la imagen si existe
            if (!empty($product['image']) && file_exists(UPLOAD_PATH . $product['image'])) {
                unlink(UPLOAD_PATH . $product['image']);
            }
            
            header("Location: ../index.php?deleted=1");
            exit();
        }
    }
}

header("Location: ../index.php");
exit();
?>