<?php
include_once 'bd.php';
$con = BD::oferaConexiune();
$sqlInsertExercitiu = "UPDATE users SET points=points+$1 WHERE username=$2";
$rsInsertExercitiu = pg_query_params($con, $sqlInsertExercitiu, array($_POST["points"], $_POST["username"]));
?>
