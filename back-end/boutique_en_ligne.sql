
 --Création de la base de données
CREATE DATABASE IF NOT EXISTS boutique_en_ligne;
USE boutique_en_ligne;

-- Table `users`
-- Contient les informations sur les utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque utilisateur
    name VARCHAR(100) NOT NULL,                  -- Nom de l'utilisateur
    email VARCHAR(100) NOT NULL UNIQUE,          -- Adresse e-mail de l'utilisateur (unique)
    password VARCHAR(255) NOT NULL,              -- Mot de passe de l'utilisateur (haché)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date de création du compte utilisateur
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Date de la dernière mise à jour du compte utilisateur
);

-- Table `categories`
-- Contient les catégories de produits
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque catégorie
    name VARCHAR(100) NOT NULL,                  -- Nom de la catégorie
    parent_id INT DEFAULT NULL,                  -- ID de la catégorie parente (si applicable)
    FOREIGN KEY (parent_id) REFERENCES categories(id) -- Clé étrangère vers la catégorie parente
);

-- Table `products`
-- Contient les informations sur les produits
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque produit
    name VARCHAR(255) NOT NULL,                  -- Nom du produit
    description TEXT,                           -- Description du produit
    price DECIMAL(10, 2) NOT NULL,               -- Prix du produit
    category_id INT,                            -- ID de la catégorie du produit
    image_url VARCHAR(255),                     -- URL de l'image principale du produit
    sku VARCHAR(100),                           -- SKU (Stock Keeping Unit) du produit
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date de création du produit
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Date de la dernière mise à jour
    FOREIGN KEY (category_id) REFERENCES categories(id) -- Clé étrangère vers la catégorie du produit
);

-- Table `product_images`
-- Contient les images supplémentaires des produits
CREATE TABLE IF NOT EXISTS product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque image
    product_id INT,                             -- ID du produit auquel l'image est associée
    image_url VARCHAR(255),                     -- URL de l'image
    thumbnail_url VARCHAR(255),                 -- URL de la vignette de l'image
    FOREIGN KEY (product_id) REFERENCES products(id) -- Clé étrangère vers le produit
);

-- Table `sizes`
-- Contient les tailles disponibles pour les produits
CREATE TABLE IF NOT EXISTS sizes (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque taille
    name VARCHAR(50) NOT NULL                   -- Nom de la taille (par exemple, S, M, L, XL)
);

-- Table `product_sizes`
-- Associe les produits à leurs tailles disponibles
CREATE TABLE IF NOT EXISTS product_sizes (
    product_id INT,                             -- ID du produit
    size_id INT,                                -- ID de la taille
    PRIMARY KEY (product_id, size_id),         -- Clé primaire composée de l'ID du produit et de la taille
    FOREIGN KEY (product_id) REFERENCES products(id), -- Clé étrangère vers le produit
    FOREIGN KEY (size_id) REFERENCES sizes(id) -- Clé étrangère vers la taille
);

-- Table `colors`
-- Contient les couleurs disponibles pour les produits
CREATE TABLE IF NOT EXISTS colors (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque couleur
    name VARCHAR(50) NOT NULL,                   -- Nom de la couleur
    hex_value VARCHAR(7) NOT NULL                -- Valeur hexadécimale de la couleur (par exemple, #FF5733)
);

-- Table `product_colors`
-- Associe les produits à leurs couleurs disponibles
CREATE TABLE IF NOT EXISTS product_colors (
    product_id INT,                             -- ID du produit
    color_id INT,                               -- ID de la couleur
    PRIMARY KEY (product_id, color_id),        -- Clé primaire composée de l'ID du produit et de la couleur
    FOREIGN KEY (product_id) REFERENCES products(id), -- Clé étrangère vers le produit
    FOREIGN KEY (color_id) REFERENCES colors(id) -- Clé étrangère vers la couleur
);

-- Table `reviews`
-- Contient les avis des utilisateurs sur les produits
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque avis
    product_id INT,                             -- ID du produit évalué
    user_id INT,                                -- ID de l'utilisateur qui a laissé l'avis
    rating INT CHECK (rating >= 1 AND rating <= 5), -- Note attribuée au produit (de 1 à 5)
    comment TEXT,                              -- Commentaire de l'avis
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date de création de l'avis
    FOREIGN KEY (product_id) REFERENCES products(id), -- Clé étrangère vers le produit
    FOREIGN KEY (user_id) REFERENCES users(id) -- Clé étrangère vers l'utilisateur
);

-- Table `additional_information`
-- Contient des informations supplémentaires sur les produits
CREATE TABLE IF NOT EXISTS additional_information (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque information supplémentaire
    product_id INT,                             -- ID du produit auquel l'information est associée
    info_key VARCHAR(255),                      -- Clé de l'information supplémentaire (par exemple, 'Matériau', 'Origine')
    info_value TEXT,                           -- Valeur de l'information supplémentaire
    FOREIGN KEY (product_id) REFERENCES products(id) -- Clé étrangère vers le produit
);



-- Table `related_products`
-- Associe les produits à d'autres produits liés (recommandations)
CREATE TABLE IF NOT EXISTS related_products (
    product_id INT,                             -- ID du produit principal
    related_product_id INT,                     -- ID du produit lié
    PRIMARY KEY (product_id, related_product_id), -- Clé primaire composée de l'ID du produit principal et du produit lié
    FOREIGN KEY (product_id) REFERENCES products(id), -- Clé étrangère vers le produit principal
    FOREIGN KEY (related_product_id) REFERENCES products(id) -- Clé étrangère vers le produit lié
);

-- Table `cart`
-- Contient les paniers des utilisateurs
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque panier
    user_id INT,                                -- ID de l'utilisateur auquel le panier appartient
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date de création du panier
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Date de la dernière mise à jour du panier
    FOREIGN KEY (user_id) REFERENCES users(id) -- Clé étrangère vers l'utilisateur
);

-- Table `cart_items`
-- Contient les éléments dans les paniers des utilisateurs
CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque élément de panier
    cart_id INT,                                -- ID du panier auquel l'élément est associé
    product_id INT,                            -- ID du produit dans le panier
    quantity INT DEFAULT 1,                    -- Quantité du produit dans le panier
    FOREIGN KEY (cart_id) REFERENCES cart(id), -- Clé étrangère vers le panier
    FOREIGN KEY (product_id) REFERENCES products(id) -- Clé étrangère vers le produit
);

-- Table `commandes`
-- Contient les informations sur les commandes effectuées par les utilisateurs
CREATE TABLE IF NOT EXISTS commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque commande
    user_id INT,                                -- ID de l'utilisateur qui a passé la commande
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date de la commande
    statut VARCHAR(50) DEFAULT 'en cours',      -- Statut de la commande (par exemple, 'en cours', 'expédiée', 'livrée')
    total DECIMAL(10, 2) NOT NULL,               -- Montant total de la commande
    adresse_livraison VARCHAR(255),             -- Adresse de livraison
    ville_livraison VARCHAR(100),               -- Ville de livraison
    code_postal_livraison VARCHAR(10),          -- Code postal de livraison
    pays_livraison VARCHAR(100),                -- Pays de livraison
    FOREIGN KEY (user_id) REFERENCES users(id) -- Clé étrangère vers l'utilisateur
);

-- Table `details_commande`
-- Contient les détails des commandes (les produits commandés)
CREATE TABLE IF NOT EXISTS details_commande (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque détail de commande
    commande_id INT,                            -- ID de la commande
    product_id INT,                             -- ID du produit commandé
    quantite INT NOT NULL,                      -- Quantité du produit commandé
    prix_unitaire DECIMAL(10, 2) NOT NULL,      -- Prix unitaire du produit au moment de la commande
    FOREIGN KEY (commande_id) REFERENCES commandes(id), -- Clé étrangère vers la commande
    FOREIGN KEY (product_id) REFERENCES products(id) -- Clé étrangère vers le produit
);

-- Table `favoris`
-- Contient les produits favoris des utilisateurs
CREATE TABLE IF NOT EXISTS favoris (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Identifiant unique pour chaque favori
    user_id INT,                                -- ID de l'utilisateur qui a ajouté le produit aux favoris
    product_id INT,                            -- ID du produit ajouté aux favoris
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date d'ajout du produit aux favoris
    FOREIGN KEY (user_id) REFERENCES users(id), -- Clé étrangère vers l'utilisateur
    FOREIGN KEY (product_id) REFERENCES products(id) -- Clé étrangère vers le produit
);

CREATE TABLE banners (
    id SERIAL PRIMARY KEY,          -- Identifiant unique pour chaque bannière
    image_url VARCHAR(255) NOT NULL, -- URL de l'image de la bannière
    alt_text VARCHAR(255) NOT NULL,  -- Texte alternatif pour l'image
    link VARCHAR(255) NOT NULL,      -- Lien de redirection lorsque la bannière est cliquée
    title VARCHAR(255) NOT NULL,     -- Titre de la bannière
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date et heure de création
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Date et heure de dernière mise à jour
);

INSERT INTO banners (image_url, alt_text, link, title) VALUES
    ('images/banner-02.jpg', 'Dresses', '#', 'Dresses'),
    ('images/banner-05.jpg', 'Sunglasses', '#', 'Sunglasses'),
    ('images/banner-03.jpg', 'Watches', '#', 'Watches'),
    ('images/banner-07.jpg', 'Footwear', '#', 'Footwear'),
    ('images/banner-04.jpg', 'Bags', '#', 'Bags'),
    ('images/icons/bg-01.jpg', 'Sign up & get 20% off', '#', 'Sign Up & Get 20% Off');

-- Insertion de données dans la table `users`
INSERT INTO users (name, email, password) VALUES
('Alice Dupont', 'alice.dupont@example.com', 'hashed_password1'),
('Bob Martin', 'bob.martin@example.com', 'hashed_password2'),
('Claire Leroy', 'claire.leroy@example.com', 'hashed_password3'),
('David Rousseau', 'david.rousseau@example.com', 'hashed_password4'),
('Emma Bernard', 'emma.bernard@example.com', 'hashed_password5'),
('François Petit', 'francois.petit@example.com', 'hashed_password6'),
('Giselle Durand', 'giselle.durand@example.com', 'hashed_password7'),
('Hugo Lambert', 'hugo.lambert@example.com', 'hashed_password8');

-- Insertion de données dans la table `categories`
INSERT INTO categories (name, parent_id) VALUES
('Électronique', NULL),
('Vêtements', NULL),
('Smartphones', 1),
('Ordinateurs portables', 1),
('Hommes', 2),
('Femmes', 2),
('Accessoires', NULL),
('Casques', 7),
('Montres', 7);

-- Insertion de données dans la table `products`
INSERT INTO products (name, description, price, category_id, image_url, sku) VALUES
('iPhone 13', 'Le dernier iPhone avec des fonctionnalités avancées', 999.99, 3, 'https://example.com/images/iphone13.jpg', 'SKU12345'),
('MacBook Pro', 'Ordinateur portable puissant pour les professionnels', 1999.99, 4, 'https://example.com/images/macbookpro.jpg', 'SKU12346'),
('T-shirt Homme', 'T-shirt en coton pour hommes', 19.99, 5, 'https://example.com/images/tshirt_homme.jpg', 'SKU12347'),
('Samsung Galaxy S21', 'Smartphone Android haut de gamme', 799.99, 3, 'https://example.com/images/galaxys21.jpg', 'SKU12348'),
('Dell XPS 13', 'Ordinateur portable compact et puissant', 1499.99, 4, 'https://example.com/images/dellxps13.jpg', 'SKU12349'),
('Robe Femme', 'Robe élégante pour femmes', 49.99, 6, 'https://example.com/images/robe_femme.jpg', 'SKU12350'),
('Casque Sony WH-1000XM4', 'Casque à réduction de bruit de haute qualité', 349.99, 8, 'https://example.com/images/sony_wh1000xm4.jpg', 'SKU12351'),
('Montre Apple Watch Series 6', 'Montre intelligente avec suivi de la santé', 399.99, 9, 'https://example.com/images/apple_watch6.jpg', 'SKU12352');

-- Insertion de données dans la table `product_images`
INSERT INTO product_images (product_id, image_url, thumbnail_url) VALUES
(1, 'https://example.com/images/iphone13_side.jpg', 'https://example.com/images/iphone13_thumb.jpg'),
(2, 'https://example.com/images/macbookpro_side.jpg', 'https://example.com/images/macbookpro_thumb.jpg'),
(3, 'https://example.com/images/tshirt_homme_side.jpg', 'https://example.com/images/tshirt_homme_thumb.jpg'),
(4, 'https://example.com/images/galaxys21_side.jpg', 'https://example.com/images/galaxys21_thumb.jpg'),
(5, 'https://example.com/images/dellxps13_side.jpg', 'https://example.com/images/dellxps13_thumb.jpg'),
(6, 'https://example.com/images/robe_femme_side.jpg', 'https://example.com/images/robe_femme_thumb.jpg'),
(7, 'https://example.com/images/sony_wh1000xm4_side.jpg', 'https://example.com/images/sony_wh1000xm4_thumb.jpg'),
(8, 'https://example.com/images/apple_watch6_side.jpg', 'https://example.com/images/apple_watch6_thumb.jpg');

-- Insertion de données dans la table `sizes`
INSERT INTO sizes (name) VALUES
('S'),
('M'),
('L'),
('XL'),
('XXL');

-- Insertion de données dans la table `product_sizes`
INSERT INTO product_sizes (product_id, size_id) VALUES
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5);

-- Insertion de données dans la table `colors`
INSERT INTO colors (name, hex_value) VALUES
('Rouge', '#FF0000'),
('Bleu', '#0000FF'),
('Vert', '#00FF00'),
('Noir', '#000000'),
('Blanc', '#FFFFFF');

-- Insertion de données dans la table `product_colors`
INSERT INTO product_colors (product_id, color_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 1),
(5, 2),
(6, 4),
(6, 5),
(7, 4),
(8, 5);

-- Insertion de données dans la table `reviews`
INSERT INTO reviews (product_id, user_id, rating, comment) VALUES
(1, 1, 5, 'Excellent produit! Très satisfait.'),
(2, 2, 4, 'Très bon produit, mais un peu cher.'),
(3, 3, 3, 'Correct, mais la qualité pourrait être meilleure.'),
(4, 4, 4, 'Super smartphone, mais la batterie pourrait être meilleure.'),
(5, 5, 5, 'Ordinateur portable parfait pour le travail et les loisirs.'),
(6, 6, 4, 'Belle robe, mais la taille était un peu petite.'),
(7, 7, 5, 'Casque avec une qualité sonore incroyable!'),
(8, 8, 5, 'Montre intelligente très pratique et esthétique.');

-- Insertion de données dans la table `additional_information`
INSERT INTO additional_information (product_id, info_key, info_value) VALUES
(1, 'Matériau', 'Aluminium et verre'),
(2, 'Processeur', 'Intel Core i7'),
(3, 'Matériau', 'Coton'),
(4, 'Batterie', '4000mAh'),
(5, 'Processeur', 'Intel Core i5'),
(6, 'Matériau', 'Polyester'),
(7, 'Autonomie', '30 heures'),
(8, 'Étanchéité', 'Oui');

-- Insertion de données dans la table `related_products`
INSERT INTO related_products (product_id, related_product_id) VALUES
(1, 2),
(1, 4),
(2, 1),
(2, 5),
(3, 6),
(4, 1),
(4, 7),
(5, 2),
(6, 3),
(7, 8),
(8, 7);

-- Insertion de données dans la table `cart`
INSERT INTO cart (user_id) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8);

-- Insertion de données dans la table `cart_items`
INSERT INTO cart_items (cart_id, product_id, quantity) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1);

-- Insertion de données dans la table `commandes`
INSERT INTO commandes (user_id, statut, total, adresse_livraison, ville_livraison, code_postal_livraison, pays_livraison) VALUES
(1, 'en cours', 999.99, '123 Rue de Paris', 'Paris', '75001', 'France'),
(2, 'expédiée', 1999.99, '456 Avenue des Champs', 'Lyon', '69002', 'France'),
(3, 'livrée', 39.98, '789 Boulevard Saint-Germain', 'Marseille', '13001', 'France'),
(4, 'en cours', 799.99, '12 Boulevard Haussmann', 'Paris', '75009', 'France'),
(5, 'expédiée', 1499.99, '34 Rue Lafayette', 'Lille', '59000', 'France'),
(6, 'livrée', 49.99, '56 Avenue Victor Hugo', 'Bordeaux', '33000', 'France'),
(7, 'en cours', 349.99, '78 Rue de la République', 'Nantes', '44000', 'France'),
(8, 'expédiée', 399.99, '90 Rue Jean Jaurès', 'Toulouse', '31000', 'France');

-- Insertion de données dans la table `details_commande`
INSERT INTO details_commande (commande_id, product_id, quantite, prix_unitaire) VALUES
(1, 1, 1, 999.99),
(2, 2, 1, 1999.99),
(3, 3, 2, 19.99),
(4, 4, 1, 799.99),
(5, 5, 1, 1499.99),
(6, 6, 1, 49.99),
(7, 7, 1, 349.99),
(8, 8, 1, 399.99);

-- Insertion de données dans la table `favoris`
INSERT INTO favoris (user_id, product_id) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4),
(4, 5),
(5, 6),
(6, 7),
(7, 8),
(8, 1);
