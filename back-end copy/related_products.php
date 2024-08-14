<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $relatedProduct = $db->read('related_products', ['product_id' => $_GET['id']]);
            echo json_encode($relatedProduct);
        } else {
            $relatedProducts = $db->read('related_products');
            echo json_encode($relatedProducts);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('related_products', $data)) {
            echo json_encode(['status' => 'Related product created']);
        } else {
            echo json_encode(['status' => 'Error creating related product']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('related_products', $data, ['product_id' => $id])) {
            echo json_encode(['status' => 'Related product updated']);
        } else {
            echo json_encode(['status' => 'Error updating related product']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('related_products', ['product_id' => $id])) {
            echo json_encode(['status' => 'Related product deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting related product']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
