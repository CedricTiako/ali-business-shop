<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Récupérer une image de produit spécifique par ID
            $productImage = $db->read('product_images', ['id' => $_GET['id']]);
            if ($productImage) {
                echo json_encode($productImage);
            } else {
                echo json_encode(['status' => 'Product image not found']);
            }
        } else {
            // Récupérer toutes les images de produits
            $productImages = $db->read('product_images');
            echo json_encode($productImages);
        }
        break;

    case 'POST':
        // Créer une nouvelle image de produit
        $data = json_decode(file_get_contents('php://input'), true);

        // Validation des données entrantes
        if (isset($data['product_id']) && isset($data['image_url'])) {
            if ($db->create('product_images', $data)) {
                echo json_encode(['status' => 'Product image created']);
            } else {
                echo json_encode(['status' => 'Error creating product image']);
            }
        } else {
            echo json_encode(['status' => 'Missing required fields']);
        }
        break;

    case 'PUT':
        // Mettre à jour une image de produit existante
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Validation des données entrantes
            if (isset($data['product_id']) || isset($data['image_url']) || isset($data['thumbnail_url'])) {
                if ($db->update('product_images', $data, ['id' => $id])) {
                    echo json_encode(['status' => 'Product image updated']);
                } else {
                    echo json_encode(['status' => 'Error updating product image']);
                }
            } else {
                echo json_encode(['status' => 'No fields to update']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    case 'DELETE':
        // Supprimer une image de produit
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->delete('product_images', ['id' => $id])) {
                echo json_encode(['status' => 'Product image deleted']);
            } else {
                echo json_encode(['status' => 'Error deleting product image']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
