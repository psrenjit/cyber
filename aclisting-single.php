<?php
include 'header.php';
include 'Token-auth.php';
include 'lconfig.php';
$uname=0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $uname = $data["reqId"];
    $users = array();
    try {
        $sql = 'call cyberdome.listing_single(?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            $uname
        ));
        $user = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        //$user = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        if ($count > 0) {

            foreach ($user as $row) {

                $flag = 1;
                $slNo = $row['pid'];
                $reqId = $row['id'];
                $dateApplied = $row['from_date'];
                $leaveType = $row['leave_type'];


                $age = array(
                    'slNo' => $slNo,
                    "reqId" => $reqId,
                    'dateApplied' => $dateApplied,
                    'leaveType' => $leaveType
                );
                array_push($users, $age);
            }
            $response = array('Status' => true,
                'leaveDetails' => $users
            );
            http_response_code(200);
            echo json_encode($response);
        } else {
            $age = array(
                "status" => false,
                "message" => "no data present"
            );
            http_response_code(203);
            echo json_encode($age);
        }
    } catch (PDOException $e) {
        $age = array(
            "status" => false,
            "message" => $e->getMessage()
        );
        http_response_code(502);
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