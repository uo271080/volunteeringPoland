<?php

$file = fopen("user.txt","r");
$name = fgets($file);
$idA = fgets($file);
$type = fgets($file);
fclose($file);

session_start();
$_SESSION['name'] = $name;
$_SESSION['idA'] = $idA;
$_SESSION['type'] = $type;

?>

<html>
<head>
<meta charset="utf-8">
<title>Gym Manager</title>
</head>
<center>

<body bgcolor=red text="#FFFFFF">

<input type=button value=" USERS " onClick="window.location='users.php'">
<br><br>

<input type=button value=" SPORTS " onClick="window.location='sports.php'">
<br><br>

<input type=button value=" SCHEDULE " onClick="window.location='schedule.php'">
<br><br>

<input type=button value=" LOG OUT " style="align:center" onClick="window.location='login.php'">
<hr></center>
</body>
</html>
