-- ============================================
-- INSERTS PARA GUÍA REPSOL
-- Base de datos: guiarepsol
-- ============================================

USE guiarepsol;

-- ============================================
-- TABLA: categorias
-- ============================================
INSERT INTO categorias (nombre, slug, descripcion, icono, created_at, updated_at) VALUES
('Restaurante', 'restaurante', 'Establecimientos gastronómicos de alta cocina', 'bi-shop', NOW(), NOW()),
('Bar', 'bar', 'Bares y tabernas con oferta gastronómica', 'bi-cup-straw', NOW(), NOW()),
('Cafetería', 'cafeteria', 'Cafeterías y locales de desayunos', 'bi-cup-hot', NOW(), NOW()),
('Gastrobar', 'gastrobar', 'Espacios modernos con propuesta gastronómica innovadora', 'bi-moisture', NOW(), NOW());

-- ============================================
-- TABLA: tipo_comida
-- ============================================
INSERT INTO tipo_comida (nombre, slug, icono, created_at, updated_at) VALUES
('Mediterránea', 'mediterranea', 'bi-sun', NOW(), NOW()),
('Vasca', 'vasca', 'bi-geo-alt', NOW(), NOW()),
('Japonesa', 'japonesa', 'bi-chopsticks', NOW(), NOW()),
('Italiana', 'italiana', 'bi-pizza', NOW(), NOW()),
('Asturiana', 'asturiana', 'bi-mountain', NOW(), NOW()),
('Gallega', 'gallega', 'bi-water', NOW(), NOW()),
('Catalana', 'catalana', 'bi-building', NOW(), NOW()),
('Fusión', 'fusion', 'bi-bezier2', NOW(), NOW()),
('Tradicional española', 'tradicional-espanola', 'bi-flag', NOW(), NOW()),
('Creativa', 'creativa', 'bi-stars', NOW(), NOW());

-- ============================================
-- TABLA: ubicaciones
-- ============================================
INSERT INTO ubicaciones (comunidad_autonoma, provincia, ciudad, codigo_postal, latitud, longitud, created_at, updated_at) VALUES
('Comunidad de Madrid', 'Madrid', 'Madrid', '28001', 40.4168, -3.7038, NOW(), NOW()),
('País Vasco', 'Guipúzcoa', 'San Sebastián', '20001', 43.3183, -1.9812, NOW(), NOW()),
('Cataluña', 'Barcelona', 'Barcelona', '08001', 41.3851, 2.1734, NOW(), NOW()),
('Comunidad Valenciana', 'Valencia', 'Valencia', '46001', 39.4699, -0.3763, NOW(), NOW()),
('Andalucía', 'Málaga', 'Marbella', '29600', 36.5108, -4.8826, NOW(), NOW()),
('Galicia', 'A Coruña', 'Santiago de Compostela', '15701', 42.8782, -8.5448, NOW(), NOW()),
('Asturias', 'Asturias', 'Oviedo', '33001', 43.3603, -5.8448, NOW(), NOW()),
('País Vasco', 'Vizcaya', 'Bilbao', '48001', 43.2630, -2.9350, NOW(), NOW()),
('Castilla y León', 'Valladolid', 'Valladolid', '47001', 41.6520, -4.7245, NOW(), NOW()),
('Andalucía', 'Sevilla', 'Sevilla', '41001', 37.3886, -5.9823, NOW(), NOW());

-- ============================================
-- TABLA: restaurantes
-- ============================================
INSERT INTO restaurantes (nombre, descripcion, categoria_id, ubicacion_id, direccion, telefono, email, web, precio, soles, valoracion_promedio, activo, created_at, updated_at) VALUES
('Tripea', 'Cocina de fusión con toques mediterráneos dirigida por el chef Marcos González. Especialidad en carnes premium y productos de temporada.', 1, 1, 'Calle de Jose Ortega y Gasset, 22', '914356789', 'reservas@tripea.es', 'https://www.tripea.es', 65.00, 1, 4.50, 1, NOW(), NOW()),
('Miga Cana', 'Bar de cocina tradicional española con toques modernos. Famoso por sus arroces y carnes a la brasa.', 2, 1, 'Calle Jorge Juan, 14', '913456712', 'info@migacana.es', 'https://www.migacana.es', 45.00, 0, 4.20, 1, NOW(), NOW()),
('Kitchen 154', 'Restaurante de alta cocina con propuestas innovadoras. Menú degustación con productos locales.', 1, 1, 'Calle de Hermosilla, 154', '912345678', 'reservas@kitchen154.com', 'https://www.kitchen154.com', 85.00, 0, 4.70, 1, NOW(), NOW()),
('Martín Berasategui', 'Tres soles Repsol. Templo de la alta gastronomía vasca con creaciones del maestro Martín Berasategui.', 1, 2, 'Loidi Kalea, 4, Lasarte-Oria', '943366471', 'restaurante@martinberasategui.com', 'https://www.martinberasategui.com', 240.00, 3, 5.00, 1, NOW(), NOW()),
('Akelarre', 'Tres soles Repsol. Cocina vasca de vanguardia con vistas espectaculares al Cantábrico.', 1, 2, 'Paseo Padre Orcolaga, 56', '943311209', 'info@akelarre.net', 'https://www.akelarre.net', 220.00, 3, 4.95, 1, NOW(), NOW()),
('Disfrutar', 'Dos soles Repsol. Propuesta gastronómica innovadora de Oriol Castro, Eduard Xatruch y Mateu Casañas.', 1, 3, 'Carrer de Villarroel, 163', '933486896', 'reservas@disfrutarbarcelona.com', 'https://www.disfrutarbarcelona.com', 195.00, 2, 4.90, 1, NOW(), NOW()),
('Ricard Camarena', 'Dos soles Repsol. Cocina mediterránea contemporánea con producto valenciano de máxima calidad.', 1, 4, 'Carrer del Dr. Sumsi, 4', '963355418', 'info@ricardcamarena.com', 'https://www.ricardcamarena.com', 160.00, 2, 4.85, 1, NOW(), NOW()),
('Skina', 'Dos soles Repsol. Alta cocina en pleno centro de Marbella con propuestas creativas.', 1, 5, 'Calle Aduar, 12', '952765277', 'reservas@restauranteskina.com', 'https://www.restauranteskina.com', 140.00, 2, 4.80, 1, NOW(), NOW()),
('Casa Marcelo', 'Un sol Repsol. Cocina gallega de fusión con influencias asiáticas en el corazón de Santiago.', 1, 6, 'Rúa das Hortas, 1', '981558580', 'info@casamarcelo.net', 'https://www.casamarcelo.net', 75.00, 1, 4.60, 1, NOW(), NOW()),
('Casa Gerardo', 'Un sol Repsol. Cocina asturiana tradicional reinventada con productos de proximidad.', 1, 7, 'Carretera AS-19, Km 9', '985887797', 'reservas@casagerardo.es', 'https://www.casagerardo.es', 90.00, 1, 4.65, 1, NOW(), NOW()),
('Nerua', 'Un sol Repsol. Restaurante del Guggenheim Bilbao con cocina vasca contemporánea.', 1, 8, 'Abandoibarra Etorbidea, 2', '944000430', 'nerua@neruaguggenheimbilbao.com', 'https://www.neruaguggenheimbilbao.com', 110.00, 1, 4.55, 1, NOW(), NOW()),
('La Botica', 'Un sol Repsol. Propuesta gastronómica creativa en Matapozuelos con productos castellanos.', 1, 9, 'Plaza de San Joaquín, 4, Matapozuelos', '983832698', 'info@laboticarestaurante.com', 'https://www.laboticarestaurante.com', 70.00, 1, 4.40, 1, NOW(), NOW()),
('Abantal', 'Un sol Repsol. Cocina andaluza de autor con toques modernos en Sevilla.', 1, 10, 'Calle Alcalde José de la Bandera, 7', '954540000', 'reservas@abantalrestaurante.es', 'https://www.abantalrestaurante.es', 95.00, 1, 4.75, 1, NOW(), NOW()),
('El Club Allard', 'Dos soles Repsol. Alta cocina de vanguardia en un palacete modernista madrileño.', 1, 1, 'Calle de Ferraz, 2', '915590939', 'info@elcluballard.com', 'https://www.elcluballard.com', 175.00, 2, 4.88, 1, NOW(), NOW()),
('DiverXO', 'Tres soles Repsol. El primer y único tres soles de Madrid. Cocina fusión de Dabiz Muñoz.', 1, 1, 'Calle de Padre Damián, 23', '915700766', 'reservas@diverxo.com', 'https://www.diverxo.com', 365.00, 3, 4.98, 1, NOW(), NOW());

-- ============================================
-- TABLA: restaurante_tipo_comida (Relación muchos a muchos)
-- ============================================
INSERT INTO restaurante_tipo_comida (restaurante_id, tipo_comida_id) VALUES
(1, 1), (1, 10), -- Tripea: Mediterránea, Creativa
(2, 9), -- Miga Cana: Tradicional española
(3, 10), (3, 8), -- Kitchen 154: Creativa, Fusión
(4, 2), (4, 10), -- Martín Berasategui: Vasca, Creativa
(5, 2), (5, 10), -- Akelarre: Vasca, Creativa
(6, 7), (6, 10), -- Disfrutar: Catalana, Creativa
(7, 1), (7, 10), -- Ricard Camarena: Mediterránea, Creativa
(8, 1), (8, 10), -- Skina: Mediterránea, Creativa
(9, 6), (9, 8), -- Casa Marcelo: Gallega, Fusión
(10, 5), (10, 9), -- Casa Gerardo: Asturiana, Tradicional
(11, 2), (11, 10), -- Nerua: Vasca, Creativa
(12, 9), (12, 10), -- La Botica: Tradicional, Creativa
(13, 1), (13, 10), -- Abantal: Mediterránea, Creativa
(14, 10), (14, 8), -- El Club Allard: Creativa, Fusión
(15, 8), (15, 3), (15, 10); -- DiverXO: Fusión, Japonesa, Creativa

-- ============================================
-- TABLA: users (Usuarios para valoraciones y reseñas)
-- ============================================
INSERT INTO users (name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
('María García', 'maria.garcia@email.com', NOW(), '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANClx6W4qP2', NULL, NOW(), NOW()),
('Juan Martínez', 'juan.martinez@email.com', NOW(), '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANClx6W4qP2', NULL, NOW(), NOW()),
('Ana López', 'ana.lopez@email.com', NOW(), '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANClx6W4qP2', NULL, NOW(), NOW()),
('Carlos Fernández', 'carlos.fernandez@email.com', NOW(), '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANClx6W4qP2', NULL, NOW(), NOW()),
('Laura Sánchez', 'laura.sanchez@email.com', NOW(), '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANClx6W4qP2', NULL, NOW(), NOW());

-- ============================================
-- TABLA: valoraciones
-- ============================================
INSERT INTO valoraciones (restaurante_id, usuario_id, puntuacion, comentario, created_at, updated_at) VALUES
(1, 1, 5, 'Excelente experiencia gastronómica. Las carnes estaban en su punto perfecto.', NOW(), NOW()),
(1, 2, 4, 'Muy buena cocina, aunque el servicio podría mejorar un poco.', NOW(), NOW()),
(2, 3, 4, 'Relación calidad-precio increíble. Los arroces son espectaculares.', NOW(), NOW()),
(3, 1, 5, 'Uno de los mejores restaurantes de Madrid. Imprescindible el menú degustación.', NOW(), NOW()),
(4, 4, 5, 'Una experiencia inolvidable. Cada plato es una obra de arte.', NOW(), NOW()),
(5, 5, 5, 'Las vistas y la comida son de otro nivel. Absolutamente recomendable.', NOW(), NOW()),
(6, 2, 5, 'Innovación en estado puro. Cada bocado sorprende.', NOW(), NOW()),
(7, 3, 5, 'Ricard Camarena vuelve a demostrar su maestría con el producto valenciano.', NOW(), NOW()),
(8, 4, 5, 'Pequeño pero con una propuesta gastronómica impresionante.', NOW(), NOW()),
(9, 1, 4, 'Fusión gallego-asiática muy interesante. Destaca el pulpo.', NOW(), NOW()),
(10, 5, 5, 'Cocina asturiana de la más alta calidad. La fabada es sublime.', NOW(), NOW());

-- ============================================
-- TABLA: resenas
-- ============================================
INSERT INTO resenas (restaurante_id, usuario_id, puntuacion, comentario, created_at, updated_at) VALUES
(1, 3, 5, 'Hemos celebrado nuestro aniversario aquí y ha sido perfecto. El ambiente es acogedor y la comida extraordinaria.', NOW(), NOW()),
(2, 4, 4, 'Local animado con buena oferta de tapas. Ideal para ir con amigos.', NOW(), NOW()),
(3, 5, 5, 'La creatividad en cada plato es asombrosa. El maridaje de vinos fue excepcional.', NOW(), NOW()),
(4, 1, 5, 'Sin duda merece sus tres soles Repsol. Una experiencia que hay que vivir al menos una vez.', NOW(), NOW()),
(5, 2, 5, 'La puesta de sol desde el restaurante es mágica, y la comida está a la altura.', NOW(), NOW()),
(6, 3, 5, 'Los antiguos chefs de El Bulli siguen revolucionando la gastronomía. Impresionante.', NOW(), NOW()),
(7, 4, 5, 'Cada plato cuenta una historia del Mediterráneo. Producto de primera y ejecución perfecta.', NOW(), NOW()),
(8, 5, 5, 'Marbella tiene en Skina una joya gastronómica. Todo fue excepcional.', NOW(), NOW()),
(15, 1, 5, 'DiverXO es una experiencia única. Dabiz Muñoz lleva la cocina a otra dimensión.', NOW(), NOW()),
(14, 2, 5, 'El palacete es precioso y la comida está a la altura del entorno. Muy recomendable.', NOW(), NOW());

-- ============================================
-- FIN DE INSERTS
-- ============================================

-- Verificar datos insertados
SELECT 'Categorías insertadas:' AS verificacion, COUNT(*) AS total FROM categorias
UNION ALL
SELECT 'Tipos de comida insertados:', COUNT(*) FROM tipo_comida
UNION ALL
SELECT 'Ubicaciones insertadas:', COUNT(*) FROM ubicaciones
UNION ALL
SELECT 'Restaurantes insertados:', COUNT(*) FROM restaurantes
UNION ALL
SELECT 'Usuarios insertados:', COUNT(*) FROM users
UNION ALL
SELECT 'Valoraciones insertadas:', COUNT(*) FROM valoraciones
UNION ALL
SELECT 'Reseñas insertadas:', COUNT(*) FROM resenas
UNION ALL
SELECT 'Relaciones tipo_comida:', COUNT(*) FROM restaurante_tipo_comida;
