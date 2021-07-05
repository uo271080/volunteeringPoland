
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
<title>Change password</title>
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

<h1>CHANGE PASSWORD</h1>
<center>
<table border=0>
<tr>
<td>Old password</td><td colspan=2><input type=password name='oldPasswordIntroduced' size=15></td>
</tr>
<tr>
<td>New password</td><td colspan=2><input type=password name='newPassword' size=15></td>
</tr>

</table><br><br>
<input type=submit style = 'width:200'  value='Confirm' ><br>

</center>


<?php
	session_start();
	$username = $_SESSION['username'];
	
	$server = mysqli_connect("localhost", "root", "")
                or exit("Connection with MySQL server failed");
	$database = mysqli_select_db($server, "ProjectDatabase") 
                or exit ("Connection with ProjectDatabase database failed");
	mysqli_set_charset($server, "utf8");

	$query = "select password from users where username='$username'";

	$result = mysqli_query($server, $query)
        or exit("Query $query failed");
	$record = mysqli_fetch_array($result);
	
	$oldPassword= $record[0];

	if(isset($_POST['oldPasswordIntroduced']) && isset($_POST['newPassword'])){
		$oldPasswordIntroduced=$_POST['oldPasswordIntroduced'];
		$newPassword=$_POST['newPassword'];
		if($oldPasswordIntroduced==$oldPassword && $newPassword!=$oldPassword){
			$updateQuery = "UPDATE users set password='$newPassword' where username='$username'";
			$result = mysqli_query($server, $query)
			or exit("Query $query failed");
			$record = mysqli_fetch_array($result);
			 echo "<script>
                alert('Password changed correctly');
                window.location= 'mainMenu.php'
				</script>";
		}
		else if($newPassword==$oldPassword){
				sendAlertAndRedirect('New password is the same as the old one','changePassword.php');
		}
		else{
			sendAlertAndRedirect('Old password does not field with the correct one','changePassword.php');

		}
	}

?>
<center>
<a href='mainMenu.php'>Go back to Main Menu</a>
</center>
</body>
</html>
