<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Récupérer un panier spécifique par ID
            $cart = $db->read('cart', ['id' => $_GET['id']]);
            if ($cart) {
                echo json_encode($cart);
            } else {
                echo json_encode(['status' => 'Cart not found']);
            }
        } else {
            // Récupérer tous les paniers
            $carts = $db->read('cart');
            echo json_encode($carts);
        }
        break;

    case 'POST':
        // Créer un nouveau panier
        $data = json_decode(file_get_contents('php://input'), true);
        // Validation des données entrantes
        if (isset($data['user_id'])) {
            if ($db->create('cart', $data)) {
                echo json_encode(['status' => 'Cart created']);
            } else {
                echo json_encode(['status' => 'Error creating cart']);
            }
        } else {
            echo json_encode(['status' => 'Missing required fields']);
        }
        break;

    case 'PUT':
        // Mettre à jour un panier existant
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->update('cart', $data, ['id' => $id])) {
                echo json_encode(['status' => 'Cart updated']);
            } else {
                echo json_encode(['status' => 'Error updating cart']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    case 'DELETE':
        // Supprimer un panier
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->delete('cart', ['id' => $id])) {
                echo json_encode(['status' => 'Cart deleted']);
            } else {
                echo json_encode(['status' => 'Error deleting cart']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
