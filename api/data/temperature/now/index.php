<?php

require_once  $_SERVER['DOCUMENT_ROOT'] . "/includes/mysqlconnect.php";

//Getting the latest temperature
$result = mysql_query("SELECT * FROM temperature WHERE sensor = 'DHT11' ORDER BY created_at DESC LIMIT 1");
$data = array();

while($row = mysql_fetch_assoc($result)){
	$data = $row;
	$data["fahrenheit"] = $data["temperature"] * 1.8 + 32;
}

header('Content-Type: application/json');
echo json_encode($data);
exit;
