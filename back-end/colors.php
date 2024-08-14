<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Récupérer une couleur spécifique par ID
            $color = $db->read('colors', ['id' => $_GET['id']]);
            if ($color) {
                echo json_encode($color);
            } else {
                echo json_encode(['status' => 'Color not found']);
            }
        } else {
            // Récupérer toutes les couleurs
            $colors = $db->read('colors');
            echo json_encode($colors);
        }
        break;

    case 'POST':
        // Créer une nouvelle couleur
        $data = json_decode(file_get_contents('php://input'), true);
        // Validation des données entrantes
        if (isset($data['name']) && !empty($data['name']) && isset($data['hex_value']) && !empty($data['hex_value'])) {
            if ($db->create('colors', $data)) {
                echo json_encode(['status' => 'Color created']);
            } else {
                echo json_encode(['status' => 'Error creating color']);
            }
        } else {
            echo json_encode(['status' => 'Missing required fields']);
        }
        break;

    case 'PUT':
        // Mettre à jour une couleur existante
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->update('colors', $data, ['id' => $id])) {
                echo json_encode(['status' => 'Color updated']);
            } else {
                echo json_encode(['status' => 'Error updating color']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    case 'DELETE':
        // Supprimer une couleur
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->delete('colors', ['id' => $id])) {
                echo json_encode(['status' => 'Color deleted']);
            } else {
                echo json_encode(['status' => 'Error deleting color']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
