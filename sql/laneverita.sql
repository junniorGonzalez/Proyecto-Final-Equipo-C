
CREATE DATABASE IF NOT EXISTS laneverita;
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

INSERT INTO usuarios(id_rol,nombre,apellido,correo,password)
VALUES(1,'Administrador','Sistema','admin@laneverita.com','12345678');
