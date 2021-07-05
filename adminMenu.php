

<html>
<head>
<meta charset="utf-8">
<title>Admin Menu</title>
<style>
	th {
		border: 1px solid black;
		background-color:#0071BD;
		color:white;
	}
	td{
		background-color:#80B9E0;
	}
</style>
</head>
<body background='sky_background.jpg'>
<form method='POST' action=''>



<?php

	session_start();
	//Save the user information session
	$username = $_SESSION['username'];
	

	
	echo "<h3>".$username." "." - ADMIN  </h3>";
	echo "<br><br><br>";
	
	echo "<table width='70%' border=1 style='margin:auto'><tr>";
	echo "<th>Volunteering options</th></tr>";
	echo "<tr><td><a href='addNewVolunteering.php'>	- Add new volunteering </td></tr></a>";
	echo "<tr><td><a href='deleteVolunteering.php'>	- Remove volunteering</td></tr></a></table><br><br><br>";
	
	echo "<table width='70%' border=1 style='margin:auto'><tr>";
	echo "<th>User options</th></tr>";
	echo "<tr><td><a href='removeUser.php'>	- Remove user</td></tr></a>";
	echo "<tr><td><a href='accessLoginReport.php'>	- Access login report</td></tr></table><br><br><br></a>";

	
	echo "<table width='70%' border=1 style='margin:auto'><tr>";
	echo "<th>Defense task page</th></tr>";
	echo "<tr><td><a href='defenseTaskPage.html'>	- Author info </td></tr></table></a>";

	

?>
<br><br><center>
<input type=submit style = 'width:200' name='logOut' onClick="return confirm('Are you sure you want to log out?')" value='Log out' >
</center>
<?php
	if(isset($_POST['logOut'])){
		echo "<script>
                alert('See you soon!.');
                window.location= 'login.php'
				</script>";	
	}
?>
</body>
</html>
