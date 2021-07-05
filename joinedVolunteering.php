

<html>
<head>
<meta charset="utf-8">
<title>Joined volunteering</title>
<style>
	th {
		border: 1px solid black;
		background-color:#0071BD;
		color:white;
	}
	td{
		background-color:#80B9E0;
	}
	h1{
		text-align:center;
	}
	tr{
		text-align:center;
		width:250;
	}
</style>
</head>
<body background='sky_background.jpg'>
<form method='POST' action=''>
<center>
<h1>JOINED VOLUNTEERING</h1>

<a href='mainMenu.php'>Go back</a><br><br>
<?php
	session_start();
	$username = $_SESSION['username'];
	$server = mysqli_connect("localhost", "root", "")
                or exit("Connection with MySQL server failed");
	$database = mysqli_select_db($server, "ProjectDatabase") 
                or exit ("Connection with ProjectDatabase database failed");
	mysqli_set_charset($server, "utf8");

	$query = "SELECT * from volunteeringInfo where volunteeringID IN
	(select volunteeringID from reservations where username='$username')";
	
	$result = mysqli_query($server, $query)
        or exit("Query $query failed");
	
	while($record = mysqli_fetch_row($result)) {           
        echo "<br><table><tr><th>Country</th><th>City</th><th>Volunteering Issue</th><th>Price</th><th>Needed Volunteers</th><th>Free places
		</th><th>Volunteering ID</th></tr> ";
		echo "<tr>";
        foreach($record as $fieldName=>$field) {
			echo "<td> $field </td>";
		}
        echo "</tr></table><br>";

		echo "<br>";
	}
	
	

?>


<?php

	//If button is pressed
	if(isset($_POST['joinBtn'])){
		//update volunteeringInfo database subtracting one unit on free places 
		//add a new row on reservations table 
		$insertQuery = "insert into reservations values('$username','$volunteeringID') WHERE NOT
		EXISTS(SELECT 1 FROM reservations WHERE username = '$username' and volunteeringID='$volunteeringID'";
		$val = mysqli_query($server, $insertQuery) or exit("You already joined this volunteering");
		
		//$queryUpdate = "UPDATE volunteeringInfo SET freePlaces = freePlaces-1;"
		//mysqli_query($server, $queryUpdate);
	}

?>

</center>
</body>
</html>
