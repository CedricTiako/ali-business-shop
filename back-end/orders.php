<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Récupérer une commande spécifique
            $order = $db->read('commandes', ['id' => $_GET['id']]);
            echo json_encode($order);
        } elseif (isset($_GET['user_id'])) {
            // Récupérer les commandes d'un utilisateur spécifique
            $orders = $db->read('commandes', ['user_id' => $_GET['user_id']]);
            echo json_encode($orders);
        } else {
            // Récupérer toutes les commandes
            $orders = $db->read('commandes');
            echo json_encode($orders);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('commandes', $data)) {
            echo json_encode(['status' => 'Order created']);
        } else {
            echo json_encode(['status' => 'Error creating order']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('commandes', $data, ['id' => $id])) {
            echo json_encode(['status' => 'Order updated']);
        } else {
            echo json_encode(['status' => 'Error updating order']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('commandes', ['id' => $id])) {
            echo json_encode(['status' => 'Order deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting order']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
