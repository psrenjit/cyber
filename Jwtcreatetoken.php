<?php
require './vendor/autoload.php';
use \Firebase\JWT\JWT;
class Jwtcreatetoken
{
    

    function jwtcreate($uname){
        $iss="localhost";
        $iat=time();
        $nbf=$iat+10;
        $exp=$iat+3600;
        $aud="myusers";
        $user_data=$uname;
        $secret_key="owt125";
        
        $payload_info=array(
            "iss"=>$iss,
            "iat"=>$iat,
            "nbf"=>$nbf,
            "exp"=>$exp,
            "aud"=>$aud,
            "data"=>$user_data
        );
        $jwt=JWT::encode($payload_info,$secret_key,'HS256');
        return $jwt;
        }
}
