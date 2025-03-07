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
echo json_encode(update_gate_check($data));
exit;

function update_gate_check($data)
{

    $conn = get_pdo();
    $gate_id  = $data->gate_id;
    $gate_check  = $data->gate_check;
    var_dump($gate_check);
    $audio_status = $gate_check->audio_status;
    $video_status = $gate_check->video_status;
    $first_flight_verified = $gate_check->first_flight_verified;
    $airline_id = $gate_check->airline_id;
    $sql = "UPDATE gate_checks SET
    audio_status = :audio_status,
    video_status = :video_status,
    first_flight_verified = :first_flight_verified,
    airline_id = :airline_id
    WHERE gate_id = :gate_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':audio_status', $audio_status, PDO::PARAM_STR);
    $stmt->bindParam(':video_status', $video_status, PDO::PARAM_STR);
    $stmt->bindParam(':first_flight_verified', $first_flight_verified, PDO::PARAM_STR);
    $stmt->bindParam(':gate_id', $gate_id, PDO::PARAM_INT);
    $stmt->bindParam(':airline_id', $airline_id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return ['success' => true];
    } else {
        return ['success' => false];
    }
}
