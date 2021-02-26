<?php
include 'header.php';
include 'Token-auth.php';
include 'lconfig.php';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $data = json_decode(file_get_contents('php://input'), true);
    $uname = $data["pen_number"];
    $users = array();
    try {
        $sql = 'call cyberdome.dcplisting(?)';
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
                $id = $row['id'];
                $penNumber = $row['pen_number'];
                $userName = $row['user_name'];
                $userType = $row['id'];
                $station_name = $row['station_name'];
                $subDivision=$row['subdivision_name'];
                $purpose_of_leave = $row['purpose_of_leave'];
                $cl_available = array('cl' => $row['cl_available']);

                $age = array(

                    'reqId' => $id,
                    "penNumber" => $penNumber,
                    'userName' => $userName,
                    'userType' => $userType,
                    'station_name' => $station_name,
                    'purpose_of_leave' => $purpose_of_leave,
                    '$subDivision'=>$subDivision,
                    'cl_available' => $cl_available
                );
                array_push($users, $age);
            }
            $response = array('Status' => true,
                'user' => $users
            );
            http_response_code(200);
            echo json_encode($response);
        } else {
            $age = array(
                "status" => false,
                "message" => "invalid User Name or Password"
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
else
{
    $age = array(
        "status" => false,
        "message" => "method error"
    );
    http_response_code(405);
    echo json_encode($age);
}