<?php

// php select option value from database

// connect to mysql database

$connect = mysqli_connect("localhost","DBuser","DBpass","DBname");

// mysql select query
$query = "SELECT natch_module_realestates_item.title FROM natch_module_realestates_item";

// for method 1

$result1 = mysqli_query($connect, $query);
$result2 = mysqli_query($connect, $query);
$result3 = mysqli_query($connect, $query);

    session_start();
    if(!isset($_SESSION['login'])) {
        header('LOCATION:login.php'); die();
    }
?>

<!DOCTYPE html>

<html>

    <head>

        <title> SELECT PROJECTS </title>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>

    <body>
	<form action="index.php" method="get">
		        <!--Method One-->
			<select style="width: 150px;" name="rec1">
				<option value=" "><?php echo "Select a project #1";?></option>
				<?php while($row1 = mysqli_fetch_array($result1)):;?>
				<option value="<?php echo $row1[title];?>"><?php echo $row1[title];?></option>
				<?php endwhile;?>   
			</select></br>
		
		        <!--Method One-->
			<select style="width: 150px;" name="rec2">
				<option value=" "><?php echo "Select a project #2";?></option>
				<?php while($row1 = mysqli_fetch_array($result2)):;?>
				<option value="<?php echo $row1[title];?>"><?php echo $row1[title];?></option>
				<?php endwhile;?>   
			</select></br>
		
		        <!--Method One-->
			<select style="width: 150px;" name="rec3">
				<option value=" "><?php echo "Select a project #3";?></option>
				<?php while($row1 = mysqli_fetch_array($result3)):;?>
				<option value="<?php echo $row1[title];?>"><?php echo $row1[title];?></option>
				<?php endwhile;?>   
			</select></br>
		<input type="submit">
	</form>
    </body>

</html>
