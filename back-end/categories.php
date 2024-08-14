<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Récupérer une catégorie spécifique par ID
            $category = $db->read('categories', ['id' => $_GET['id']]);
            if ($category) {
                echo json_encode($category);
            } else {
                echo json_encode(['status' => 'Category not found']);
            }
        } else {
            // Récupérer toutes les catégories
            $categories = $db->read('categories');
            echo json_encode($categories);
        }
        break;

    case 'POST':
        // Créer une nouvelle catégorie
        $data = json_decode(file_get_contents('php://input'), true);
        // Validation des données entrantes
        if (isset($data['name']) && !empty($data['name'])) {
            if ($db->create('categories', $data)) {
                echo json_encode(['status' => 'Category created']);
            } else {
                echo json_encode(['status' => 'Error creating category']);
            }
        } else {
            echo json_encode(['status' => 'Missing required fields']);
        }
        break;

    case 'PUT':
        // Mettre à jour une catégorie existante
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->update('categories', $data, ['id' => $id])) {
                echo json_encode(['status' => 'Category updated']);
            } else {
                echo json_encode(['status' => 'Error updating category']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    case 'DELETE':
        // Supprimer une catégorie
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($db->delete('categories', ['id' => $id])) {
                echo json_encode(['status' => 'Category deleted']);
            } else {
                echo json_encode(['status' => 'Error deleting category']);
            }
        } else {
            echo json_encode(['status' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
