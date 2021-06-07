<?php
include_once 'jwt/php-jwt-master/src/jwt_params.php';
include_once 'jwt/php-jwt-master/src/JWT.php';
include_once 'jwt/php-jwt-master/src/ExpiredException.php';
include_once 'jwt/php-jwt-master/src/BeforeValidException.php';
include_once 'jwt/php-jwt-master/src/SignatureInvalidException.php';
session_start();
use \FireBase\JWT\JWT;

if ( isset( $_POST['email'] ) && $_POST['email'] != '' &&
isset( $_POST['psw'] ) && $_POST['psw'] != '' )
 {

    include_once 'user.php';

    $post = '{ "email": "'.$_POST['email'].'" , "password": "'.$_POST['psw'].'"}';
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, 'localhost/dashboard/MEGa-Math-Equation-Game--main/php/autentificare_rest.php' );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $data = curl_exec( $ch );

    $response = ( array )$data;
    if ( !str_contains( $response[0], 'JWT' ) ) {
        header( 'Location: ../html/index.html' );
        setcookie( 'response', 'AutentificareEsuata', time() + ( 10 * 365 * 24 * 60 * 60 ), '/' );
    } else {
        $jwt = json_decode( $response[0] )->JWT;
        $decoded_jwt = JWT::decode( $jwt, JWT_KEY, array( 'HS256' ) );
        $user = $decoded_jwt->data;

        setcookie( 'jwt', $jwt, time() + ( 10 * 365 * 24 * 60 * 60 ), '/' );
        header( 'Location: ../html/index.html' );

        curl_close( $ch );
    }

}
?>