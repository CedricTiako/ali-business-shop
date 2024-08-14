<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $product = $db->read('products', ['id' => $_GET['id']]);
            echo json_encode($product);
        } else {
            $products = $db->read('products');
            echo json_encode($products);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('products', $data)) {
            echo json_encode(['status' => 'Product created']);
        } else {
            echo json_encode(['status' => 'Error creating product']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('products', $data, ['id' => $id])) {
            echo json_encode(['status' => 'Product updated']);
        } else {
            echo json_encode(['status' => 'Error updating product']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('products', ['id' => $id])) {
            echo json_encode(['status' => 'Product deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting product']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
