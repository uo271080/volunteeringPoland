<html>
<head>
  <meta charset="utf-8">
  <title>Log in</title>
  <style>
	body { background-color: red; color: #FFFFFF; }
	input[type="text"] { text-align: center; }
  </style>
</head>

<body>
<br><center>

<?php
	if(isset($_POST['user']) && isset($_POST['password']) 
		&& isset($_POST['name']) && isset($_POST['surname'])) {
		
		$user = $_POST['user'];
		$pass = $_POST['password'];
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$admin = $_POST['admin'];
		
		$server = mysqli_connect("localhost", "root", "")
                or exit("Database server connecting failed");
	
		$db = mysqli_select_db($server, "gymManager") 
                or exit ("myDatabase table connecting failed");
	
		mysqli_set_charset($server, "utf8");
		
				
		$query = "INSERT INTO user VALUES (null, '$user', '$name', '$surname', '$pass', '$admin')";		
		$result = mysqli_query($server, $query) or exit ("Sorry $query failed");   
		
		$query = "SELECT id FROM User WHERE user ='$user' and name = '$name'
					and surname = '$surname' and password = '$pass' and admin = '$admin'";		
		$result = mysqli_query($server, $query) or exit ("Sorry $query failed");   
		$record = mysqli_fetch_array($result);
		$idA = $record[0];
		
		
		echo $name." ".$surname." welcome in the system, login successful.";
		$file = fopen("user.txt","w");
		fputs($file, "$name\n");
		fputs($file, "$idA\n");
		fputs($file, "$admin\n");
		fclose($file);
?>		<br><br><br>
		<input type=button value=" Enter App "  onClick="window.location='main.php'">
<?php
		}else{
?>

<form method=POST action=''> 
<table border=0>
<tr>
<td>User</td><td colspan=2><input type=text name='user' size=15></td>
</tr>
<tr>
<td>Name</td><td colspan=2><input type=text name='name' size=15></td>
</tr>
<tr>
<td>Surname</td><td colspan=2><input type=text name='surname' size=15></td>
</tr>
<tr>
<td>Password</td><td colspan=2><input type=password name='password' size=15 style='text-align: left'></td>
</tr>
<tr>
<td>Admin type</td><td colspan=2><input type=number name='admin' min=0 max=1 size=15></td>
</tr>
<tr>
<td><input type=button value=" Cancel " style="align:center" onClick="window.location='login.php'"></td>
<td colspan=3><input type=submit value='Sign up' style='width:100%'></td>
</tr>

</table>
</form>

<?php }?>

</center>
</body>
</html>
