

<html>
<head>
<meta charset="utf-8">
<title>Remove user</title>
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

<h1>REMOVE USER</h1>
<center>
<h4 style='color:red'> Please, enter the username to confirm the action.<br><br>
<table border=0>
<tr>
<th>Username</th><th colspan=2><input type=text name='username' size=15></th>
</tr>

</table><br>
<input type=submit style = 'width:200;background-color:red' onClick="return confirm('Are you sure you want to DELETE the account?')" value='DELETE ACCOUNT' >
</center>

<?php
	
	if(isset($_POST['username'])){
		
		
		$server = mysqli_connect("localhost", "root", "")
                or exit("Connection with MySQL server failed");
			$database = mysqli_select_db($server, "ProjectDatabase") 
                or exit ("Connection with ProjectDatabase database failed");
			mysqli_set_charset($server, "utf8");

		$username=$_POST['username'];
		
		//Check if there exists any account with that username
		$query= "SELECT count(*) from Users where username='$username'";
		$result = mysqli_query($server, $query)
        or exit("Query $query failed");
		$record = mysqli_fetch_row($result);
		
		
		if($record[0]==1){
			$deleteQuery = "DELETE from users where username='$username'";
			$result = mysqli_query($server, $deleteQuery)
			or exit("Query $deleteQuery failed");
			$record = mysqli_fetch_array($result);
			echo "<script>
                alert('User removed.');
                window.location= 'adminMenu.php'
				</script>";
		}
		else{
			"<script>
               alert('There is any account with that username.');
               window.location= 'removeUser.php'
			</script>";
		}
	
	}

?>
<br><br>
<center><a href='adminMenu.php'>Go back</a></center>

</body>
</html>
