<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $items = json_decode(file_get_contents("php://input"), true);
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo json_encode(['status' => 'error', 'message' => 'User tidak login']);
        exit;
    }

    foreach ($items as $item) {
        $stmt = $conn->prepare("INSERT INTO orders (user_id, product_name, price) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $user_id, $item['name'], $item['price']);
        $stmt->execute();
    }

    echo json_encode(['status' => 'success', 'message' => 'Pesanan disimpan']);
}
?>