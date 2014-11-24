<?php

require_once  $_SERVER['DOCUMENT_ROOT'] . "/includes/mysqlconnect.php";

//Grabbing averages
$result = mysql_query("SELECT sensor, AVG(temperature) AS avg_c, (AVG(temperature) * 1.8 + 32) AS avg_f , AVG(humidity) AS avg_humidity, DATE(created_at) AS date, HOUR(created_at) AS hour 
FROM temperature GROUP BY sensor, DATE(created_at), HOUR(created_at) ORDER BY sensor, created_at ASC ");
$averages = array();
$avg_f = array();
$avg_humidity = array();
$labels = array();
$dht11 = array();
$tmp36 = array();
$i = 0;
while($row = mysql_fetch_assoc($result)){
	$averages[] = $row;
	$avg_f[] = $row["avg_f"];
	$avg_c[] = $row["avg_c"];
	$avg_humidity[] = $row["avg_humidity"];
	$d = $row["date"] . " " . $row["hour"] . ":00:00";
	$d = date(DateTime::RFC2822,strtotime($d));
	$dates[] = $d;
	$highcharts[] = array($d, round($row["avg_f"],1) );
	
	if($row["sensor"] == "DHT11")
		$dht11[] = array($d, round($row["avg_f"],1) );
	else 
		$tmp36[] = array($d, round($row["avg_f"],1) );
	
	$labels[] = $i++;
}

$data = array(
	"dht11" => $dht11,
	"tmp36" => $tmp36,
	"highcharts" => $highcharts,
	"avg_f" => $avg_f,
	"avg_c" => $avg_c,
	"avg_humidity" => $avg_humidity,
	//"dates" => $dates,
	//"labels" => $labels	
);


mysql_close($dbhandle);

header('Content-Type: application/json');
echo json_encode($data);
exit;
