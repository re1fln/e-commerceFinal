-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2025 a las 07:10:47
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Electrónicos'),
(2, 'Ropa'),
(3, 'Hogar'),
(4, 'Deportes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'HP VICTUS 15-FB1013 GAMING AMD Ryzen 5 7535HS 512GB SSD 8GB', 'Lo que tienes que saber de este producto Capacidad de disco SSD: 512 GB SDD M.2\\n Memoria Ram Drr5 8 gigas 4800hz\\n  Procesador AMD Ryzen 5-7535hs Reloj baseMemoria RAM de 8GB. DRR5 3,3 ghz hasta 4.5 ghz\\n Resolución de 1920x1080 ips 144hz\\n Tarjeta gráfica NVIDIA GeForce RTX 2050. DRR6 Conexión wifi y bluetooth.\\n Con teclado Numerico retroiluminado Blanco en ingles .\\n\\nDescripción\\nLa Laptop Gamer Hp Victus Ryzen 5 7535hs es la elección perfecta para los amantes de los videojuegos. Con su potente procesador AMD Ryzen 5 de 6 núcleos y su tarjeta gráfica NVIDIA GeForce RTX 2050, podrás disfrutar de una experiencia de juego fluida y sin interrupciones. Su pantalla de 15.6\" con una frecuencia de actualización de 144 Hz y una resolución de 1920 px x 1080 px te sumergirá en mundos virtuales llenos de detalles y colores vibrantes. Además, su disco SSD de 512 GB te brinda un amplio espacio de almacenamiento para tus juegos, programas y archivos.\\nCon su diseño en color Mica Silver, esta laptop no solo es potente, sino también elegante. Su teclado retroiluminado te permite jugar incluso en ambientes con poca luz, mientras que su pantalla antirreflejo garantiza una visualización clara en cualquier situación. Además, cuenta con Bluetooth y Wi-Fi para una conectividad sin límites.\\n\\nNo pierdas la oportunidad de llevar a casa esta laptop gamer de alta calidad. Con la Laptop Gamer Hp Victus Ryzen 5 7535hs, estarás listo para enfrentar cualquier desafío virtual y llevar tus habilidades de juego al siguiente nivel.\\n\\nAviso legal\\n• La duración de la batería depende del uso que se le dé al producto.', 2550000.00, '67f4a74d88f7b.png', 1, '2025-04-07 18:05:51', '2025-04-08 04:34:21'),
(2, 'Samsung Galaxy S24 Ultra 5G ', 'Samsung galaxy s24 ultra\r\n\r\ndimensiones y peso\r\n\r\n162,3 x 79 x 8,6mm\r\n\r\n233 g\r\n\r\npantalla\r\n\r\n6,8 pulgadas\r\n\r\nResolución Quad HD+\r\n\r\nAMOLED LTPO\r\n\r\n1 - 120 Hz\r\n\r\nGorilla Glass Armor\r\n\r\nAlmacenamiento\r\n\r\n12 + 256 GB\r\n\r\n12 + 512 GB\r\n\r\n12 + 1 TB\r\n\r\ncámaras traseras\r\n\r\n200 MP, f/1.7, OIS\r\n\r\n50 MP, f/3.4, OIS, zoom x5\r\n\r\n10 MP, f/2.4, OIS, zoom x3\r\n\r\n12 MP, f/2.2\r\n\r\ncámara frontal\r\n\r\n12 MP, f/2.2\r\n\r\nbatería\r\n\r\n5.000mAh\r\n\r\n45W carga rápida\r\n\r\nCarga inalámbrica 15W\r\n\r\nsistema operativo\r\n\r\nAndroid 14 basado en One UI 6.1\r\n\r\nconectividad\r\n\r\n5G (2xNano + eSIM)\r\nWiFi 7\r\nBluetooth 5.3\r\nGPS\r\nNFC\r\nUWB\r\nUSB tipo C\r\n\r\notros\r\n\r\nIP68\r\n\r\nS-Pen integrado\r\n\r\nSamsung Dex', 3550000.00, '67f417aa52e4b.png', 1, '2025-04-07 18:05:51', '2025-04-07 18:21:30'),
(3, 'HP Smart Tank 580', 'Impresora Multifuncional HP Smart Tank 580. Fácil configuración guiada por dispositivo móvil. Imprima más a un costo por página muy bajo: hasta 12.000 páginas en negro o 6000 páginas en color de tinta incluidas en la caja. Configura fácilmente e imprime desde el celular vía WIFI con HP Smart APP. Los sensores de tinta permiten evitar los costosos reemplazos de los cabezales de impresión. Ahorre energía con la tecnología HP Auto-On/Auto-Of', 1273900.00, '67f41a05b97b3.png', 1, '2025-04-07 18:05:51', '2025-04-08 04:29:30'),
(5, 'Balón de FUTBOL', 'Balón De Fútbol #5 Golty Nova, Cosido A Maquina\r\n4,874,8 de 5 estrellas', 40500.00, '67f4a6b5aed33.png', 4, '2025-04-08 04:31:49', '2025-04-08 04:31:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Administrador', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2025-04-07 18:05:51'),
(2, 'Duvan Alejandro Bernate Piamba', 'duvanbernate@gmail.com', '$2y$10$E5hSoiRkdYVUSdvnK2.Ww.DrDzpiPKZjLIZ64CSzRnkVK0UOOUAom', 'admin', '2025-04-07 18:10:13'),
(3, 'Duvan Alejandro', 'duvanbernate8900@gmail.com', '$2y$10$R7q/EJm3GgV9N2Fiu3./AeSM4e883618pjoFQCbE0FNbAxDRJ4buy', 'customer', '2025-04-07 18:10:37'),
(4, 'Juan Camilo suarez', 'juan@correo.com', '$2y$10$YdaMzju0PDKZcgFhiSGO3et4WiXDon2OUpsQbQC/PGaExgfyhPf1a', 'customer', '2025-04-07 20:10:25'),
(5, 'administrador 1', 'administrador@correo.com', '$2y$10$BvD2GVLRoXFZC2Od.UxvvuAw2gmRz6ANhayU1d67xQYMrNCamRrGG', 'admin', '2025-04-07 20:10:59');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
