<?php

function openConnection(){
	global $connection;
	$server = "127.0.0.1";
	$user = "root";
	$password = "";
	$dbaseName = "gymManager";

	$connection = mysqli_connect($server, $user, $password) or exit("Server connection failed");				
	if(!mysqli_select_db($connection, $dbaseName)) {
		// database doesn't exist
		if(mysqli_errno($connection) == 1049) {
			createDatabase();
			mysqli_select_db($connection, $dbaseName);
			createTables();
			insertTestData();
		}
		else echo("Database $dbaseName selection failed<br>");
	}
	mysqli_set_charset($connection, "utf8");	
}

function closeConnection(){
	global $connection;
	mysqli_close($connection);
}

function createDatabase() {
	$connection = mysqli_connect("127.0.0.1", "root", "") or exit("Server connection failed");
	$dbaseName = 'gymManager';
	
	//echo "Creating of database '$dbaseName' ... <br>";
	mysqli_query($connection, "CREATE DATABASE `$dbaseName` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;") 
	or exit("Creating database failed");
}

function createTables() {
	global $connection;

	$query = 	"create table sports " .
				"(id int NOT NULL AUTO_INCREMENT ," .
				"name varchar(32), " .	
				"details varchar(200), PRIMARY KEY (`id`))";
	mysqli_query($connection, $query) or exit("Query $query failed");
	
	$query = 	"create table user " .
				"(id int NOT NULL AUTO_INCREMENT ," .
				"user varchar(32), " .
				"name varchar(32), " .	
				"surname varchar(32), " .
				"password varchar(32), " .
				"admin int, " .
				"PRIMARY KEY (`id`))";
	mysqli_query($connection, $query) or exit("Query $query failed");
	
	$query = 	"create table groups " .
				"(id int NOT NULL AUTO_INCREMENT ," .
				"sportID int NOT NULL, " .	
				"participants int, " .
				"weekDay int, " .
				"PRIMARY KEY (`id`))";
	mysqli_query($connection, $query) or exit("Query $query failed");
	
	$query = 	"create table partOf " .
				"(userID int  NOT NULL, " .
				"sportID int  NOT NULL, " .	
				"groupID int  NOT NULL, " .	
				"PRIMARY KEY (`userID`, `sportID`, `groupID`)" .
				")";
	mysqli_query($connection, $query) or exit("Query $query failed");
	
}

function insertTestData() {
	global $connection;
	$queries = array("insert into sports values(null, 'Pilates', 'Practise with pilates');",
					 "insert into sports values(null, 'Yoga', 'Relax with yoga');",
				     "insert into sports values(null, 'Boxing', 'Some boxing man');",
					 "insert into sports values(null, 'TRX', 'Move your body');");	
	foreach($queries as $query)
		mysqli_query($connection, $query) or exit("Query $query failed");
	
	$queries = array("insert into user values(null, 'david07', 'David', 'Alvarez', 'ddaavv', 0);",
					 "insert into user values(null, 'angelita', 'Angela', 'Garcia', 'angela1', 1);",
					 "insert into user values(null, '00pablo', 'Pablo', 'Lopez', 'palo', 1);",
					 "insert into user values(null, 'monez', 'Monica', 'Perez', 'permon', 1);");
	foreach($queries as $query)				 
		mysqli_query($connection, $query) or exit("Query $query failed");
	
	$queries = array("insert into groups values(null, 1, 5, 1);",
				     "insert into groups values(null, 2, 10, 2);",
					 "insert into groups values(null, 3, 8, 5);",
					 "insert into groups values(null, 4, 10, 3);");			   
	foreach($queries as $query)				 
		mysqli_query($connection, $query) or exit("Query $query failed");
		
	$queries = array("insert into partOf values(1, 1, 1);",
				     "insert into partOf values(1, 3, 3);",
					 "insert into partOf values(4, 3, 3);",
					 "insert into partOf values(3, 4, 4);",
					 "insert into partOf values(2, 3, 3);",
					 "insert into partOf values(4, 1, 1);",
					 "insert into partOf values(2, 2, 2);");			   
	foreach($queries as $query)				 
		mysqli_query($connection, $query) or exit("Query $query failed");
}

openConnection();
closeConnection();
?>