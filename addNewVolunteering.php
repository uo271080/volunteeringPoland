

<html>
<head>
<meta charset="utf-8">
<title>Add new volunteering</title>
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
<h1>ADD NEW VOLUNTEERING</h1>
<center>
<a href='adminMenu.php'>Go back</a><br>
<?php
	session_start();
	$username = $_SESSION['username'];
	
	
	if(isset($_POST['country']) && isset($_POST['city']) && isset($_POST['volunteeringIssue']) && 
	isset($_POST['price'])&& isset($_POST['neededVolunteers']) && isset($_POST['freePlaces'])
	&& isset($_POST['volunteeringID'])){
		
		

		$country = $_POST['country'];
		$city = $_POST['city'];
		$volunteeringIssue = $_POST['volunteeringIssue'];
		$price = $_POST['price'];
		$neededVolunteers = $_POST['neededVolunteers'];
		$freePlaces = $_POST['freePlaces'];
		$volunteeringID = $_POST['volunteeringID'];
		
		if($country!='' && $city!='' && $volunteeringIssue!='' && $price!='' && $neededVolunteers!='' && $freePlaces!='' 
		&& $volunteeringID!='') {

		$server = mysqli_connect("localhost", "root", "")
                or exit("Connection with MySQL server failed");
		$database = mysqli_select_db($server, "ProjectDatabase") 
                or exit ("Connection with ProjectDatabase database failed");
			mysqli_set_charset($server, "utf8");

				$query = "INSERT INTO volunteeringInfo VALUES('$country','$city','$volunteeringIssue','$price',
				'$neededVolunteers','$freePlaces','$volunteeringID')";

		$result = mysqli_query($server, $query)
			or exit("Query $query failed");
		}
		else{
			"<script>
                alert('You must fill all fields.');
                window.location= 'registration.php'
				</script>";	
		}
	
	}

?>
<table border=0>

<tr>
<td>Country</td><td colspan=2><input type=text name='country' size=15></td>
</tr>
<tr>
<td>City</td><td colspan=2><input type=text name='city' size=15 style='text-align: center'></td>
</tr>
<tr>
<td>Volunteering Issue</td><td colspan=2><input type=text name='volunteeringIssue' size=15 style='text-align: center'></td>
</tr>
<tr>
<td>Price</td><td colspan=2><input type=number name='price' size=15 min= '0' style='text-align: center'></td>
</tr>
<tr>
<td>Needed volunteers</td><td colspan=2><input type=number name='neededVolunteers' min='1' size=15 style='text-align: center'></td>
</tr>
<tr>
<td>Free places</td><td colspan=2><input type=number name='freePlaces' min='0' size=15 style='text-align: center'></td>
</tr>
<tr>
<td>Volunteering ID</td><td colspan=2><input type=text name='volunteeringID' size=15 style='text-align: center'></td>
</tr>
<td colspan=3 style='background-color:#C6E8FF'><input type=submit value='Confirm' style='width:100%'></td>
</tr>
</table>
<br>
</center>
</body>
</html>