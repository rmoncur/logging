<?php

require_once  $_SERVER['DOCUMENT_ROOT'] . "/includes/mysqlconnect.php";

$start = $_GET["start"];
$end = $_GET["end"];
$sensor = "";
if( !empty($_GET["sensor"]) ){
	$sensor = " AND sensor='".$_GET["sensor"]."' ";
	
}

//Getting the latest temperature
$query = "SELECT temperature,DATE_SUB(created_at,INTERVAL 1 HOUR) AS created_at FROM temperature WHERE created_at >= '$start' AND created_at <= '$end' $sensor ORDER BY created_at ASC";
//echo $query;
$result = mysql_query($query);
$data = array();

while($row = mysql_fetch_assoc($result)){
	//unset($row["temperature_id"]);
	$row["temperature"] = (float)$row["temperature"];
	$row["fahrenheit"] = round($row["temperature"] * 1.8 + 32,1);
	$data[] = array($row["created_at"],$row["fahrenheit"]);
}

header('Content-Type: application/json');
echo json_encode($data);
exit;
