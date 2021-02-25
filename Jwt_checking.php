<?php
require './vendor/autoload.php';
use \Firebase\JWT\JWT;

class Jwt_checking{

var $decodeded=0;

function jwttokencheck($jwttokens){
	
$secret_key="owt125";
try{
$deoded=JWT::decode($jwttokens,$secret_key,array('HS256'));
$decodeded=$deoded;

}
catch(Exception $e)
{
$decodeded=0;

}
return $decodeded;
}
}