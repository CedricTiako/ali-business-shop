<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $category = $db->read('categories', ['id' => $_GET['id']]);
            echo json_encode($category);
        } else {
            $categories = $db->read('categories');
            echo json_encode($categories);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('categories', $data)) {
            echo json_encode(['status' => 'Category created']);
        } else {
            echo json_encode(['status' => 'Error creating category']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('categories', $data, ['id' => $id])) {
            echo json_encode(['status' => 'Category updated']);
        } else {
            echo json_encode(['status' => 'Error updating category']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('categories', ['id' => $id])) {
            echo json_encode(['status' => 'Category deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting category']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
