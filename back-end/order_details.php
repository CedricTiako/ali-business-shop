<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Récupérer les détails de la commande spécifique par ID
            $orderDetail = $db->read('order_details', ['id' => $_GET['id']]);
            if ($orderDetail) {
                echo json_encode($orderDetail);
            } else {
                echo json_encode(['status' => 'Order detail not found']);
            }
        } else {
            // Récupérer tous les détails de commande
            $orderDetails = $db->read('order_details');
            echo json_encode($orderDetails);
        }
        break;

    case 'POST':
        // Créer un nouveau détail de commande
        $data = json_decode(file_get_contents('php://input'), true);
        // Validation des données entrantes
        if (isset($data['order_id']) && isset($data['product_id']) && isset($data['quantity']) && isset($data['unit_price'])) {
            if ($db->create('order_details', $data)) {
                echo json_encode(['status' => 'Order detail created']);
            } else {
                echo json_encode(['status' => 'Error creating order detail']);
            }
        } else {
            echo json_encode(['status' => 'Missing required fields']);
        }
        break;

    case 'PUT':
        // Mettre à jour un détail de commande existant
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->update('order_details', $data, ['id' => $id])) {
                echo json_encode(['status' => 'Order detail updated']);
            } else {
                echo json_encode(['status' => 'Error updating order detail']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    case 'DELETE':
        // Supprimer un détail de commande
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->delete('order_details', ['id' => $id])) {
                echo json_encode(['status' => 'Order detail deleted']);
            } else {
                echo json_encode(['status' => 'Error deleting order detail']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
