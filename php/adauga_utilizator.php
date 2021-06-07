<?php
if ( isset( $_POST['email'] ) && $_POST['email'] != '' &&
isset( $_POST['username'] ) && $_POST['username'] != '' &&
isset( $_POST['psw'] ) && $_POST['psw'] != '' &&
isset( $_POST['psw-repeat'] ) && $_POST['psw-repeat'] != '' )
 {
    include_once 'user.php';
    $post = '{ "email": "'.$_POST['email'].'" , "password": "'.$_POST['psw'].'" , "username": "'.$_POST['username'].'"}';
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, 'localhost/dashboard/MEGa-Math-Equation-Game--main/php/adaugare_utilizator_rest.php' );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $data = curl_exec( $ch );

    $response = ( array )$data;
    if ( str_contains( $response[0], 'Email' ) &&  str_contains( $response[0], 'taken' ) ) {
        setcookie( 'response', 'Email', time() + ( 10 * 365 * 24 * 60 * 60 ), '/' );
    } else if ( str_contains( $response[0], 'Username' ) && str_contains( $response[0], 'taken' ) ) {
        setcookie( 'response', 'Username', time() + ( 10 * 365 * 24 * 60 * 60 ), '/' );
    }

}
header( 'Location: ../html/register.html' );

?>