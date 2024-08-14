<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $productImage = $db->read('product_images', ['id' => $_GET['id']]);
            echo json_encode($productImage);
        } else {
            $productImages = $db->read('product_images');
            echo json_encode($productImages);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('product_images', $data)) {
            echo json_encode(['status' => 'Product image created']);
        } else {
            echo json_encode(['status' => 'Error creating product image']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('product_images', $data, ['id' => $id])) {
            echo json_encode(['status' => 'Product image updated']);
        } else {
            echo json_encode(['status' => 'Error updating product image']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('product_images', ['id' => $id])) {
            echo json_encode(['status' => 'Product image deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting product image']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
