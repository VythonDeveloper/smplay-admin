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

function getAppUsers(){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select * from user order by id desc");
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$userId = $row['id'];
			$bankRes = $conn->query("Select * from bank_details where userId = '$userId'");
			$bankRow = Array();
			if($bankRes->num_rows > 0){
				$bankRow = $bankRes->fetch_assoc();
			}
			$row['bankDetails'] = $bankRow;
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
	$serverData = array();
	$res = $conn->query("Select wit.*, us.phone from withdraw as wit, user as us where wit.userId = us.id order by id desc");
	if ($res->num_rows > 0) {
		while ($row = $res->fetch_assoc()) {
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

?>