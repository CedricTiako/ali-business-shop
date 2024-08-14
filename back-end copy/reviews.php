<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $review = $db->read('reviews', ['id' => $_GET['id']]);
            echo json_encode($review);
        } else {
            $reviews = $db->read('reviews');
            echo json_encode($reviews);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('reviews', $data)) {
            echo json_encode(['status' => 'Review created']);
        } else {
            echo json_encode(['status' => 'Error creating review']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('reviews', $data, ['id' => $id])) {
            echo json_encode(['status' => 'Review updated']);
        } else {
            echo json_encode(['status' => 'Error updating review']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('reviews', ['id' => $id])) {
            echo json_encode(['status' => 'Review deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting review']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
