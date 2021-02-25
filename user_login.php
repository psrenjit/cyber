<?php
include 'header.php';
require "Jwtcreatetoken.php";
include 'lconfig.php';
include 'validation.php';
$count = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$flag=0;
    //include 'config.php';
    $data = json_decode(file_get_contents('php://input'), true);
    $uname = $data["userName"];
    $pass = $data["password"];
    //$Designation = $_REQUEST["Designation"];
    //$devicId = $_REQUEST["ipaddress"];
    if(!is_numeric($uname)){
        exit;
    }
    try
    {
        $sql='call cyberdome.userlogin(?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            $uname
        ));
        $user = $stmt->fetchAll(\PDO::FETCH_ASSOC);
           //$user = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        if ($count > 0)
        {
            foreach($user as $row)
            {
            if (password_verify($pass, $row['password']))
            {
                    $flag = 1;
                    $name = $row['user_name'];
                    $penNumber = $row['pen_number'];
                    $userType = $row['id'];
                    $Designation=$row['designation'];
                    $station = $row['station_name'];
                    $subdivision = $row['subdivision_name'];
                    $availableLeave = $row['cl_available'];


                $leave_details=leaveDetails($penNumber);
                $userdetails = array(
                    'name'=>$name ,
                    'penNumber'=>$penNumber,
                    'station'=>$station,
                    'userType'=>$userType,
                    'designation'=>$Designation,
                    'subdivision'=>$subdivision,
                    'availableLeave'=>$availableLeave,
                    'leave_details'=>$leave_details
                );
                $age = array(
                    "status" => true,
                    "message" => "Sucess",                   
                    'user'=>$userdetails,
                    "jwt"=>jwtcreate($uname)
                );
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode($age);
			   // insertdeviceId($flag,$uname,$devicId,$Designation );
            }
            else
            {
               
                $age = array(
                    "status" => false,
                    "message" => "invalid password",
                    "uname" => $uname,
                    "user_name"=>"nil",
                    "designation"=>"nil",
                    "jwt"=>"nil"
                );
				 header('Content-Type: application/json');
            echo json_encode($age);
            }
            }
        }
        else
        {
            $age = array(
                "status" => false,
                "message" => "invalid username",
                "uname" => $uname,
                "user_name"=>"nil",
                "designation"=>"nil",
                "jwt"=>"nil"
            );
            header('Content-Type: application/json');
            echo json_encode($age);
        }
    }
    catch(PDOException $e)
    {
        $age = array(
            "status" => false,
            "message" => $e->getmessage(),
            "uname" => $uname,
            "user_name"=>"nil",
            "designation"=>"nil",
            "jwt"=>"nil"
        );
        header('Content-Type: application/json');
        echo json_encode($age);
    }
	
}




function leaveDetails($penNumber){
    include 'lconfig.php';
    $sql1='call cyberdome.my_leave_status(?)';
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute(array($penNumber
    ));
    $result1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
    $users = array();
    foreach($result1 as $row){
        $age = array(
            "ReqId" =>  $row['id'],
            "AppliedDate" => $row['r_datetime'],
            "TypeOfLeave" => $row['leave_type'],
            "LeaveStatus"=>$row['l_status'],
            "dateApplied"=>$row['from_date']
        );
        array_push($users, $age);

    }
    return $users;
}
function insertdeviceId($flag,$uname,$user_name,$station_name,$devicId,$Designation ){

	if($flag==1)
	{
		try{
		 $stmt1=$pdo->prepare('call leave_management.login_details(?,?)');
            $stmt1->execute(array(
                    $uname,$devicId
                ));





                $jwtvalue="jwt";//jwtcreate($uname);
				$age = array(
                    "status" => true,
                    "message" => "sucess",
                    "uname" => $uname,                    
                    "user_name"=>$user_name,
                    "station_subdivision"=>$station_name,
                    "designation"=>$Designation,
                    "jwt"=>$jwtvalue
                );
				header('Content-Type: application/json');
                echo json_encode($age);
		}
		 catch(PDOException $e1)
    {
		$age = array(
            "status" => false,
            "message" => "connection pr",
            "uname" => $uname,
            "user_name"=>"nil",
            "designation"=>"nil",
            "jwt"=>"nil"
        );
        header('Content-Type: application/json');
        echo json_encode($age);
	}
		
	}
}
function jwtcreate($uname)
{
    $obj = new Jwtcreatetoken;
    return $obj->jwtcreate($uname);
}
?>
