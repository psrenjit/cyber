<?php
include 'header.php';
include 'Token-auth.php';
include 'lconfig.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $pen_number = $data["pen_number"];
    $purpose_of_leave = $data["purpose_of_leave"];    
        try {
            $stmt = $pdo->prepare('select cyberdome.insert_leave(?,?)');
            $result = $stmt->execute(array($pen_number, $purpose_of_leave));
        } catch (Exception $exception) {

        }
        foreach ($data['leave_details'] as $leavedetail) {
            $stmtinsert = $pdo->prepare('select cyberdome.insert_leave_details(?,?,?)');
            $resultinsert = $stmtinsert->execute(
                array($pen_number, $leavedetail['from_date'], $leavedetail['leave_type'])
            );

        }


        if ($result != 0) {
            $insertok = array(
                "status" => true,
                "message" => "Registered successfuly"
            );

        } else {
            $insertok = array(
                "status" => false,
                "message" => "Registration failed"
            );
        }

  


    //header('Content-Type: application/json');
    echo json_encode($insertok);


} else {
    $insertok = array(
        "status" => false,
        "message" => "method not allowed"
    );
    //header('Content-Type: application/json');
    echo json_encode($insertok);

}



