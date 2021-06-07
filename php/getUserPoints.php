<?php
include_once 'user.php';
$email = $_POST['email'];

$sql = 'select points from users where email = $1';
$result = pg_query_params( BD::oferaConexiune(), $sql, array( $email ) ) or die( "Cannot execute query: $sql\n" );
$row = pg_fetch_row( $result );
// setcookie( 'aici', $row[0], time() + 60, '/' );
echo number_format($row[0], 2, '.', ',');
?>