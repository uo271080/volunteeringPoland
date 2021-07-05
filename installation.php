<html>
<head>
  <meta charset="utf-8">
  <title>Users database</title>
</head>
<body bgcolor=yellow text="#000FFF">

<?php 
	$server = mysqli_connect("localhost", "root", "")
                or exit("Database server connecting failed");
    mysqli_set_charset($server, "utf8");
	
	$dbCreate = "CREATE DATABASE ProjectDatabase";
	$users = mysqli_query($server, $dbCreate) or exit ("Database was not created");   
	
	$db = mysqli_select_db($server, "ProjectDatabase") 
                or exit ("ProjectDatabase table connecting failed");
				
	$tableUsers = "CREATE TABLE users (
	name VARCHAR(30) NOT NULL,
	surname VARCHAR(30) NOT NULL,
	username CHAR(30) NOT NULL,
	password VARCHAR(30) NOT NULL,
	age int NOT NULL,
	volunteeringID int NULL,
	adminCode varchar(10) NULL
	)";	
    
	$tab = mysqli_query($server, $tableUsers) or exit ("Table was not created due to an error");
	
	$tableVolunteeringInfo = "CREATE TABLE volunteeringInfo (
	country VARCHAR(30) NOT NULL,
	city VARCHAR(30) NOT NULL,
	volunteeringIssue CHAR(30) NOT NULL,
	price VARCHAR(30) NOT NULL,
	neededVolunteers int NOT NULL,
	freePlaces int not NULL,
	volunteeringID int not NULL
	)";	
	
	
 	$tab = mysqli_query($server, $tableVolunteeringInfo) or exit ("Table was not created due to an error");


	$tableReservations  = "CREATE TABLE reservations  (
	username varchar(30) NOT NULL,
	volunteeringID int not NULL
	)";	
	
	$tab = mysqli_query($server, $tableReservations) or exit ("Table was not created due to an error");

	//Inserting some data on vlunteeringInfo table
	$values = "insert into volunteeringinfo	values('Spain','Madrid','Homeless','350','10','5','421')";
	$val = mysqli_query($server, $values) or exit ("Values not inserted");
	 
	$values = "insert into volunteeringinfo	values('Brasil','Ilhabela','Construction','200','5','5','132')";
	$val = mysqli_query($server, $values) or exit ("Values not inserted");
	
	
	mysqli_close($server); 

	echo "Successfull instalation of database";
?>

</body>
</html>
