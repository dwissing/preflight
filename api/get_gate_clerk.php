<?php
require_once 'lib/use_db.php';
session_start();
$json = file_get_contents('php://input');
$data = json_decode($json);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

header('Content-Type: application/json');
echo json_encode(get_gate_clerk($data));
exit;

function get_gate_clerk($data)
{
    $conn = get_pdo();

    $random_id = rand(1, 50);
    $sql = "SELECT * FROM gate_clerks WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $random_id, PDO::PARAM_INT);
    $stmt->execute();
    $gate_clerk = $stmt->fetch(PDO::FETCH_ASSOC);

    return $gate_clerk ?: []; // Ensure it returns an empty array if no results
}
