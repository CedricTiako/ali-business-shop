<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Récupérer une bannière spécifique par ID
            $banner = $db->read('banners', ['id' => $_GET['id']]);
            if ($banner) {
                echo json_encode($banner);
            } else {
                echo json_encode(['status' => 'Banner not found']);
            }
        } else {
            // Récupérer toutes les bannières
            $banners = $db->read('banners');
            echo json_encode($banners);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        // Validation des données entrantes
        if (isset($data['image_url']) && isset($data['alt_text']) && isset($data['link']) && isset($data['title'])) {
            if ($db->create('banners', $data)) {
                echo json_encode(['status' => 'Banner created']);
            } else {
                echo json_encode(['status' => 'Error creating banner']);
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
                if ($db->update('banners', $data, ['id' => $id])) {
                    echo json_encode(['status' => 'Banner updated']);
                } else {
                    echo json_encode(['status' => 'Error updating banner']);
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
            if ($db->delete('banners', ['id' => $id])) {
                echo json_encode(['status' => 'Banner deleted']);
            } else {
                echo json_encode(['status' => 'Error deleting banner']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
?>
