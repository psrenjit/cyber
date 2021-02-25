<?php
function numericCheck($s)
{
    if(!is_numeric($s)){
        $age = array(
            "status" => false,
            "message" => "enter numeric value",
        );
        http_response_code(203);
        echo json_encode($age);
        exit(1);
    }
    else
    {
        return clean_input($s);
    }
}

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}