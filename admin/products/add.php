<?php
include '../../includes/config.php';
include '../../includes/auth_functions.php';

check_auth();
if (!is_admin()) {
    header("Location: ../../index.php");
    exit();
}

$errors = [];
$categories = [];

// Obtener categorías
$stmt = $dbh->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $category_id = $_POST['category_id'] ?? null;
    
    // Validaciones
    if (empty($name)) $errors[] = "El nombre es requerido";
    if (empty($description)) $errors[] = "La descripción es requerida";
    if (!is_numeric($price) || $price <= 0) $errors[] = "El precio debe ser un número positivo";
    
    // Procesar imagen
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['image']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_name = uniqid() . '.' . $extension;
            $destination = UPLOAD_PATH . $image_name;
            
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                $errors[] = "Error al subir la imagen";
            }
        } else {
            $errors[] = "Solo se permiten imágenes JPEG, PNG o GIF";
        }
    } else {
        $errors[] = "La imagen es requerida";
    }
    
    if (empty($errors)) {
        $stmt = $dbh->prepare("INSERT INTO products (name, description, price, image, category_id) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $description, $price, $image_name, $category_id])) {
            header("Location: ../index.php?success=1");
            exit();
        } else {
            $errors[] = "Error al guardar el producto";
        }
    }
}

include '../../includes/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Agregar Nuevo Producto</h2>
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
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Precio</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="category_id" class="form-label">Categoría</label>
                <select class="form-select" id="category_id" name="category_id">
                    <option value="">Sin categoría</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="mb-4">
            <label for="image" class="form-label">Imagen del Producto</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            <div class="form-text">Formatos aceptados: JPG, PNG, GIF</div>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Guardar Producto
        </button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>