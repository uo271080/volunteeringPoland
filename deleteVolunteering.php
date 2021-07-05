<html>
<head>
<meta charset="utf-8">
<title>DELETE VOLUNTEERING</title>
<style>
	th {
		border: 1px solid black;
		background-color:black;
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

<h1>DELETE VOLUNTEERING</h1>
<center>
<h4 style='color:red'> Please, enter the id of the volunteering to confirm this action.<br><br>
<table border=0>
<tr>
<th>Volunteering ID</th><th colspan=2><input type=text name='volunteeringID' size=15></th>
</tr>

</table><br>
<input type=submit style = 'width:200;background-color:red' onClick="return confirm('Are you sure?')" value='DELETE VOLUNTEERING' >
</center>

<?php
	
	if(isset($_POST['volunteeringID'])){
		
	$volunteeringID= $_POST['volunteeringID'];
	$server = mysqli_connect("localhost", "root", "")
                or exit("Connection with MySQL server failed");
	$database = mysqli_select_db($server, "ProjectDatabase") 
                or exit ("Connection with ProjectDatabase database failed");
	mysqli_set_charset($server, "utf8");

	
	$query = "DELETE from volunteeringInfo where volunteeringID = $volunteeringID";
	$result = mysqli_query($server, $query)
	or exit("Query $query failed");
			 echo "<script>
                alert('Volunteering deleted.');
                window.location= 'adminMenu.php'
				</script>";
	}
?>
<br><br>
<center><a href='adminMenu.php'>Go back</a></center>

</body>
</html>