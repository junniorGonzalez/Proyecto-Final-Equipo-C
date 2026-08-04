
-- ==================================================
-- Usuario administrador por defecto
-- Correo: admin@laneverita.com
-- Contraseña inicial: 12345678
-- La contraseña se almacena utilizando password_hash().
-- ==================================================

DROP DATABASE IF EXISTS laneverita;

CREATE DATABASE laneverita
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE laneverita;
CREATE TABLE roles(
 id_rol INT AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR(30) NOT NULL
);

CREATE TABLE usuarios(
 id_usuario INT AUTO_INCREMENT PRIMARY KEY,
 id_rol INT NOT NULL,
 nombre VARCHAR(60),
 apellido VARCHAR(60),
 correo VARCHAR(120) UNIQUE,
 password VARCHAR(255),
 telefono VARCHAR(20),
 direccion VARCHAR(255),
 fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
 estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
 FOREIGN KEY(id_rol) REFERENCES roles(id_rol)
);

CREATE TABLE categorias(
 id_categoria INT AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR(80),
 descripcion VARCHAR(255),
 estado ENUM('Activo','Inactivo') DEFAULT 'Activo'
);

CREATE TABLE productos(
 id_producto INT AUTO_INCREMENT PRIMARY KEY,
 id_categoria INT NOT NULL,
 nombre VARCHAR(120),
 descripcion TEXT,
 precio DECIMAL(10,2),
 stock INT,
 imagen VARCHAR(255),
 estado ENUM('Disponible','No disponible') DEFAULT 'Disponible',
 FOREIGN KEY(id_categoria) REFERENCES categorias(id_categoria)
);

CREATE TABLE pedidos(
 id_pedido INT AUTO_INCREMENT PRIMARY KEY,
 id_usuario INT NOT NULL,
 fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
 direccion_entrega VARCHAR(255),
 total DECIMAL(10,2),
 estado ENUM('Pendiente','Preparando','En camino','Entregado','Cancelado') DEFAULT 'Pendiente',
 FOREIGN KEY(id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE detalle_pedido(
 id_detalle INT AUTO_INCREMENT PRIMARY KEY,
 id_pedido INT NOT NULL,
 id_producto INT NOT NULL,
 cantidad INT,
 precio DECIMAL(10,2),
 subtotal DECIMAL(10,2),
 FOREIGN KEY(id_pedido) REFERENCES pedidos(id_pedido),
 FOREIGN KEY(id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE pagos(
 id_pago INT AUTO_INCREMENT PRIMARY KEY,
 id_pedido INT UNIQUE,
 metodo_pago ENUM('PayPal Sandbox','Contra Entrega'),
 referencia VARCHAR(100),
 monto DECIMAL(10,2),
 fecha_pago DATETIME DEFAULT CURRENT_TIMESTAMP,
 estado ENUM('Pendiente','Pagado','Rechazado') DEFAULT 'Pendiente',
 FOREIGN KEY(id_pedido) REFERENCES pedidos(id_pedido)
);

INSERT INTO roles(nombre) VALUES ('Administrador'),('Cliente');

INSERT INTO categorias(nombre,descripcion) VALUES
('Helados','Helados de diferentes sabores'),
('Granizados','Granizados naturales'),
('Frutas Locas','Frutas preparadas'),
('Promociones','Combos y ofertas');

INSERT INTO usuarios(
    id_rol,
    nombre,
    apellido,
    correo,
    password
)
VALUES(
    1,
    'Administrador',
    'Sistema',
    'admin@laneverita.com',
    '$2y$10$nbtukNBuF79R9AXG/EZ09et6COXMJIwjlgd7ZP6ztqTZa0lP9ftIK'
);

INSERT INTO productos
(id_categoria,nombre,descripcion,precio,stock,imagen,estado)
VALUES
(1,'Chocobanano','Bananos cubiertos de chocolate con chispitas de colores y leche condensada',15,50,'public/imgs/Chocobananos.jpeg','Disponible'),
(2,'Flan','Producto creado a base de leche, con sabor a vainilla, con caramelo',25,40,'public/imgs/Flan.jpeg','Disponible'),
(2,'Gelaflan','Postre combinado entre gelatina y flan',25,60,'public/imgs/Gelaflan.jpeg','Disponible'),
(2,'Gelatina de chicle','Postre ligero a base de agua con sabor a chicle',20,30,'public/imgs/Gelatinachicle.jpeg','Disponible'),
(2,'Gelatina con frutas','Postre creado a base de gelatina y frutas con topping de leche condensada y granola',45,60,'public/imgs/Gelatinaconfrutas.jpeg','Disponible'),
(2,'Gelatina de Fresa','Postre ligero a base de agua con sabor a fresa',20,60,'public/imgs/Gelatinafresa.jpeg','Disponible'),
(2,'Gelatina de Mosaico','Postre combinado entre gelatina de fresa y gelatina tres leches con fresa natural',45,60,'public/imgs/GelatinaMosaico.jpeg','Disponible'),
(2,'Gelatina de Naranja','Postre ligero a base de agua con sabor a naranja',20,60,'public/imgs/Gelatinanaranja.jpeg','Disponible'),
(2,'Gelatina de Piña','Postre ligero a base de agua con sabor a piña',20,60,'public/imgs/GelatinaPina.jpeg','Disponible'),
(2,'Gelatina de Uva','Postre ligero a base de agua con sabor a uva',20,60,'public/imgs/GelatinaUva.jpeg','Disponible'),
(3,'Granizado de Café','Elaborado a base de café con leche y chocolate',85,60,'public/imgs/Granizadodecafe.jpeg','Disponible'),
(3,'Granizado de Fresa','Elaborado con fresas naturales y un toque de Hershey de fresa',80,60,'public/imgs/Granizadodefresa.jpeg','Disponible'),
(3,'Granizado de Maracuyá','Elaborado con pulpa natural de maracuyá y leche condensada',80,60,'public/imgs/Granizadodemaracuya.jpeg','Disponible'),
(3,'Granizado de Nance','Elaborado con pulpa natural de nance y leche condensada',80,60,'public/imgs/Granizadodenance.jpeg','Disponible'),
(3,'Mangonada con Gomitas','Elaborada con mango natural, tajín, chamoy y gomitas',110,60,'public/imgs/Mangonadacongomitas.jpeg','Disponible'),
(4,'Piña Loca','Piña rellena con frutas, tajín, chamoy, gomitas y banderilla',160,60,'public/imgs/Pinaloca.jpeg','Disponible'),
(4,'Sandía Loca','Sandía preparada con frutas, tajín, chamoy y gomitas',200,60,'public/imgs/Sandialoca.jpeg','Disponible'),
(4,'Tutti Frutti','Mezcla de frutas naturales con jugo de ponche',50,60,'public/imgs/TuttiFrutti.jpeg','Disponible'),
(1,'Paleta de Frutas','Paleta elaborada con variedades de frutas',15,60,'public/imgs/Paletadefrutas.jpeg','Disponible'),
(1,'Paleta de Coco','Paleta de coco elaborada a base de leche',12,60,'public/imgs/Paletadecoco.png','Disponible');