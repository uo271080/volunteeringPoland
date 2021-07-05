<html>
<head>
  <meta charset="utf-8">
  <title>Log in</title>
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
	table{
		border: black 5px solid;
	}
</style>
</head>
<h1> VOLUNTEERING WORLD</h1>
<body bgcolor="#C6E8FF" background='sky_background.jpg'>
<br><center>

<?php
	
	if(isset($_POST['username']) && isset($_POST['password'])) {
		$server = mysqli_connect("localhost", "root", "")
                or exit("Database server connecting failed");	
		$db = mysqli_select_db($server, "ProjectDatabase") 
                or exit ("ProjectDatabase table connecting failed");
				
		$username = $_POST['username'];
		$password = $_POST['password'];
		$query = "SELECT * from USERS WHERE username='$username' and password='$password'";
		$user = mysqli_query($server, $query) or exit ("An error ocurred");   

		$loginOk=false;
		
		//First I check if username and password matches
		if($record = mysqli_fetch_array($user)){
			$loginOk=true;
		}
		
		//Then I check if it is an admin user
		$isAdmin=false;
		
		if($loginOk && $record[6]!='NULL'){
			$isAdmin=true;
		}
		
		
		//If login has gone well
		if($loginOk){
			//Save the session username
			session_start();
			$_SESSION['username']=$username;
			if(!$isAdmin){
			//Redirect to main menu
			//alert('$record[0]');
			//Create a file with the info of login
			$file = @fopen("loginReport.txt","a");
			fputs($file,"Username: $username - Day: ".date("d")." Month: ".date("m")." Hour: ".date("h").":".date("i")."\n");
			fclose($file);
			header("Location:".'mainMenu.php'); 
			}
			else{
				//Create a file with the info of login
				$file = @fopen("loginReport.txt","a");
				fputs($file,"ADMIN --> Username: $username - Day: ".date("d")." Month: ".date("m")." Hour: ".date("h").":".date("i")."\n");
					fclose($file);
					header("Location:".'adminMenu.php'); 

			}
		}

		//If incorrect login
		else{
			echo "Sorry, login failed. Please try again.";
		}
		
		

		
		
	}
	else { // the form is generated only if data hasn't send yet 
?>

<form method=POST action=''> 
<table border=0>
<tr>
<td>Username</td><td colspan=2><input type=text name='username' size=15></td>
</tr>
<tr>
<td>Password</td><td colspan=2><input type=password name='password' size=15 style='text-align: left'></td>
</tr>

<tr>
<td colspan=3 style='background-color:#C6E8FF'><input type=submit value='Log in' onclick= "window.location='mainMenu.php'" style='width:100%'></td>
</tr>
</table>
<br>
<a href='registration.php'>If you dont have account, please CLICK HERE to register.</a>

</form>

<?php } // end of else ?>

</center>
</body>
</html>
