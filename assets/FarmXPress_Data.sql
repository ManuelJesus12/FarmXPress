USE FARMXPRESS;

-- 1. Suscripciones
INSERT INTO Suscripciones (Nombre, Precio_Mensual, Duración_Base) VALUES
('Básica', 10.00, 1),
('Pro', 25.00, 3),
('Premium', 40.00, 6);

-- 2. Ventajas
INSERT INTO Ventajas (Descripción, Nombre, Estado, Suscripción_ID) VALUES
('Acceso básico', 'Básico 1', 1, 1),
('Soporte limitado', 'Básico 2', 1, 1),
('Acceso total', 'Pro 1', 1, 2),
('Ofertas exclusivas', 'Pro 2', 1, 2),
('Accesos extra', 'Premium 1', 1, 3),
('Envío gratuito', 'Premium 2', 1, 3);

-- 3. Categorías
INSERT INTO Categorías (Descripción, Nombre, Cat_Padre_ID) VALUES
('Maquinaria agrícola', 'Tractores', NULL),
('Insumos', 'Fertilizantes', NULL),
('Herramientas', 'Palas', NULL),
('Invernaderos', 'Túneles', NULL),
('Tecnología', 'Drones', NULL);

-- 4. Usuarios
INSERT INTO Usuarios (Email, CIF, Nombre, Contraseña, Teléfono, Dirección, Comunidad, Provincia, Fecha_Registro, Estado, Avatar, Tipo) VALUES
('proveedor1@mail.com', 'A00000001', 'Proveedor 1', '$2b$12$IfNkcUevECJyoGYjif3lCeSCbtpB/y4RPhytuoxl7PJWilKZwveeO', '100000001', 'Dir 1', 'Andalucía', "Huelva", NOW(), 1, NULL, 'P'),
('proveedor2@mail.com', 'A00000002', 'Proveedor 2', '$2b$12$gFj0C1RRDIfZCmXuRH83qO5Mubofy1B8oyn57sQxJJ6EYJzXwiBjO', '100000002', 'Dir 2', 'Andalucía', "Huelva", NOW(), 1, NULL, 'P'),
('proveedor3@mail.com', 'A00000003', 'Proveedor 3', '$2b$12$AbibGym6qUoBfao7LpS6ReqeSHIj4rsiZd6KHsgPvDw9vwupwe9m2', '100000003', 'Dir 3', 'Andalucía', "Huelva", NOW(), 1, NULL, 'P'),
('proveedor4@mail.com', 'A00000004', 'Proveedor 4', '$2b$12$IdIcnfvEvxKOICaOROzxuu.7yc54fkFpdQ2ODt2.25KdtXqdf0Qqe', '100000004', 'Dir 4', 'Andalucía', "Huelva", NOW(), 1, NULL, 'P'),
('proveedor5@mail.com', 'A00000005', 'Proveedor 5', '$2b$12$xCSlki4L6uwo.PX3kwQUEe5w2z0asnPE8q7zVGudqKLfViCFo1u4.', '100000005', 'Dir 5', 'Andalucía', "Huelva", NOW(), 1, NULL, 'P'),
('proveedor6@mail.com', 'A00000006', 'Proveedor 6', '$2b$12$kSgYZjQLdDFtRmLYhR9E7eUI5hyEodtMV42OAYDlafzfUFdPvtEJq', '100000006', 'Dir 6', 'Andalucía', "Huelva", NOW(), 1, NULL, 'P'),
('proveedor7@mail.com', 'A00000007', 'Proveedor 7', '$2b$12$UJB0EDAqmo1pMA0o8k7RLOaXKCMcXcq4GmwGIvkBPzMhquQzvQT7u', '100000007', 'Dir 7', 'Andalucía', "Huelva", NOW(), 1, NULL, 'P'),
('proveedor8@mail.com', 'A00000008', 'Proveedor 8', '$2b$12$gWpyUgT2jw.NJzDfUOULxeWjHamTfjcw5pyS8knQcsU0ejOwQFGyy', '100000008', 'Dir 8', 'Andalucía', "Huelva", NOW(), 1, NULL, 'P'),
('proveedor9@mail.com', 'A00000009', 'Proveedor 9', '$2b$12$.MOSnU4F.eMBMfnUm/hKJeM.Pe4qvcF49zdyVg3rXMrqmrpIwo/z.', '100000009', 'Dir 9', 'Andalucía', "Huelva", NOW(), 1, NULL, 'P'),
('proveedor10@mail.com', 'A00000010', 'Proveedor 10', '$2b$12$XybPgPzkBn53OWmlC74G/uxzdm0pWue34xrO3QdoN5mDb58trkvxu', '100000010', 'Dir 10', 'Andalucía', "Huelva", NOW(), 1, NULL, 'P'),
('cliente1@mail.com', 'B00000001', 'Cliente 1', '$2b$12$NqYXvZ.6wZkAuVZOePvkT.IllLqFnyxhXPNFLiP4l6uFp3pqbOnMi', '100000011', 'Dir 11', 'Andalucía', "Huelva", NOW(), 1, NULL, 'C'),
('cliente2@mail.com', 'B00000002', 'Cliente 2', '$2b$12$73IBrIKQSi60dbc.EXRvTOJnA7iVbC8j2mWX1908f0AT6HW/dEBR2', '100000012', 'Dir 12', 'Andalucía', "Huelva", NOW(), 1, NULL, 'C'),
('cliente3@mail.com', 'B00000003', 'Cliente 3', '$2b$12$K/05kEufQk3gUQsK/7SHXu1.NmbT06r8/B/XpL7vwLPtr47dhlXdu', '100000013', 'Dir 13', 'Andalucía', "Huelva", NOW(), 1, NULL, 'C'),
('cliente4@mail.com', 'B00000004', 'Cliente 4', '$2b$12$OFS0.SbiR00Yj9WZIkgOdulwkSJGx.Uwe5nwXMgDxDnwAFCPCNFxi', '100000014', 'Dir 14', 'Andalucía', "Huelva", NOW(), 1, NULL, 'C'),
('cliente5@mail.com', 'B00000005', 'Cliente 5', '$2b$12$4u4r5GIH4GxtlSkrxZjp2.HaEpX5R06W83x79J/Nh8QvHbf.2QB/2', '100000015', 'Dir 15', 'Andalucía', "Huelva", NOW(), 1, NULL, 'C'),
('cliente6@mail.com', 'B00000006', 'Cliente 6', '$2b$12$n333dhRN2o7sfpicAP8R9.8ITh7nbQ1Si3XqCw4pZYBIx1kpBSw5q', '100000016', 'Dir 16', 'Andalucía', "Huelva", NOW(), 1, NULL, 'C'),
('cliente7@mail.com', 'B00000007', 'Cliente 7', '$2b$12$uTgBm4T7QUn3Q66iCB/bQO5EwO90zHhHdNk9NVwRwEqHRYETJ1B8.', '100000017', 'Dir 17', 'Andalucía', "Huelva", NOW(), 1, NULL, 'C'),
('cliente8@mail.com', 'B00000008', 'Cliente 8', '$2b$12$L4qEEopDcPW.TFGof3x4yOyqaNpD5Wjv25FTfqFe5G0LiZgN60tVC', '100000018', 'Dir 18', 'Andalucía', "Huelva", NOW(), 1, NULL, 'C'),
('cliente9@mail.com', 'B00000009', 'Cliente 9', '$2b$12$njhNamJyosKHKWsTbFP/ruLUneZBejhlZywXz12l8FFzVkw6AxoQS', '100000019', 'Dir 19', 'Andalucía', "Huelva", NOW(), 1, NULL, 'C'),
('cliente10@mail.com', 'B00000010', 'Cliente 10', '$2b$12$3P99tAohAWUu52vMrplykeICpBazvo5g.h8gvSNQQTt/wsA6fzvCu', '100000020', 'Dir 20', 'Andalucía', "Huelva", NOW(), 1, NULL, 'C');


-- 5. Proveedores y Clientes
INSERT INTO Proveedores (Usuario_ID) VALUES
(1),(2),(3),(4),(5),(6),(7),(8),(9),(10);
INSERT INTO Clientes (Usuario_ID) VALUES
(11),(12),(13),(14),(15),(16),(17),(18),(19),(20);

-- 6. Membresías
INSERT INTO Membresías (Usuario_ID, Suscripción_ID, Fecha_Inicio, Fecha_Fin, Estado) VALUES
(1, 1, '2023-01-01', '2023-02-01', 1),
(2, 2, '2023-02-01', '2023-05-01', 1),
(3, 3, '2023-03-01', '2023-09-01', 0),
(4, 1, '2023-01-01', '2023-02-01', 1),
(5, 2, '2023-02-01', '2023-05-01', 1),
(6, 3, '2023-03-01', '2023-09-01', 0),
(11, 1, '2023-04-01', '2023-05-01', 1),
(12, 2, '2023-05-01', '2023-08-01', 1),
(13, 3, '2023-06-01', '2023-12-01', 0),
(14, 1, '2023-07-01', '2023-08-01', 1);

-- 7. Visitas
INSERT INTO Visitas (Ruta, Fecha_Hora, Usuario_ID) VALUES
('/inicio', NOW(), 11),
('/producto/1', NOW(), 12),
('/categorias', NOW(), 13),
('/perfil', NOW(), 14),
('/carrito', NOW(), 15),
('/inicio', NOW(), 16),
('/producto/2', NOW(), 17),
('/categorias', NOW(), 18),
('/perfil', NOW(), 19),
('/carrito', NOW(), 20),
('/inicio', NOW(), 11),
('/producto/3', NOW(), 12),
('/categorias', NOW(), 13),
('/perfil', NOW(), 14),
('/carrito', NOW(), 15),
('/inicio', NOW(), 16),
('/producto/4', NOW(), 17),
('/categorias', NOW(), 18),
('/perfil', NOW(), 19),
('/carrito', NOW(), 20);

-- 8. Productos
INSERT INTO Productos (Referencia, Nombre, Descripción, Precio_Mensual, Estado, Usuario_ID, Categoría_ID, Imagen) VALUES
('A0001', 'Tractor 1', 'Potente', 120.00, 1, 1, 1, NULL),
('A0002', 'Tractor 2', 'Moderno', 130.00, 1, 2, 1, NULL),
('A0003', 'Fertilizante 1', 'Ecológico', 20.00, 1, 3, 2, NULL),
('A0004', 'Fertilizante 2', 'Concentrado', 25.00, 1, 4, 2, NULL),
('A0005', 'Pala 1', 'Ligera', 15.00, 1, 5, 3, NULL),
('A0006', 'Pala 2', 'Reforzada', 18.00, 1, 6, 3, NULL),
('A0007', 'Túnel 1', 'Pequeño', 200.00, 1, 7, 4, NULL),
('A0008', 'Túnel 2', 'Grande', 300.00, 1, 8, 4, NULL),
('A0009', 'Dron 1', 'Con cámara', 500.00, 1, 9, 5, NULL),
('A0010', 'Dron 2', 'GPS incluido', 600.00, 1, 10, 5, NULL),
('A0011', 'Tractor 3', 'Viejo pero útil', 80.00, 1, 1, 1, NULL),
('A0012', 'Tractor 4', 'Nuevo modelo', 150.00, 1, 2, 1, NULL),
('A0013', 'Fertilizante 3', 'Orgánico', 22.00, 1, 3, 2, NULL),
('A0014', 'Fertilizante 4', 'Poderoso', 26.00, 1, 4, 2, NULL),
('A0015', 'Pala 3', 'Acero', 16.00, 1, 5, 3, NULL),
('A0016', 'Pala 4', 'Aluminio', 17.00, 1, 6, 3, NULL),
('A0017', 'Túnel 3', 'Mediado', 250.00, 1, 7, 4, NULL),
('A0018', 'Túnel 4', 'Maxi', 350.00, 1, 8, 4, NULL),
('A0019', 'Dron 3', 'Alta definición', 700.00, 1, 9, 5, NULL),
('A0020', 'Dron 4', 'Autónomo', 800.00, 1, 10, 5, NULL);

-- 9. Seguimientos
INSERT INTO Seguimientos (Usuario_ID, Producto_ID) VALUES
(11,1),(12,2),(13,3),(14,4),(15,5),
(16,6),(17,7),(18,8),(19,9),(20,10),
(11,11),(12,12),(13,13),(14,14),(15,15),
(16,16),(17,17),(18,18),(19,19),(20,20);

-- 10. Alquileres
INSERT INTO Alquileres (Precio_Total, Fecha_Inicio, Fecha_Fin, Estado, Usuario_ID, Producto_ID) VALUES
(120.00, '2023-01-01', '2023-01-31', 1, 11, 1),
(130.00, '2023-02-01', '2023-02-28', 1, 12, 2),
(20.00, '2023-03-01', '2023-03-31', 1, 13, 3),
(25.00, '2023-04-01', '2023-04-30', 1, 14, 4),
(15.00, '2023-05-01', '2023-05-31', 1, 15, 5),
(18.00, '2023-06-01', '2023-06-30', 1, 16, 6),
(200.00, '2023-07-01', '2023-07-31', 1, 17, 7),
(300.00, '2023-08-01', '2023-08-31', 1, 18, 8),
(500.00, '2023-09-01', '2023-09-30', 1, 19, 9),
(600.00, '2023-10-01', '2023-10-31', 1, 20, 10),
(80.00, '2023-01-01', '2023-01-31', 1, 11, 11),
(150.00, '2023-02-01', '2023-02-28', 1, 12, 12),
(22.00, '2023-03-01', '2023-03-31', 1, 13, 13),
(26.00, '2023-04-01', '2023-04-30', 1, 14, 14),
(16.00, '2023-05-01', '2023-05-31', 1, 15, 15),
(17.00, '2023-06-01', '2023-06-30', 1, 16, 16),
(250.00, '2023-07-01', '2023-07-31', 1, 17, 17),
(350.00, '2023-08-01', '2023-08-31', 1, 18, 18),
(700.00, '2023-09-01', '2023-09-30', 1, 19, 19),
(800.00, '2023-10-01', '2023-10-31', 1, 20, 20);

-- 11. Pagos
INSERT INTO Pagos (Fecha_Hora, Cantidad, Meses_Extra, Alquiler_ID) VALUES
(NOW(), 120.00, 0, 1),
(NOW(), 130.00, 0, 2),
(NOW(), 20.00, 0, 3),
(NOW(), 25.00, 0, 4),
(NOW(), 15.00, 0, 5),
(NOW(), 18.00, 0, 6),
(NOW(), 200.00, 0, 7),
(NOW(), 300.00, 0, 8),
(NOW(), 500.00, 0, 9),
(NOW(), 600.00, 0, 10),
(NOW(), 80.00, 0, 11),
(NOW(), 150.00, 0, 12),
(NOW(), 22.00, 0, 13),
(NOW(), 26.00, 0, 14),
(NOW(), 16.00, 0, 15),
(NOW(), 17.00, 0, 16),
(NOW(), 250.00, 0, 17),
(NOW(), 350.00, 0, 18),
(NOW(), 700.00, 0, 19),
(NOW(), 800.00, 0, 20);

-- 12. Reseñas
INSERT INTO Reseñas (Comentario, Calificación, Fecha_Hora, Usuario_ID, Producto_ID) VALUES
('Comentario 1', 2, NOW(), 11, 1),
('Comentario 2', 3, NOW(), 12, 2),
('Comentario 3', 4, NOW(), 13, 3),
('Comentario 4', 5, NOW(), 14, 4),
('Comentario 5', 1, NOW(), 15, 5),
('Comentario 6', 2, NOW(), 16, 6),
('Comentario 7', 3, NOW(), 17, 7),
('Comentario 8', 4, NOW(), 18, 8),
('Comentario 9', 5, NOW(), 19, 9),
('Comentario 1', 2, NOW(), 11, 10),
('Comentario 2', 3, NOW(), 12, 11),
('Comentario 3', 4, NOW(), 13, 12),
('Comentario 4', 5, NOW(), 14, 13),
('Comentario 5', 1, NOW(), 15, 14),
('Comentario 6', 2, NOW(), 16, 15),
('Comentario 7', 3, NOW(), 17, 16),
('Comentario 8', 4, NOW(), 18, 17),
('Comentario 9', 5, NOW(), 19, 18),
('Comentario 1', 2, NOW(), 11, 19),
('Comentario 2', 3, NOW(), 12, 20);