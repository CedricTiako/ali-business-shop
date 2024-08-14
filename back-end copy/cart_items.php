<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $cartItem = $db->read('cart_items', ['id' => $_GET['id']]);
            echo json_encode($cartItem);
        } else {
            $cartItems = $db->read('cart_items');
            echo json_encode($cartItems);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('cart_items', $data)) {
            echo json_encode(['status' => 'Cart item created']);
        } else {
            echo json_encode(['status' => 'Error creating cart item']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('cart_items', $data, ['id' => $id])) {
            echo json_encode(['status' => 'Cart item updated']);
        } else {
            echo json_encode(['status' => 'Error updating cart item']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('cart_items', ['id' => $id])) {
            echo json_encode(['status' => 'Cart item deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting cart item']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
