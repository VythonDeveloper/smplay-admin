<?php
include "./dbcon.php";

// Define Global Variables
define("Site_Name", "SM Plays");
define("Site_Version", "1.5");
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

function getMarketDetails($marketId){
	global $conn;
	$serverData = array();
	$res = $conn->query("Select * from satta_markets where id = '$marketId'");
	if ($res->num_rows > 0) {
		$serverData = $res->fetch_assoc();
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

function getUserBids($gameType){
	global $conn;
	$serverData = Array();
	if($gameType == "Single Ank"){
		$sql = "Select bds.*, bds.marketDate as playDate, mkt.title, us.fullname, us.phone from single_ank_bids as bds, satta_markets as mkt, user as us where bds.marketId = mkt.id and bds.userId = us.id order by bds.date DESC";
	} else if($gameType == "Jodi"){
		$sql = "Select bds.*, bds.marketDate as playDate, mkt.title, us.fullname, us.phone from jodi_bids as bds, satta_markets as mkt, user as us where bds.marketId = mkt.id and bds.userId = us.id order by bds.date DESC";
	} else if($gameType == "Single Patti"){
		$sql = "Select bds.*, bds.marketDate as playDate, mkt.title, us.fullname, us.phone from single_patti_bids as bds, satta_markets as mkt, user as us where bds.marketId = mkt.id and bds.userId = us.id order by bds.date DESC";
	} else if($gameType == "Double Patti"){
		$sql = "Select bds.*, bds.marketDate as playDate, mkt.title, us.fullname, us.phone from double_patti_bids as bds, satta_markets as mkt, user as us where bds.marketId = mkt.id and bds.userId = us.id order by bds.date DESC";
	} else if($gameType == "Triple Patti"){
		$sql = "Select bds.*, bds.marketDate as playDate, mkt.title, us.fullname, us.phone from triple_patti_bids as bds, satta_markets as mkt, user as us where bds.marketId = mkt.id and bds.userId = us.id order by bds.date DESC";
	} else if($gameType == "Half Sangam"){
		$sql = "Select bds.*, bds.marketDate as playDate, mkt.title, us.fullname, us.phone from half_sangam_bids as bds, satta_markets as mkt, user as us where bds.marketId = mkt.id and bds.userId = us.id order by bds.date DESC";
	} else if($gameType == "Full Sangam"){
		$sql = "Select bds.*, bds.marketDate as playDate, mkt.title, us.fullname, us.phone from full_sangam_bids as bds, satta_markets as mkt, user as us where bds.marketId = mkt.id and bds.userId = us.id order by bds.date DESC";
	} else{
		$sql = "";
	}

	if($sql != ""){
		$res = $conn->query($sql);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$serverData[count($serverData)] = $row;
			}
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
	$res = $conn->query("Select dep.*, us.fullname, us.phone from passbook as dep, user as us where dep.txnType = 'Deposit' and dep.userId = us.id order by dep.id desc");
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
	$res = $conn->query("Select wit.*, us.fullname, us.phone from passbook as wit, user as us where wit.txnType = 'Withdraw' and wit.userId = us.id order by id desc");
	if ($res->num_rows > 0) {
		while ($row = $res->fetch_assoc()) {
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

function getMarketResult($date){
	global $conn;
	$serverData = array();
	$date = date('Y-m-d', strtotime($date));
	$res = $conn->query("Select * from bid_results where date = '$date'");
	if ($res->num_rows > 0) {
		while ($row = $res->fetch_assoc()) {
			$serverData[$row['marketId']] = $row;
		}
	}
	return $serverData;
}

function getNotifications(){
	global $conn;
	$serverData = array();
	$res = $conn->query("Select * from notifications order by id desc");
	if ($res->num_rows > 0) {
		while ($row = $res->fetch_assoc()) {
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}
?>