<?php
session_start();
include('dataBaseCreator.php');

function showSchedule(){
	global $connection;
	
	$index = 0;
	$weekDays = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
	
	print("<br><b style='font-size: 30px;'>Schedule</b><br><br><br>");
	
	print("<table border=1>");
	while($index < 7){
		$query = "select * from groups g, sports s where weekDay = $index+1 and s.id = g.sportID";
		$result = mysqli_query($connection, $query);
		
		if(!$result) continue;
		print("<tr><td style='background-color: blue'> $weekDays[$index]</td>");
		while($record = mysqli_fetch_row($result)){		
			print("<td style='background-color: darkblue'> Sport: $record[5] - Group: $record[0] </td>");
		}
		print("</tr>");
		$index = $index + 1;
	}
	print("</table>");
}

?>

<html>
<head>
<meta charset="utf-8">
<title>Gym Manager</title>
</head>
<center>

<body bgcolor=red text="#FFFFFF">

<input type=button value=" USERS " onClick="window.location='users.php'">

<input type=button value=" SPORTS " onClick="window.location='sports.php'">

<input type=button value=" MAIN PAGE " onClick="window.location='main.php'">

<hr>
<?php
openConnection();
showSchedule();
closeConnection();
?>

<input type=button value=" BACK " style="align:center" onClick="window.location='main.php'">
</center>
</body>
</html>
