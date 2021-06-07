<?php
include_once 'user.php';
$user = new User();
$clasament = $user->clasamentUtilizatori();
echo $clasament;
?>