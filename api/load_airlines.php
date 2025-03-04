<?php


echo "hello";
exit;
require_once 'db.php';
$conn = get_pdo();


$zone = $_POST['zone'];

$sql = "SELECT * FROM airlines WHERE zone = '$zone'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$airlines = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($airlines);
