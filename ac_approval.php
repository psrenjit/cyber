<?php
include 'header.php';
//include 'Token-auth.php';
include 'lconfig.php';
$result = 0;
if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    $data = json_decode(file_get_contents('php://input'), true);
    $pen_number = $data["pen_number"];
    $reqid = $data["reqid"];
    $dateapplied = $data["dateapplied"];
    $status = $data["status"];
    $remarks = $data["remarks"];

    $sql = 'select cyberdome.ac_approve(?,?,?,?,?)';
    try {
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute(array(
            $reqid, $pen_number, $remarks, $dateapplied, $status
        ));
    } catch (Exception $ex) {
        $age = array(
            "status" => false,
            "message" => $ex->getMessage()
        );
        http_response_code(401);
        echo json_encode($age);
        exit();
    }
    if ($result == 1) {
        $age = array(
            "status" => true,
            "message" => "updated Sucessfully"
        );
        http_response_code(200);
        echo json_encode($age);
    } else {
        $age = array(
            "status" => false,
            "message" => "update failed"
        );
        http_response_code(203);
        echo json_encode($age);
    }
}
else{
    $age = array(
        "status" => false,
        "message" => "method error"
    );
    http_response_code(405);
    echo json_encode($age);
}