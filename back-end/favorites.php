<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['commande_id'])) {
            // Récupérer les détails d'une commande spécifique
            $details = $db->read('details_commande', ['commande_id' => $_GET['commande_id']]);
            echo json_encode($details);
        } else {
            echo json_encode(['status' => 'Commande ID required']);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('details_commande', $data)) {
            echo json_encode(['status' => 'Order detail added']);
        } else {
            echo json_encode(['status' => 'Error adding order detail']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('details_commande', $data, ['id' => $id])) {
            echo json_encode(['status' => 'Order detail updated']);
        } else {
            echo json_encode(['status' => 'Error updating order detail']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('details_commande', ['id' => $id])) {
            echo json_encode(['status' => 'Order detail deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting order detail']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
