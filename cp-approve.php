<?php
include 'header.php';
include 'config.php';
$data = json_decode(file_get_contents('php://input'), true);
$pen_number = $data["pen_number"];
$reqid = $data["reqid"];
$dateapplied = $data["dateapplied"];
$status = $data["status"];
$remarks = $data["remarks"];

$sql = 'select leave_management.cp_approve(?,?,?,?,?)';
$stmt = $pdo->prepare($sql);
$result = $stmt->execute(array(
    $reqid, $pen_number, $remarks, $dateapplied, $status
));
if ($result == 1) {
    $age = array(
        "status" => true,
        "message" => "updated Sucessfully"
    );
    header('Content-Type: application/json');
    echo json_encode($age);
} else {
    $age = array(
        "status" => false,
        "message" => "update failed"
    );
    header('Content-Type: application/json');
    echo json_encode($age);
}
