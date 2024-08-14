<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Récupérer des informations supplémentaires spécifiques par ID
            $info = $db->read('additional_information', ['id' => $_GET['id']]);
            echo json_encode($info);
        } else {
            // Récupérer toutes les informations supplémentaires
            $infos = $db->read('additional_information');
            echo json_encode($infos);
        }
        break;

    case 'POST':
        // Créer une nouvelle entrée d'information supplémentaire
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['product_id']) && isset($data['info_key']) && isset($data['info_value'])) {
            if ($db->create('additional_information', $data)) {
                echo json_encode(['status' => 'Additional information created']);
            } else {
                echo json_encode(['status' => 'Error creating additional information']);
            }
        } else {
            echo json_encode(['status' => 'Missing required fields']);
        }
        break;

    case 'PUT':
        // Mettre à jour une entrée existante d'information supplémentaire
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->update('additional_information', $data, ['id' => $id])) {
                echo json_encode(['status' => 'Additional information updated']);
            } else {
                echo json_encode(['status' => 'Error updating additional information']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    case 'DELETE':
        // Supprimer une entrée d'information supplémentaire
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->delete('additional_information', ['id' => $id])) {
                echo json_encode(['status' => 'Additional information deleted']);
            } else {
                echo json_encode(['status' => 'Error deleting additional information']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
