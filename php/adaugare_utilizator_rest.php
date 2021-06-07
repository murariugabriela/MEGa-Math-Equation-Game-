<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once 'user.php';
$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->username) &&
    !empty($data->password) &&
    !empty($data->email)){
        $u = new User();
        if($u->adaugaUtilizator( $data->username, $data->email, $data->password ) == 1)
        {
            http_response_code(200);
            echo json_encode(array("message" => "User added."));
        }elseif($u->adaugaUtilizator( $data->username, $data->email, $data->password ) == 2)
        {
            http_response_code(400);
            echo json_encode(array("message" => "Username taken. Choose another one"));
        }elseif($u->adaugaUtilizator( $data->username, $data->email, $data->password ) == 3)
        {
            http_response_code(400);
            echo json_encode(array("message" => "Email taken. Choose another one"));
        }
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create user, need more data."));
    }
?>