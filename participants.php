<?php
session_start();
include('dataBaseCreator.php');

function showParticipants(){
	global $connection;
	
	$file = fopen("group.txt","r");
	$sportName = fgets($file);
	$groupN = fgets($file);
	fclose($file);

	$query = "select s.name, groupID, u.name, u.surname
			  from partof p, user u, sports s
			  where p.userID = u.id
			  and p.sportID = s.id
			  and p.groupID = $groupN";
	$result = mysqli_query($connection, $query);	

	$headers = array("Name", "Surname");
	
	print("<form method='POST'>");
	print("<b style='font-size: 30px;'>$sportName - Group: $groupN</b><br><br><br>");
	print("<table border = 1><tr>");
	foreach($headers as $header)
		print("<td style='background-color: blue'><b>$header</b></td>");
	if($_SESSION['type'] == 0)
		print("<td align='center' style='background-color: blue'><b><input type='submit' name='button[-1][]' value='Add participant'></b></td>");	
	print("</tr>");
	
	if(!$result) return;
	while($record = mysqli_fetch_row($result)){		
		print("<tr>");
		foreach($record as $f=>$field)
			if($f > 1)
				print("<td style='background-color: darkblue'>" . $field . "</td>");
		
		if($_SESSION['type'] == 0)
			print("<td style='background-color: blue' align='center'><input type='submit' name='button[$record[1]][$record[2]]' value='Remove'></td>");	
		print("</tr>");		
		
	}
	print("</table>");
    print("</form>");
	mysqli_free_result($result);
}

function removeParticipants($group, $name) {
	global $connection;
	
	$query = "delete from partof where groupID=$group and userID in (select id from user where name = '$name');";		
	mysqli_query($connection, $query) or exit("Query $query failed");
}

function newParticipants(){
	global $connection;
	
	$file = fopen("group.txt","r");
	$sportName = fgets($file);
	$groupN = fgets($file);
	fclose($file);
	
	// Select how many users are currently on group and how many can be as maximum
	$query = "select count(userID), participants from partof p, groups g
			  where p.groupID = g.id and p.groupID = $groupN";
	$result = mysqli_query($connection, $query);
	$record = mysqli_fetch_array($result);
	$currentPart = $record[0];
	$maxPart = $record[1];
	// Select number of total users
	$query = "select count(id) from user";
	$result = mysqli_query($connection, $query);
	$record = mysqli_fetch_array($result);
	$totalUsers= $record[0];
	
	if($currentPart < $maxPart && $currentPart < $totalUsers){
		$query = "select * from user where id not in (select userID from partof where groupID=$groupN) ";
		$result = mysqli_query($connection, $query) or exit ("Query '$query' failed");
			
		// crea lista -- usar name para POST method
		$selectUser = "<select name='userID' style='width:100%'>";
		while ($record = mysqli_fetch_row($result)) {
			$selectUser .= "<option value='$record[0]'> $record[2] $record[3]</option>";
		}
		$selectUser .= "</select>";
		
		echo " 
		<form method=POST action=''> 
		<table border=0>
		<tr>
		<td>User</td><td colspan=2> $selectUser</td>
		</tr>
		<tr>
		<td>	
		<input type=submit name='button[-1][-1]' value='Save' style='width:200'></td>
		<td>	
		<input type=submit name='cancel' value='Cancel' style='width:100' onClick='window.location='participants.php''></td>
		</tr>
		</table></form>";
	}else{
		echo "No more users can be added to this group <br><br><br>";
	}
}	

function saveParticipants($groupID, $userID){
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
	
	$aux = $_POST['userID'];
	
	$query = "INSERT INTO partof VALUES ($aux, $sportID, $groupN)";
	mysqli_query($connection, $query) or exit ("Query '$query' failed");	
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
//print_r($_POST);

$command = '';
if(isset($_POST['button'])) {
	
	$id = key($_POST['button']);
	$id2 = key($_POST['button'][$id]);
	$command = $_POST['button'][$id][$id2];
}

openConnection();

switch($command) {
	case 'Add participant': newParticipants(); break;
	case 'Save': saveParticipants($id, $id2); break;
	case 'Remove': removeParticipants($id, $id2); break;
	}

showParticipants();
closeConnection();
?>

<input type=button value=" BACK " style="align:center" onClick="window.location='groups.php'">

</center>
</body>
</html>
