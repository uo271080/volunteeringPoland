

<html>
<head>
  <meta charset="utf-8">
  <title>Admin menu</title>
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
<h1> LOGIN REPORT </h1>

<?php
	
		
			//Open the file containing the login report
			$file = fopen("loginReport.txt","r")
			or exit("Problem with opening the login report file.");
			while(1){
				$line = fgets($file);
				echo $line."<br>";
				if(feof($file)) break;
			}
			fclose($file);
			echo "</table>";
		
		
		

		
		

		


	
	
?>

<form method=POST action=''>
	

			<a href='adminMenu.php'>Go back</a>

</form>


</center>
</body>
</html>
