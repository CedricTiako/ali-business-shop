<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Récupérer une critique spécifique par ID
            $review = $db->read('reviews', ['id' => $_GET['id']]);
            if ($review) {
                echo json_encode($review);
            } else {
                echo json_encode(['status' => 'Review not found']);
            }
        } else {
            // Récupérer toutes les critiques
            $reviews = $db->read('reviews');
            echo json_encode($reviews);
        }
        break;
 case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        // Validation des données entrantes
        if (isset($data['product_id']) && isset($data['user_id']) && isset($data['rating']) && isset($data['comment'])) {
            if ($db->create('reviews', $data)) {
                echo json_encode(['status' => 'Review created']);
            } else {
                echo json_encode(['status' => 'Error creating review']);
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
            if (!empty($data)) {
                if ($db->update('reviews', $data, ['id' => $id])) {
                    echo json_encode(['status' => 'Review updated']);
                } else {
                    echo json_encode(['status' => 'Error updating review']);
                }
            } else {
                echo json_encode(['status' => 'No data provided for update']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->delete('reviews', ['id' => $id])) {
                echo json_encode(['status' => 'Review deleted']);
            } else {
                echo json_encode(['status' => 'Error deleting review']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
