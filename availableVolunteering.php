

<html>
<head>
<meta charset="utf-8">
<title>Available volunteering</title>
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
	table{
		text-align:center;
		
	}
	
</style>
</head>
<body background='sky_background.jpg'>
<form method='POST' action=''>
<h1>LIST OF AVAILABLE VOLUNTEERING</h1>
<center>
<a href='mainMenu.php'>Go back</a>
</center>
<?php
	session_start();
	$username = $_SESSION['username'];
	
	$server = mysqli_connect("localhost", "root", "")
                or exit("Connection with MySQL server failed");
	$database = mysqli_select_db($server, "ProjectDatabase") 
                or exit ("Connection with ProjectDatabase database failed");
	mysqli_set_charset($server, "utf8");

	$query = "select Country,City,VolunteeringIssue,VolunteeringID from volunteeringInfo";

	$result = mysqli_query($server, $query)
        or exit("Query $query failed");
	
	//$arr = mysqli_fetch_row($result);
	
	while($record = mysqli_fetch_row($result)) {           
        echo "<br><center><table><tr><th>Country</th><th>City</th><th>Volunteering Issue</th><th>Volunteering ID</th></tr> ";
		echo "<tr>";
        foreach($record as $fieldName=>$field) {
			echo "<td> $field </td>";
		}
		$stateButton = $record[3];
        echo "</tr></table><br>";
		echo "<td colspan = 3 style ='text-align:right'><input type=submit style = 'width:200' name='$stateButton' value='See details' ></td>";

		echo "<br></center>";
	}
	

	$queryVolunteeringIDs = "SELECT volunteeringID from volunteeringInfo";
	$result = mysqli_query($server, $queryVolunteeringIDs)
        or exit("Query $query failed");
		
	while($record = mysqli_fetch_row($result)) {
	if(isset($_POST["$record[0]"])){
			$_SESSION['clickedVolunteering']=$record[0];
			header("Location:".'volunteeringDetails.php'); 	
	}
	}
		
	

?>
</body>
</html>
