<?php
$username = "jungleb3_logging";
$password = "L00ging";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
//echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db("jungleb3_logging",$dbhandle) 
  or die("Could not select examples");

$temperature = $_GET["temperature"];
$temperature_unit = $_GET["temperature_unit"];
$humidity = $_GET["humidity"];
$humidity_unit = $_GET["humidity_unit"];
$sensor = $_GET["sensor"];


if( !empty($_GET["temperature"])){
	$query = "INSERT INTO temperature (temperature,humidity,sensor,temperature_unit,humidity_unit) VALUES($temperature,$humidity,'$sensor','$temperature_unit','$humidity_unit')";
	$r = mysql_query($query);
}

//execute the SQL query and return records
//$result = mysql_query("SELECT * FROM temperature");

echo $query;
exit;

//fetch tha data from the database 
//while ($row = mysql_fetch_assoc($result)) {
//  echo json_encode($row);
//}
//close the connection
mysql_close($dbhandle);

?>