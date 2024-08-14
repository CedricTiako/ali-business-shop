<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $size = $db->read('sizes', ['id' => $_GET['id']]);
            if ($size) {
                echo json_encode($size);
            } else {
                echo json_encode(['status' => 'Size not found']);
            }
        } else {
            $sizes = $db->read('sizes');
            echo json_encode($sizes);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        // Validation des données entrantes
        if (isset($data['size_name']) && !empty($data['size_name'])) {
            if ($db->create('sizes', $data)) {
                echo json_encode(['status' => 'Size created']);
            } else {
                echo json_encode(['status' => 'Error creating size']);
            }
        } else {
            echo json_encode(['status' => 'Missing or invalid size data']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Validation des données entrantes
            if (!empty($data)) {
                if ($db->update('sizes', $data, ['id' => $id])) {
                    echo json_encode(['status' => 'Size updated']);
                } else {
                    echo json_encode(['status' => 'Error updating size']);
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
            if ($db->delete('sizes', ['id' => $id])) {
                echo json_encode(['status' => 'Size deleted']);
            } else {
                echo json_encode(['status' => 'Error deleting size']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
