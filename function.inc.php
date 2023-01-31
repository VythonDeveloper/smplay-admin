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

function getResumes(){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select * from resume order by id desc");
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[$row['id']] = $row;
		}
	}
	return $serverData;
}

function getContactUs(){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select * from contact_us order by id desc");
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[$row['id']] = $row;
		}
	}
	return $serverData;
}
?>