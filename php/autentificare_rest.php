<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once 'user.php';

include_once 'jwt/php-jwt-master/src/jwt_params.php';
include_once 'jwt/php-jwt-master/src/JWT.php';
include_once 'jwt/php-jwt-master/src/ExpiredException.php';
include_once 'jwt/php-jwt-master/src/BeforeValidException.php';
include_once 'jwt/php-jwt-master/src/SignatureInvalidException.php';

use \FireBase\JWT\JWT;

$data = json_decode(file_get_contents("php://input"));
if(
    !empty($data->password) &&
    !empty($data->email)){
        $u = new User();
        if($u->logareUtilizator( $data->email, $data->password ) == 1)
        {
            $sql = 'select email, username, points, is_admin from users where email = $1';
            $result = pg_query_params( BD::oferaConexiune(), $sql, array($data->email)) or die("Cannot execute query: $sql\n");
            $row = pg_fetch_row( $result );
            $token = array(
                "iss"=>JWT_ISS,
                "aud"=> JWT_AUD,
                "iat"=> JWT_IAT,
                "exp"=> JWT_EXP,
                "data"=> array(
                    "username"=>$row[1],
                    "email"=>$row[0],
                    "points"=>$row[2],
                    "isAdmin"=>$row[3]
                )
            );
            $jwt = JWT::encode($token, JWT_KEY);
            http_response_code(200);

            // echo json_encode(array("message" => "User successfully logged in."));
            echo json_encode(array("JWT" => $jwt));

        }elseif($u->logareUtilizator( $data->email, $data->password ) == 0)
        {
            http_response_code(400);
            echo json_encode(array("message" => "Combinatie email-parola gresita."));
        }
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Unable to logate user, need more data."));
    }
?>