<?php
include '../../includes/config.php';
include '../../includes/auth_functions.php';

check_auth();
if (!is_admin()) {
    header("Location: ../../index.php");
    exit();
}

$errors = [];
$product = null;
$categories = [];

// Obtener categorías
$stmt = $dbh->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener producto a editar
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    $stmt = $dbh->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $category_id = $_POST['category_id'] ?? null;
    $current_image = $product['image'];
    
    // Validaciones
    if (empty($name)) $errors[] = "El nombre es requerido";
    if (empty($description)) $errors[] = "La descripción es requerida";
    if (!is_numeric($price) || $price <= 0) $errors[] = "El precio debe ser un número positivo";
    
    // Procesar nueva imagen si se subió
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['image']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_name = uniqid() . '.' . $extension;
            $destination = UPLOAD_PATH . $image_name;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                // Eliminar la imagen anterior si existe
                if (!empty($current_image) && file_exists(UPLOAD_PATH . $current_image)) {
                    unlink(UPLOAD_PATH . $current_image);
                }
                $current_image = $image_name;
            } else {
                $errors[] = "Error al subir la nueva imagen";
            }
        } else {
            $errors[] = "Solo se permiten imágenes JPEG, PNG o GIF";
        }
    }
    
    if (empty($errors)) {
        $stmt = $dbh->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ?, category_id = ? WHERE id = ?");
        if ($stmt->execute([$name, $description, $price, $current_image, $category_id, $product['id']])) {
            header("Location: ../index.php?updated=1");
            exit();
        } else {
            $errors[] = "Error al actualizar el producto";
        }
    }
}

include '../../includes/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Producto</h2>
        <a href="../index.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
    
    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Producto</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" 
                      rows="3" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Precio</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" 
                           value="<?= htmlspecialchars($product['price']) ?>" required>
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="category_id" class="form-label">Categoría</label>
                <select class="form-select" id="category_id" name="category_id">
                    <option value="">Sin categoría</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" 
                            <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="mb-4">
            <label for="image" class="form-label">Imagen del Producto</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <div class="form-text">Formatos aceptados: JPG, PNG, GIF. Dejar en blanco para mantener la imagen actual.</div>
            
            <?php if(!empty($product['image'])): ?>
                <div class="mt-2">
                    <img src="../../uploads/<?= htmlspecialchars($product['image']) ?>" 
                         alt="Imagen actual" 
                         style="max-height: 150px;">
                </div>
            <?php endif; ?>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Guardar Cambios
        </button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>