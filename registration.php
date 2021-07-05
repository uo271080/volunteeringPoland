

<html>
<head>
  <meta charset="utf-8">
  <title>Registration</title>
  <style>
	body { background-color: teal; color: #FFFFFF; }
	input[type="text"] { text-align: center; }
	p{
		text-align:center;
		color:black;
	}
  </style>
</head>

<body  background='sky_background.jpg'>
<br><center>

<?php
	
	if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['username']) && isset($_POST['password']) ) {
		$server = mysqli_connect("localhost", "root", "")
                or exit("Database server connecting failed");	
		$db = mysqli_select_db($server, "ProjectDatabase") 
                or exit ("ProjectDatabase table connecting failed");
				
		
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$age = $_POST['age'];


		//The next lines will check if the admin code field has been written
		$isAdmin = false;
		if($_POST['adminCode']!=''){
			$isAdmin=true;
			$adminCode= $_POST['adminCode'];
		}
		
		//I need to check if the given admin code is one of the correct ones.
		$adminLoginOK = false;
		if($isAdmin){
			//Open the file containing the admin codes
			$adminCodesFile = fopen("adminCodes.txt","r")
			or exit("Problem with opening the admin codes file.");
			//Read every line checking per iteration if the login has gone ok
			
			$count = 0;
			while(1){
				$code = fgets($adminCodesFile);
				echo "Iteracion ".$count;
				echo "Valor codigo file --> ".$code;
				echo "Valor codigo dado --> ".$adminCode;
				if(strcmp($code,$adminCode)){
					$adminLoginOK =true;
					echo "admin ok";
					break;
				}
				if(feof($adminCodesFile)) break;
			}
			fclose($adminCodesFile);
		}
		
		
		if($name!='' && $surname!='' && $username!='' && $password!='' ) { //all fields filled
			if(!$isAdmin){
				$query = "INSERT INTO USERS VALUES('$name','$surname','$username','$password','$age','NULL','NULL')";
				$user = mysqli_query($server, $query) or exit ("An error ocurred");   
				header("Location:"."login.php"); 
			}
			else{
				echo "aqui";
				echo $adminLoginOK;
				if($adminLoginOK){
					echo "aca";
					$query = "INSERT INTO USERS VALUES('$name','$surname','$username','$password','$age','NULL','$adminCode')";
					$user = mysqli_query($server, $query) or exit ("An error ocurred");   
					header("Location:"."login.php"); 
				}
				else{
					echo "a3";
					"<script>
					alert('Admin code is not valid. Please try again.');
					window.location= 'registration.php'
					</script>";	
					}
				}
			}	

			
		else{
				"<script>
                alert('You must fill all fields.');
                window.location= 'registration.php'
				</script>";			

		
			}
		
		
		

		


	}
		
	
	else { // the form is generated only if data hasn't send yet 
?>

<form method=POST action=''>
<h1> REGISTRATION </h1>
	<p>* -> Mandatory fields</p>
<table border = 0>
<tr>
	<td >Name *</td>
<td colspan = 2><input type=text name='name' size=15></td>
	</tr>
	<tr>
	<td>Surname * </td>
	<td colspan = 2><input type=text name='surname' size=15 style='text-align:
		cent	er'> </td>
	</tr>
	<tr>
	<td>Username * </td> 
	<td colspan = 2><input type=text name='username' size=15 style='text-align:
		center'> </td>
	</tr>
	<tr>
	<td>Password *</td> <td colspan = 2><input type=password name='password' size=15 width='50%' > </td>
	</tr>
	
	<tr>
	<td>Admin code</td> <td colspan = 2><input type=text name='adminCode' size=15 > </td>
	</tr>
	<tr>
	<td>Age *</td> <td colspan = 2><input type=number name='age' min="18" size=15 > </td>
	</tr>
</table>	<br>
<input type=submit style = 'width:200' onclick='login.php' value='Register' ><br><br>

</tr>

</table>
<a href='login.php'>Go back</a>

</form>

<?php } // end of else ?>

</center>
</body>
</html>
