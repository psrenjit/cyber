<?php
include 'Jwt_checking.php';
$headers = getallheaders();
$jwttoken = $headers['X_Auth_Token'];
$jwtvalue = jwttokencheck1($jwttoken);
if ($jwtvalue) {
} else {
    $age = array(
        "status" => false,
        "message" => "Autharization failed"
    );
    http_response_code(401);
    echo json_encode($age);
    exit;
}
function jwttokencheck1($jwttoken1)
{
    $obj = new Jwt_checking;
    return $obj->jwttokencheck($jwttoken1);
}
?>