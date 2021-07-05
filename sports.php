<?php
session_start();
include('dataBaseCreator.php');

function showCourses(){	
	global $connection;

	$query = "select * from sports";	
	$result = mysqli_query($connection, $query);	
	
	if(!$result) return;

  
	$headers = array("Name", "Info");
	print("<form method='POST'>");
	print("<b style='font-size: 30px;'>Sports</b><br><br><br>");
	print("<table border = 1><tr>");
	foreach($headers as $header) 
	print("<td style='background-color: blue'><b>$header</b></td>");
	
  // an attribute name=button[-1] means that if 'New' button will be pressed
  // in $_POST['button'][-1] will be 'New', -1 means a new course
	if($_SESSION['type'] == 0)
		print("<td style='background-color: blue' align='center'><b><input type='submit' name='button[-1]' value='New'></b></td>");	
	else
		print("<td style='background-color: blue' align='center'><b> View groups </b></td>");	
	print("</tr>");
  
	while($record = mysqli_fetch_row($result)){		
			print("<tr>");
			foreach($record as $f=>$field)
				if($f != 0) print("<td style='background-color: darkblue'>" . $field . "</td>");		  
		  // click on the button sets a relevant operation to do
		  
			print("<td style='background-color: blue' align='center'>");
			if($_SESSION['type']==0){
				print("<input type='submit' name='button[$record[0]]' value='Edit'>
					<input type='submit' name='button[$record[0]]' value='Remove'>");
			}
			print("<input type='submit' name='button[$record[0]]' value='View groups'></td>");	
					
			print("</tr>");		
	}
	print("</table>");
    print("</form>");
	mysqli_free_result($result);
}

function editCourse($id) {
	global $connection;	
	
	if($id != -1) {
		$query = "select name, details from sports where id=$id;";
		$record = mysqli_query($connection, $query) or exit("Query $query failed");
                
        $sport = mysqli_fetch_row($record);
        $name = $sport[0];
        $details = $sport[1];            
	}
	else {
		$name=''; $details='';
	}
	
  
echo " 
	<form method=POST action=''> 
	<table border=0>
	<tr>
	<td>Name</td><td colspan=2>
	<input type=text name='name' value='$name' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td>Details</td><td colspan=2>
	<input type=text name='details' value='$details' size=25 style='text-align: left'></td>
	</tr>
	<tr>
	<td colspan=2>	
	<input type=submit name='button[$id]' value='Save' style='width:100'></td>
	<td>	
	<input type=submit name='cancel' value='Cancel' style='width:100' onClick='window.location='sports.php''></td>
	</tr>
	</table></form>";
}

function deleteCourse($id){
	global $connection;
	$query = "delete from sports where id = $id";
	mysqli_query($connection, $query) or exit ("Query '$query' failed");
}


function saveCourse($id) {
	global $connection;
	$name = $_POST['name'];
	$details = $_POST['details'];
	if($id != -1)
		$query = "update sports set name='$name', details= '$details' where id=$id;";
	else $query = "insert into sports values(null, '$name', '$details');";		
	mysqli_query($connection, $query) or exit("Query $query failed");
}

function showGroups($id){
	$file = fopen("sportNumber.txt","w");
	fputs($file, "$id\n");
	fclose($file);
	header("Location: groups.php");
}

?>

<html>
<head>
<meta charset="utf-8">
<title>Gym Manager</title>
</head>
<body bgcolor=red text="#FFFFFF">
<center>

<input type=button value=" USERS " onClick="window.location='users.php'">

<input type=button value=" MAIN PAGE " onClick="window.location='main.php'">

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
	case 'Edit': editCourse($id); break;
	case 'New': editCourse(-1); break;
	case 'Save': saveCourse($id); break;
	case 'Remove': deleteCourse($id);break;
	case 'View groups': showGroups($id);break;
}

showCourses();
closeConnection();
?>

<input type=button value=" BACK " style="align:center" onClick="window.location='main.php'">

</center>
</body>
</html>
