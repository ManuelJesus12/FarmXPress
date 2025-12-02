CREATE DATABASE  farmxpress;
USE  farmxpress;

CREATE TABLE Suscripciones (
    Suscripcion_ID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(255) UNIQUE,
    Precio_Mensual DECIMAL(10,2),
    Duracion_Base INT
);

CREATE TABLE Ventajas (
    Ventaja_ID INT PRIMARY KEY AUTO_INCREMENT,
    Descripcion VARCHAR(255),
    Nombre VARCHAR(255),
    Estado BOOLEAN,
    Suscripcion_ID INT,
    FOREIGN KEY (Suscripcion_ID) REFERENCES Suscripciones(Suscripcion_ID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Categorias (
    Categoria_ID INT PRIMARY KEY AUTO_INCREMENT,
    Descripcion VARCHAR(255),
    Nombre VARCHAR(255) UNIQUE,
    Cat_Padre_ID INT,
    FOREIGN KEY (Cat_Padre_ID) REFERENCES Categorias(Categoria_ID) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE Usuarios (
    Usuario_ID INT PRIMARY KEY AUTO_INCREMENT,
    Email VARCHAR(255) UNIQUE,
    CIF VARCHAR(9) UNIQUE,
    Nombre VARCHAR(255),
    Contraseña VARCHAR(255),
    Telefono VARCHAR(9) UNIQUE,
    Direccion VARCHAR(255),
    Comunidad VARCHAR(255),
    Provincia VARCHAR(255),
    Fecha_Registro DATETIME,
    Estado BOOLEAN,
    Avatar BLOB,
    Tipo ENUM("P","C")
);

CREATE TABLE Proveedores (
    Usuario_ID INT PRIMARY KEY,
    FOREIGN KEY (Usuario_ID) REFERENCES Usuarios(Usuario_ID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Clientes (
    Usuario_ID INT PRIMARY KEY,
    FOREIGN KEY (Usuario_ID) REFERENCES Usuarios(Usuario_ID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Membresias (
    Membresia_ID INT PRIMARY KEY AUTO_INCREMENT,
    Usuario_ID INT,
    Suscripcion_ID INT,
    Fecha_Inicio DATE,
    Fecha_Fin DATE,
    Estado BOOLEAN,
    Mail_Bool BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (Usuario_ID) REFERENCES Usuarios(Usuario_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (Suscripcion_ID) REFERENCES Suscripciones(Suscripcion_ID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Visitas (
    Visita_ID INT PRIMARY KEY AUTO_INCREMENT,
    Ruta VARCHAR(255),
    Fecha_Hora DATETIME,
    Usuario_ID INT,
    FOREIGN KEY (Usuario_ID) REFERENCES Usuarios(Usuario_ID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Productos (
    Producto_ID INT PRIMARY KEY AUTO_INCREMENT,
    Referencia VARCHAR(50) UNIQUE,
    Nombre VARCHAR(255), 
    Descripcion VARCHAR(255), 
    Precio_Mensual DECIMAL(10,2),
    Estado BOOLEAN,
    Usuario_ID INT,
    Categoria_ID INT,
    Imagen BLOB,
    FOREIGN KEY (Usuario_ID) REFERENCES Proveedores(Usuario_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (Categoria_ID) REFERENCES Categorias(Categoria_ID) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE Seguimientos (
    Usuario_ID INT,
    Producto_ID INT,
    PRIMARY KEY (Usuario_ID, Producto_ID),
    FOREIGN KEY (Usuario_ID) REFERENCES Clientes(Usuario_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (Producto_ID) REFERENCES Productos(Producto_ID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Alquileres (
    Alquiler_ID INT PRIMARY KEY AUTO_INCREMENT,
    Precio_Total DECIMAL(10,2),
    Fecha_Inicio DATETIME,
    Fecha_Fin DATETIME,
    Estado BOOLEAN,
    Mail_Bool BOOLEAN DEFAULT TRUE,
    Usuario_ID INT,
    Producto_ID INT,
    FOREIGN KEY (Usuario_ID) REFERENCES Clientes(Usuario_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (Producto_ID) REFERENCES Productos(Producto_ID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Pagos (
    Pago_ID INT PRIMARY KEY AUTO_INCREMENT,
    Fecha_Hora DATETIME,
    Cantidad DECIMAL(10,2),
    Meses_Extra INT,
    Alquiler_ID INT,
    FOREIGN KEY (Alquiler_ID) REFERENCES Alquileres(Alquiler_ID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Reseñas (
    Reseña_ID INT PRIMARY KEY AUTO_INCREMENT,
    Comentario VARCHAR(255), 
    Calificacion INT,
    Fecha_Hora DATETIME,
    Usuario_ID INT,
    Producto_ID INT,
    FOREIGN KEY (Usuario_ID) REFERENCES Clientes(Usuario_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (Producto_ID) REFERENCES Productos(Producto_ID) ON UPDATE CASCADE ON DELETE CASCADE
);
