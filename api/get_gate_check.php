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
echo json_encode(get_gate_check($data));
exit;

function get_gate_check($data)
{
    $airline_id = $data->airline_id;
    $gate_number = $data->gate_number;
    $gate_id = $data->gate_id;
    $conn = get_pdo();
    $sql = "SELECT * FROM gate_checks WHERE airline_id = :airline_id AND gate_number = :gate_number";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':airline_id', $airline_id, PDO::PARAM_INT);
    $stmt->bindParam(':gate_number', $gate_number, PDO::PARAM_INT);
    $stmt->execute();
    $gate_check = $stmt->fetch(PDO::FETCH_ASSOC);

    //if gate_check is empty, create a new one
    if (empty($gate_check)) {
        $sql = "INSERT INTO gate_checks (airline_id, gate_number, gate_id) VALUES (:airline_id, :gate_number, :gate_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':airline_id', $airline_id, PDO::PARAM_INT);
        $stmt->bindParam(':gate_number', $gate_number, PDO::PARAM_INT);
        $stmt->bindParam(':gate_id', $gate_id, PDO::PARAM_INT);
        $stmt->execute();
        // get the new gate_check
        $sql = "SELECT * FROM gate_checks WHERE airline_id = :airline_id AND gate_number = :gate_number";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':airline_id', $airline_id, PDO::PARAM_INT);
        $stmt->bindParam(':gate_number', $gate_number, PDO::PARAM_INT);
        $stmt->execute();
        $gate_check = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $gate_check;
}
