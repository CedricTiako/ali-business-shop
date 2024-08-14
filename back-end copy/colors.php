<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $color = $db->read('colors', ['id' => $_GET['id']]);
            echo json_encode($color);
        } else {
            $colors = $db->read('colors');
            echo json_encode($colors);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('colors', $data)) {
            echo json_encode(['status' => 'Color created']);
        } else {
            echo json_encode(['status' => 'Error creating color']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('colors', $data, ['id' => $id])) {
            echo json_encode(['status' => 'Color updated']);
        } else {
            echo json_encode(['status' => 'Error updating color']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('colors', ['id' => $id])) {
            echo json_encode(['status' => 'Color deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting color']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
