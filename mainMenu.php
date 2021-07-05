
<?php

	function sendAlertAndRedirect($alertMessage,$redirectLocation){
		echo "<script>
                alert('$alertMessage');
                window.location= '$redirectLocation'
				</script>";
	}
	
?>
<html>
<head>
<meta charset="utf-8">
<title>Main Menu</title>
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
	

	

	echo "<h3>".$username." "." welcome to Volunteering World! </h3>";
	echo "<br><br><br>";
	
	echo "<table width='70%' border=1 style='margin:auto'><tr>";
	echo "<th>Main options</th></tr>";
	echo "<tr><td><a href='availableVolunteering.php'>	- See available volunteering</td></tr></a>";
	echo "<tr><td><a href='joinedVolunteering.php'>	- See joined volunteering</td></tr></a></table><br><br><br>";
	
	echo "<table width='70%' border=1 style='margin:auto'><tr>";
	echo "<th>Configure account</th></tr>";
	echo "<tr><td><a href='changePassword.php'>	- Change password</td></tr></a>";
	echo "<tr><td><a href='deleteAccount.php'>	- Delete account</td></tr></table></a><br><br><br>";


	echo "<table width='70%' border=1 style='margin:auto'><tr>";
	echo "<th>Defense task page</th></tr>";
	echo "<tr><td><a href='defenseTaskPage.html'>	- Author info </td></tr></table></a>";

	
	
	

?>
<br><br><center>
<td colspan = 3 style ='text-align:center'><input type=submit style = 'width:200' name='logOut' onClick="return confirm('Are you sure you want to log out?')" value='Log out' ></td>
</center>
<?php
	if(isset($_POST['logOut'])){
		echo 
		sendAlertAndRedirect('See you soon!','login.php');
	}
?>
</body>
</html>
