# Sistema E-Commerce PHP/MySQL

Sistema completo de gestión de productos con carrito de compras, roles de usuario y panel de administración.

## Características

- Autenticación de usuarios (login/registro)
- Roles: Administrador y Cliente
- CRUD completo de productos
- Carrito de compras con sesiones
- Búsqueda de productos
- Diseño responsive con Bootstrap 5
- Subida de imágenes para productos
- Paginación de resultados
- Validación de formularios

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache, Nginx)
- Extensiones PHP: PDO, MySQLi, GD (para imágenes)

## Instalación

1. Clonar el repositorio o descargar los archivos
2. Crear una base de datos MySQL e importar el archivo `database.sql`
3. Configurar los datos de conexión en `includes/config.php`
4. Asegurarse que el directorio `uploads` tenga permisos de escritura
5. Acceder al sistema mediante el navegador

## Credenciales iniciales

**Administrador:**
- Email: admin@example.com
- Contraseña: password

**Usuario normal:**
- Puede registrarse desde la interfaz

## Estructura de archivos
ecommerce-php/
├── admin/ # Panel de administración
├── assets/ # CSS, JS e imágenes
├── includes/ # Funciones y configuraciones
├── uploads/ # Imágenes subidas
├── index.php # Redirección
├── login.php # Inicio de sesión
├── register.php # Registro de usuarios
├── products.php # Listado de productos
├── carrito.php # Carrito de compras
└── README.md # Documentación

Copy

## Capturas de pantalla

![Login](screenshots/login.png)
![Productos](screenshots/products.png)
![Carrito](screenshots/cart.png)
![Admin](screenshots/admin.png)

## Licencia

MIT License