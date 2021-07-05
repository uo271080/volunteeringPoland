<?php
session_start();
include('dataBaseCreator.php');

function showGroup(){
	global $connection;
	
	$file = fopen("sportNumber.txt","r");
	$sportID = fgets($file);
	fclose($file);

	$query = "select name from sports where id = $sportID";
	$result = mysqli_query($connection, $query);
	
	$record = mysqli_fetch_array($result);
	$sportName = $record[0];
	
	
	$query = "select s.name, g.id, participants, weekDay from groups g, sports s
              where s.id = g.sportID and sportID = $sportID";
	$result = mysqli_query($connection, $query);	

	$headers = array("Sport", "Group number", "Max. Participants", "Week day");
	$weekDays = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
	print("<form method='POST'>");
	print("<b style='font-size: 30px;'>Groups for $sportName</b><br><br><br>");
	print("<table border = 1><tr>");
	foreach($headers as $header)
		print("<td style='background-color: blue'><b>$header</b></td>");
		
	if($_SESSION['type'] == 0)
		print("<td style='background-color: blue' align='center'><b><input type='submit' name='button[-1][]' value='New group'></b></td>");	
	else
		print("<td style='background-color: blue' align='center'><b> View participants </b></td>");	
	print("</tr>");
	
	if(!$result) return;
	while($record = mysqli_fetch_row($result)){		
		print("<tr>");
		foreach($record as $f=>$field){
			if($f < 3)
				print("<td style='background-color: darkblue'>" . $field . "</td>");
			else
				print("<td style='background-color: darkblue'>" . $weekDays[$field-1] . "</td>");
		}
		print("<td style='background-color: blue' align='center'>");
		if($_SESSION['type'] == 0){
				print("<input type='submit' name='button[$record[0]][$record[1]]' value='Edit'>
						<input type='submit' name='button[$record[0]][$record[1]]' value='Remove'>");
		}
		print("<input type='submit' name='button[$record[0]][$record[1]]' value='View participants'></td>");	
		print("</tr>");		
	}
	print("</table>");
    print("</form>");
	mysqli_free_result($result);
}

function removeGroup($sportName, $groupID) {
	global $connection;
	
	// From name to sportID
	$query = "select id from sports where name ='$sportName'";
	$result = mysqli_query($connection, $query);
	$record = mysqli_fetch_array($result);
	$sportID = $record[0];
	
	$query = "delete from groups where sportID=$sportID and id=$groupID;";		
	mysqli_query($connection, $query) or exit("Query $query failed");
}

function newGroup(){
	global $connection;
	
	$file = fopen("group.txt","r");
	$sportName = trim(fgets($file));
	$groupN = fgets($file);
	fclose($file);
	
	// From name to sportID
	$query = "select id from sports where name ='$sportName'";
	$result = mysqli_query($connection, $query);
	$record = mysqli_fetch_array($result);
	$sportID = $record[0];
	
	
	echo " 
	<form method=POST action=''> 
	<table border=0>
	<tr>
	<td>Sport</td><td colspan=2> $sportName</td>
	</tr>
	<tr>
	<td>Max. participants </td><td colspan=2>
	<b><input type=number name='maxP' value='' min=3 max=15 size=15 style='text-align: left'></td></b> </td>
	</tr>
	<tr>
	<td>Week day </td><td colspan=2> 
	<b><input type=number name='weekDay' value='' min=1 max=7 size=15 style='text-align: left'></td></b> </td>
	</tr>
	<td>	
	<input type=submit name='button[$sportID][-1]' value='Save' style='width:200'></td>
	<td>	
	<input type=submit name='cancel' value='Cancel' style='width:100' onClick='window.location='groups.php''></td>
	</tr>
	</table></form>";
}	

function editGroup($sportName, $groupID){
	global $connection;
	
	// From name to sportID
	$query = "select id from sports where name ='$sportName'";
	$result = mysqli_query($connection, $query);
	$record = mysqli_fetch_array($result);
	$sportID = $record[0];
	
	$query = "select * from groups where id=$groupID";
			  
	$result = mysqli_query($connection, $query) or exit ("Query '$query' failed");	
	$record = mysqli_fetch_row($result);
	
	echo " 
	<form method=POST action=''> 
	<table border=0>
	<tr>
	<td>Sport</td><td colspan=2> <b> $sportName</b> </td>
	</tr>
	<tr>
	<td>Max. participants </td><td colspan=2>
	<b><input type=number name='maxP' value='$record[2]' min=3 max=15 size=15 style='text-align: left'></td></b> </td>
	</tr>
	<tr>
	<td>Week day </td><td colspan=2> 
	<b><input type=number name='weekDay' value='$record[3]' min=1 max=7 size=15 style='text-align: left'></td></b> </td>
	</tr>
	<tr>
	<td>	
	<input type=submit name='button[$sportID][$groupID]' value='Save' style='width:200'></td>
	<td>	
	<input type=submit name='cancel' value='Cancel' style='width:100' onClick='window.location='groups.php''></td>
	</tr>
	</table></form>";
}

function saveGroup($sportID, $groupID){
	global $connection;
	
	if(isset($_POST['maxP'])) $maxP = $_POST['maxP'];
	if(isset($_POST['weekDay'])) $weekDay = $_POST['weekDay'];

	$query = "SELECT * FROM groups
			  WHERE sportID = '$sportID'
			  AND id = '$groupID'";
	$result = mysqli_query($connection, $query) or exit ("Query '$query' failed");	

	
	if(!mysqli_num_rows($result)){
		$query = "INSERT INTO groups VALUES (null, $sportID, $maxP, $weekDay)";
	}else{
		$query = "UPDATE groups 
				  SET participants = $maxP,
				      weekDay = $weekDay
				  WHERE id = $groupID
				  AND sportID = $sportID";
	}
	mysqli_query($connection, $query) or exit ("Query '$query' failed");	
}

function showParticipants($id, $id2){
	$file = fopen("group.txt","w");
	fputs($file, "$id\n");
	fputs($file, "$id2\n");
	fclose($file);
	header("Location: participants.php");
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
	$id2 = key($_POST['button'][$id]);
	$command = $_POST['button'][$id][$id2];
}

openConnection();

switch($command) {
	case 'New group': newGroup(); break;
	case 'Edit': editGroup($id, $id2); break;
	case 'Save': saveGroup($id, $id2); break;
	case 'Remove': removeGroup($id, $id2); break;
	case 'View participants': showParticipants($id, $id2); break;
	}

showGroup();
closeConnection();
?>

<input type=button value=" BACK " style="align:center" onClick="window.location='sports.php'">

</center>
</body>
</html>
