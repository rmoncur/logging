<?php

//require "../../../../includes/mysqlconnect.php";
require_once "../../../includes/mysqlconnect.php";

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
