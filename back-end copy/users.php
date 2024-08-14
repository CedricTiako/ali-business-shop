<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $user = $db->read('users', ['id' => $_GET['id']]);
            echo json_encode($user);
        } else {
            $users = $db->read('users');
            echo json_encode($users);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('users', $data)) {
            echo json_encode(['status' => 'User created']);
        } else {
            echo json_encode(['status' => 'Error creating user']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('users', $data, ['id' => $id])) {
            echo json_encode(['status' => 'User updated']);
        } else {
            echo json_encode(['status' => 'Error updating user']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('users', ['id' => $id])) {
            echo json_encode(['status' => 'User deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting user']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
