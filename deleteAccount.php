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
<title>Delete account</title>
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

<h1>DELETE ACCOUNT</h1>
<center>
<h4 style='color:red'> Please, enter the password to confirm the action.<br><br>
<table border=0>
<tr>
<th>Password</th><th colspan=2><input type=password name='password' size=15></th>
</tr>

</table><br>
<input type=submit style = 'width:200;background-color:red' onClick="return confirm('Are you sure you want to DELETE the account?')" value='DELETE ACCOUNT' >
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
	
	$passwordCheck= $record[0];
	
	if(isset($_POST['password'])){
		$password=$_POST['password'];
		if($password==$passwordCheck){
			$deleteQuery = "DELETE from users where username='$username'";
			$result = mysqli_query($server, $deleteQuery)
			or exit("Query $deleteQuery failed");
			$record = mysqli_fetch_array($result);
			sendAlertAndRedirect('Account deleted','login.php');
		}
		else{
		 
			sendAlertAndRedirect('Password is not correct','deleteAccount.php');
		}
	}

?>
<br><br>
<center><a href='mainMenu.php'>Go back to Main Menu</a></center>

</body>
</html>
