<?php
include "./dbcon.php";

// Define Global Variables
// define("BaseUrl", "http://localhost/cash-trend-admin");
define("Site_Name", "Matka Booking");
define("Site_Version", "1.0");
// define("Script_Password", "ad38b53ef326ef");

// Define Reusable functions
function getSafeValue($value){
	global $conn;
	return strip_tags(
		mysqli_real_escape_string($conn, $value)
	);
}

function getSattaMarkets(){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select * from satta_markets order by id desc");
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

function getGameRuleContent(){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select * from game_rule where id = '1'");
	if($res->num_rows > 0){
		$serverData = $res->fetch_assoc();
		
	}
	return $serverData;
}

function getDeposits(){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select * from deposits order by id desc");
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

function getWithdraws(){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select * from withdraw order by id desc");
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

?>