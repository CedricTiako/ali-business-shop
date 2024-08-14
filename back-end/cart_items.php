<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Récupérer un article de panier spécifique par ID
            $cartItem = $db->read('cart_items', ['id' => $_GET['id']]);
            echo json_encode($cartItem);
        } else {
            // Récupérer tous les articles de panier
            $cartItems = $db->read('cart_items');
            echo json_encode($cartItems);
        }
        break;

    case 'POST':
        // Créer un nouvel article dans le panier
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['cart_id']) && isset($data['product_id']) && isset($data['quantity'])) {
            if ($db->create('cart_items', $data)) {
                echo json_encode(['status' => 'Cart item created']);
            } else {
                echo json_encode(['status' => 'Error creating cart item']);
            }
        } else {
            echo json_encode(['status' => 'Missing required fields']);
        }
        break;

    case 'PUT':
        // Mettre à jour un article existant dans le panier
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->update('cart_items', $data, ['id' => $id])) {
                echo json_encode(['status' => 'Cart item updated']);
            } else {
                echo json_encode(['status' => 'Error updating cart item']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    case 'DELETE':
        // Supprimer un article du panier
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->delete('cart_items', ['id' => $id])) {
                echo json_encode(['status' => 'Cart item deleted']);
            } else {
                echo json_encode(['status' => 'Error deleting cart item']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
