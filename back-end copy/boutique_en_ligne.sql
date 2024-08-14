-- Création de la base de données
CREATE DATABASE IF NOT EXISTS boutique_en_ligne;
USE boutique_en_ligne;

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
