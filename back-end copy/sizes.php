<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $size = $db->read('sizes', ['id' => $_GET['id']]);
            echo json_encode($size);
        } else {
            $sizes = $db->read('sizes');
            echo json_encode($sizes);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('sizes', $data)) {
            echo json_encode(['status' => 'Size created']);
        } else {
            echo json_encode(['status' => 'Error creating size']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('sizes', $data, ['id' => $id])) {
            echo json_encode(['status' => 'Size updated']);
        } else {
            echo json_encode(['status' => 'Error updating size']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('sizes', ['id' => $id])) {
            echo json_encode(['status' => 'Size deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting size']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
