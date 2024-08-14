<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Récupérer les détails d'un produit spécifique par ID
            $product = $db->read('products', ['id' => $_GET['id']]);
            if ($product) {
                echo json_encode($product);
            } else {
                echo json_encode(['status' => 'Product not found']);
            }
        } else {
            // Récupérer tous les produits
            $products = $db->read('products');
            echo json_encode($products);
        }
        break;

    case 'POST':
        // Créer un nouveau produit
        $data = json_decode(file_get_contents('php://input'), true);

        // Validation des données entrantes
        if (isset($data['name']) && isset($data['price'])) {
            if ($db->create('products', $data)) {
                echo json_encode(['status' => 'Product created']);
            } else {
                echo json_encode(['status' => 'Error creating product']);
            }
        } else {
            echo json_encode(['status' => 'Missing required fields']);
        }
        break;

    case 'PUT':
        // Mettre à jour un produit existant
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Validation des données entrantes
            if (isset($data['name']) || isset($data['price'])) {
                if ($db->update('products', $data, ['id' => $id])) {
                    echo json_encode(['status' => 'Product updated']);
                } else {
                    echo json_encode(['status' => 'Error updating product']);
                }
            } else {
                echo json_encode(['status' => 'No fields to update']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    case 'DELETE':
        // Supprimer un produit
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->delete('products', ['id' => $id])) {
                echo json_encode(['status' => 'Product deleted']);
            } else {
                echo json_encode(['status' => 'Error deleting product']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
