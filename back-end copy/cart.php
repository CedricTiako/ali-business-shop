<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $cart = $db->read('cart', ['id' => $_GET['id']]);
            echo json_encode($cart);
        } else {
            $carts = $db->read('cart');
            echo json_encode($carts);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('cart', $data)) {
            echo json_encode(['status' => 'Cart created']);
        } else {
            echo json_encode(['status' => 'Error creating cart']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('cart', $data, ['id' => $id])) {
            echo json_encode(['status' => 'Cart updated']);
        } else {
            echo json_encode(['status' => 'Error updating cart']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('cart', ['id' => $id])) {
            echo json_encode(['status' => 'Cart deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting cart']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
