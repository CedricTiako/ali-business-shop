<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Récupérer les produits liés pour un produit spécifique
            $relatedProduct = $db->read('related_products', ['product_id' => $_GET['id']]);
            if ($relatedProduct) {
                echo json_encode($relatedProduct);
            } else {
                echo json_encode(['status' => 'Related product not found']);
            }
        } else {
            // Récupérer tous les produits liés
            $relatedProducts = $db->read('related_products');
            echo json_encode($relatedProducts);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validation des données entrantes
        if (isset($data['product_id']) && isset($data['related_product_id'])) {
            if ($db->create('related_products', $data)) {
                echo json_encode(['status' => 'Related product created']);
            } else {
                echo json_encode(['status' => 'Error creating related product']);
            }
        } else {
            echo json_encode(['status' => 'Missing required fields']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Validation des données entrantes
            if (isset($data['related_product_id'])) {
                if ($db->update('related_products', $data, ['product_id' => $id])) {
                    echo json_encode(['status' => 'Related product updated']);
                } else {
                    echo json_encode(['status' => 'Error updating related product']);
                }
            } else {
                echo json_encode(['status' => 'No fields to update']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->delete('related_products', ['product_id' => $id])) {
                echo json_encode(['status' => 'Related product deleted']);
            } else {
                echo json_encode(['status' => 'Error deleting related product']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
