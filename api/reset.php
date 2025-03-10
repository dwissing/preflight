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
echo json_encode(reset_airline($data));
exit;

function reset_airline($data)
{
    $conn = get_pdo();

    $sql = "DELETE FROM gate_checks
    WHERE airline_id = :airline_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':airline_id', $data->airline_id, PDO::PARAM_INT);


    $stmt->execute();
}
