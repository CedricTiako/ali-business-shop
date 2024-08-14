<?php
require 'connect_db.php'; // Assurez-vous que ce chemin est correct

$db = getDB();

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $orderDetail = $db->read('order_details', ['id' => $_GET['id']]);
            echo json_encode($orderDetail);
        } else {
            $orderDetails = $db->read('order_details');
            echo json_encode($orderDetails);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($db->create('order_details', $data)) {
            echo json_encode(['status' => 'Order detail created']);
        } else {
            echo json_encode(['status' => 'Error creating order detail']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if ($db->update('order_details', $data, ['id' => $id])) {
            echo json_encode(['status' => 'Order detail updated']);
        } else {
            echo json_encode(['status' => 'Error updating order detail']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($db->delete('order_details', ['id' => $id])) {
            echo json_encode(['status' => 'Order detail deleted']);
        } else {
            echo json_encode(['status' => 'Error deleting order detail']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request method']);
        break;
}
