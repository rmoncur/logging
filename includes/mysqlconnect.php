<?php 

if( $_SERVER["HTTP_HOST"] == "chartjs.test" ){

	$username = "";
	$password = "";
	$hostname = ""; 

} else {
	
	$username = "root";
	$password = "password";
	$hostname = "localhost"; 
	
}
	
	//connection to the database
	$dbhandle = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL - Sorry" . " " . mysql_error());
	//echo "Connected to MySQL<br>";
	
	//select a database to work with
	$selected = mysql_select_db("logging",$dbhandle) or die("Could not select examples");
