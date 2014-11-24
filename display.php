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

//$query = "INSERT INTO temperature (temperature,humidity,sensor,temperature_unit,humidity_unit) VALUES($temperature,$humidity,'$sensor','$temperature_unit','$humidity_unit')";
//$r = mysql_query($query);

//Getting the latest temperature
$result = mysql_query("SELECT * FROM temperature ORDER BY created_at DESC LIMIT 1");
while($row = mysql_fetch_assoc($result)){
	$c = $row["temperature"];
	$h = $row["humidity"];
	$created_at = $row["created_at"];
}
$f = $c *1.8 + 32;

//Grabbing averages
$result = mysql_query("SELECT sensor, AVG(temperature) AS avg_c, (AVG(temperature) * 1.8 + 32) AS avg_f , AVG(humidity) AS humidity, DATE(created_at) AS date, HOUR(created_at) AS hour 
FROM temperature GROUP BY sensor, DATE(created_at), HOUR(created_at) ORDER BY sensor, created_at DESC");
$averages = array();
while($row = mysql_fetch_assoc($result)){
	$averages[] = $row;
}



mysql_close($dbhandle);

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
<meta charset="utf-8"> 
</head>
<body>
<table class="table" style="width:370px;">
	<tr>
    	<td>Temperature</td>
        <td><?= round($f,2) ?>° F</td>
        <td><?= date("j-M g:i A", strtotime($created_at)-3600) ?></td>
    </tr>
    <tr>
    	<td>Humidity</td>
        <td><?= $h ?>%</td>
        <td><?= date("j-M g:i A", strtotime($created_at)-3600) ?></td>
    </tr>
</table>

<table class="table" style="width:350px;">
	<tr>
    	<th>Date/Time</th>
        <th>Sensor</th>
        <th colspan="2">Temperature</th>
        <th>Humidity</th>
    </tr>
<? foreach($averages as $key => $val){ ?>
	<tr>
    	<td><?= date("gA j-M",strtotime($val["date"] ." ". $val["hour"].":0")-3600) ?></td>
        <td><?= $val["sensor"] ?></td>
        <td><?= round($val["avg_f"],2) ?></td>
        <td>°F</td>
        <td><?= round($val["humidity"],2) ?>%</td>
    </tr>
<? } ?>
</table>
</body>
</html>
<? exit;