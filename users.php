<?php
session_start();
include('dataBaseCreator.php');

function showUsers(){	
	
	global $connection;

	$query = "select id, name, surname, admin from user";	
	$result = mysqli_query($connection, $query);	
	if(!$result) return;

  	$headers = array("Name", "Surname", "Admin");
	$types = array('Yes', 'No');
	print("<form method='POST'>");
	print("<br><b style='font-size: 30px;'>Users</b><br><br><br>");
	print("<table border = 1><tr>");
	foreach($headers as $header) 
	print("<td style='background-color: blue'><b>$header</b></td>");
	
	if($_SESSION['type'] == 0)
		print("<td style='background-color: blue' align='center'><b> Modify </b></td>");	
	print("</tr>");
  
	while($record = mysqli_fetch_row($result)){		
			print("<tr>");
			foreach($record as $f=>$field)
				if($f != 0) 
					if($f == 3)
						print("<td style='background-color: darkblue'>" . $types[$field] . "</td>");	
					else
						print("<td style='background-color: darkblue'>" . $field . "</td>");	
			if($_SESSION['type'] == 0)
				print("<td style='background-color: blue' align='center'>
						<input type='submit' name='button[$record[0]]' value='Edit'>
						<input type='submit' name='button[$record[0]]' value='Remove'></td>");	
			print("</tr>");		
	}
	print("</table>");
    print("</form>");
	mysqli_free_result($result);
}

function editUser($id) {
	global $connection;	
	
	$query = "select name, surname, admin from user where id=$id;";
	$record = mysqli_query($connection, $query) or exit("Query $query failed");
			
	$user = mysqli_fetch_row($record);
	$name = $user[0];
	$surname = $user[1];
	$type = $user[2];
	
echo " 
	<form method=POST action=''> 
	<table border=0>
	<tr>
	<td>Name</td><td colspan=2>
	<input type=text name='name' value='$name' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td>Surname</td><td colspan=2>
	<input type=text name='surname' value='$surname' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td>Type</td><td colspan=2>
	<input type=number name='type' value='$type' min=0 max=1 size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td colspan=3>	
	<input type=submit name='button[$id]' value='Save' style='width:200'></td>
	</tr>
	</table></form>";
}

function deleteUser($id){
	global $connection;
	$query = "delete from user where id = $id";
	mysqli_query($connection, $query) or exit ("Query '$query' failed");
}


function saveUser($id) {
	global $connection;
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$type = $_POST['type'];
	
	if($id == $_SESSION['idA'])
		$_SESSION['type'] = $type;
	
	$query = "update user set name='$name', surname='$surname', admin=$type where id=$id;";		
	mysqli_query($connection, $query) or exit("Query $query failed");
}

?>

<html>
<head>
<meta charset="utf-8">
<title>Gym Manager</title>
</head>
<body bgcolor=red text="#FFFFFF">
<center>

<input type=button value=" MAIN PAGE " onClick="window.location='main.php'">

<input type=button value=" SPORTS " onClick="window.location='sports.php'">

<input type=button value=" SCHEDULE " onClick="window.location='schedule.php'">

<hr>
<?php
$command = '';
if(isset($_POST['button'])) {	
	$id = key($_POST['button']);
	$command = $_POST['button'][$id];
}


openConnection();

switch($command) {
	case 'Edit': editUser($id); break;
	case 'Save': saveUser($id); break;
	case 'Remove': deleteUser($id);break;
}

showUsers();
closeConnection();
?>

<input type=button value=" BACK " style="align:center" onClick="window.location='main.php'">

</center>
</body>
</html>
