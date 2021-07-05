

<html>
<head>
<meta charset="utf-8">
<title>Volunteering details</title>
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
	h4{
		color:black;
	}
</style>
</head>
<body background='sky_background.jpg'>
<form method='POST' action=''>
<center>
<h1>VOLUNTEERING DETAILS</h1>

<a href='availableVolunteering.php'>Go back</a>
<?php
	session_start();
	$volunteeringID = $_SESSION['clickedVolunteering'];
	$username = $_SESSION['username'];
	$server = mysqli_connect("localhost", "root", "")
                or exit("Connection with MySQL server failed");
	$database = mysqli_select_db($server, "ProjectDatabase") 
                or exit ("Connection with ProjectDatabase database failed");
	mysqli_set_charset($server, "utf8");

	
	$query = "SELECT * from volunteeringInfo where volunteeringID = '$volunteeringID'";
	
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

<td colspan = 3 style ='text-align:center'><input type=submit style = 'width:200' name='joinBtn' onClick="return confirm('Are you sure you want to join?')" value='Join' ></td>

<?php
	$volunteeringID = $_SESSION['clickedVolunteering'];

	if(isset($_POST['joinBtn'])){
		//update volunteeringInfo database subtracting one unit on free places 
		//add a new row on reservations table 
		$querycheck = "SELECT count(*) FROM reservations WHERE username='$username' and volunteeringID='$volunteeringID'";
		$result = mysqli_query($server, $querycheck)
        or exit("Query $query failed");
		$record = mysqli_fetch_row($result);
		if($record[0]==0){
		$insertQuery = "insert into reservations values('$username','$volunteeringID') ";
		$val = mysqli_query($server, $insertQuery) or exit("An error occured");
		echo "<br><br><h4>Successful join!</h4>";
		}
		else{
			echo "<br><br><h4>You already joined this volunteering</h4>";
		}
		//$queryUpdate = "UPDATE volunteeringInfo SET freePlaces = freePlaces-1;"
		//mysqli_query($server, $queryUpdate);
	}

?>

</center>
</body>
</html>
