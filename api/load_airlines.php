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
echo json_encode(load_airlines($data));
exit;

function load_airlines($data)
{
    var_dump($data);
    exit;
    $conn = get_pdo();

    $zone = $data->zone;

    $sql = "SELECT * FROM airlines WHERE zone = :zone";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':zone', $zone, PDO::PARAM_STR);
    $stmt->execute();
    $airlines = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $airlines ?: []; // Ensure it returns an empty array if no results
}
