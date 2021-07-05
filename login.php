<?php
include('dataBaseCreator.php');
openConnection();
closeConnection();
?>
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
	$fail = 0;
	if(isset($_POST['user']) && isset($_POST['password'])) {
		
		$user = $_POST['user'];
		$pass = $_POST['password'];
		$server = mysqli_connect("localhost", "root", "")
                or exit("Database server connecting failed");
	
		$db = mysqli_select_db($server, "gymManager") 
                or exit ("myDatabase table connecting failed");
	
		mysqli_set_charset($server, "utf8");
		
				
		$query = "SELECT * 
				  FROM user 
				  WHERE user = '$user'
				  AND password = '$pass'";
		
		$result = mysqli_query($server, $query) or exit ("Sorry login failed");   
		
		
		while($record = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$name = $record['name'];
			$surname = $record['surname'];
			$id = $record['id'];
			$type = $record['admin'];
			echo $name." ".$surname." welcome in the system, login successful.";
			$fail = 1;
			
			$file = fopen("user.txt","w");
			fputs($file, "$name\n");
			fputs($file, "$id\n");
			fputs($file, "$type\n");
			fclose($file);

			break;
		}	
		if($fail == 1){
?>			<br><br><br>
			<input type=button value=" Enter App "  onClick="window.location='main.php'">
<?php	}else{
			$fail = 2;
		}
		
		mysqli_free_result($result);
	}
	if($fail==0 or $fail==2){
		if($fail == 2){
			echo ("Sorry login failed. Log in again");
			echo '<br><br><br>';
		}
?>

<form method=POST action=''> 
<table border=0>
<tr>
<td>User</td><td colspan=2><input type=text name='user' size=15></td>
</tr>
<tr>
<td>Password</td><td colspan=2><input type=password name='password' size=15 style='text-align: left'></td>
</tr>
<tr>
<td><input type=button value=" Sign up " style="align:center" onClick="window.location='sign.php'"></td>
<td colspan=2><input type=submit value='Log in' style='width:100%'></td>
</tr>

</table>
</form>

<?php }?>

</center>
</body>
</html>
