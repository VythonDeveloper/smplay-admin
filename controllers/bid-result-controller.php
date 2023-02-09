<?php
include "../dbcon.php";
include "./push-notification-function.php";
include "./game-rate-constants.inc.php";

function getSafeValue($value){
    global $conn;
    return strip_tags(
        mysqli_real_escape_string($conn, $value)
    );
}

function manageWinnersFunction($mktId, $mktName){
    global $conn;
    global $marketDate;
    global $addedOn;
    $bidResult = $conn->query("Select * from bid_results where marketId = '$mktId' and date = '$marketDate'");
    if($bidResult->num_rows > 0){
        $resultData = $bidResult->fetch_assoc();

// ------------------SINGLE ANK BID RESULT ---------------------------------------------------------        
        
        $sAnkRes = $conn->query("Select * from single_ank_bids where marketId = '$mktId' and marketDate = '$marketDate' and status = 'Pending'");
        if($sAnkRes->num_rows > 0){
            while($sAnkRow = $sAnkRes->fetch_assoc()){
                echo $sAnkRow['ank']."<br>";
                if(($sAnkRow['type'] == "Open" && $sAnkRow['ank'] == $resultData['jodiScore'][0]) || ($sAnkRow['type'] == "Close" && $sAnkRow['ank'] == $resultData['jodiScore'][1])){
                    echo "Win User ".$sAnkRow['userId']." Points: ".$sAnkRow['points']." ka ".($sAnkRow['points'] * SARate)."<br>";
                    $prizeMoney = ($sAnkRow['points'] * SARate);
                    $winnerId = $sAnkRow['userId'];
                    $recordId = $sAnkRow['id'];

                    $conn->query("Update single_ank_bids set status = 'Won' where userId = '$winnerId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");

                    $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$winnerId'");

                    $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                    $conn->query("Insert into passbook set
                    orderId = '$orderId',
                    userId = '$winnerId',
                    title = 'Reward from ".$mktName." Single Ank',
                    amount = '$prizeMoney',
                    bankDetails = '',
                    data = '',
                    status = 'Success',
                    date = '$addedOn',
                    txnType = 'Deposit'
                    ");
                } else{
                    $looserId = $sAnkRow['userId'];
                    $recordId = $sAnkRow['id'];
                    echo "Loose User ".$looserId." Points: ".$sAnkRow['points']." ka 0"."<br>";
                    $conn->query("Update single_ank_bids set status = 'Lost' where userId = '$looserId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");
                }
            }
        }

// ---------------------JODI BID RESULT ----------------------------------------------------------

        if($resultData['jodiScore'][0] != '*' && $resultData['jodiScore'][1] != '*'){
            $jodiRes = $conn->query("Select * from jodi_bids where marketId = '$mktId' and marketDate = '$marketDate' and status = 'Pending'");
            if($jodiRes->num_rows > 0){
                while($jodiRow = $jodiRes->fetch_assoc()){
                    echo $jodiRow['jodi']."<br>";
                    if($jodiRow['jodi'] == $resultData['jodiScore']){
                        echo "Win User ".$jodiRow['userId']." Points: ".$jodiRow['points']." ka ".($jodiRow['points'] * JRate)."<br>";
                        $prizeMoney = ($jodiRow['points'] * JRate);
                        $winnerId = $jodiRow['userId'];
                        $recordId = $jodiRow['id'];

                        $conn->query("Update jodi_bids set status = 'Won' where userId = '$winnerId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");

                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$winnerId'");

                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$winnerId',
                        title = 'Reward from ".$mktName." Jodi',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Deposit'
                        ");
                    } else{
                        $looserId = $jodiRow['userId'];
                        $recordId = $jodiRow['id'];
                        echo "Loose User ".$looserId." Points: ".$jodiRow['points']." ka 0"."<br>";
                        $conn->query("Update jodi_bids set status = 'Lost' where userId = '$looserId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");
                    }
                }
            }
        }

// ------------------------SINGLE PATTI BID RESULT --------------------------------------------------

        $sPattiRes = $conn->query("Select * from single_patti_bids where marketId = '$mktId' and marketDate = '$marketDate' and status = 'Pending'");
        if($sPattiRes->num_rows > 0){
            while($sPattiRow = $sPattiRes->fetch_assoc()){
                echo $sPattiRow['panna']."<br>";
                if(($sPattiRow['type'] == "Open" && $sPattiRow['panna'] == $resultData['openScore']) || ($sPattiRow['type'] == "Close" && $sPattiRow['panna'] == $resultData['closeScore'])){
                    echo "Win User ".$sPattiRow['userId']." Points: ".$sPattiRow['points']." ka ".($sPattiRow['points'] * SPRate)."<br>";
                    $prizeMoney = ($sPattiRow['points'] * SPRate);
                    $winnerId = $sPattiRow['userId'];
                    $recordId = $sPattiRow['id'];

                    $conn->query("Update single_patti_bids set status = 'Won' where userId = '$winnerId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");

                    $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$winnerId'");

                    $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                    $conn->query("Insert into passbook set
                    orderId = '$orderId',
                    userId = '$winnerId',
                    title = 'Reward from ".$mktName." Single Patti',
                    amount = '$prizeMoney',
                    bankDetails = '',
                    data = '',
                    status = 'Success',
                    date = '$addedOn',
                    txnType = 'Deposit'
                    ");
                } else{
                    $looserId = $sPattiRow['userId'];
                    $recordId = $sPattiRow['id'];
                    echo "Loose User ".$looserId." Points: ".$sPattiRow['points']." ka 0"."<br>";
                    $conn->query("Update single_patti_bids set status = 'Lost' where userId = '$looserId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");
                }
            }
        }

// ------------------------DOUBLE PATTI BID RESULT --------------------------------------------------
        
        $duPattiRes = $conn->query("Select * from double_patti_bids where marketId = '$mktId' and marketDate = '$marketDate' and status = 'Pending'");
        if($duPattiRes->num_rows > 0){
            while($duPattiRow = $duPattiRes->fetch_assoc()){
                echo $duPattiRow['panna']."<br>";
                if(($duPattiRow['type'] == "Open" && $duPattiRow['panna'] == $resultData['openScore']) || ($duPattiRow['type'] == "Close" && $duPattiRow['panna'] == $resultData['closeScore'])){
                    echo "Win User ".$duPattiRow['userId']." Points: ".$duPattiRow['points']." ka ".($duPattiRow['points'] * DuPRate)."<br>";
                    $prizeMoney = ($duPattiRow['points'] * DuPRate);
                    $winnerId = $duPattiRow['userId'];
                    $recordId = $duPattiRow['id'];

                    $conn->query("Update double_patti_bids set status = 'Won' where userId = '$winnerId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");

                    $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$winnerId'");

                    $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                    $conn->query("Insert into passbook set
                    orderId = '$orderId',
                    userId = '$winnerId',
                    title = 'Reward from ".$mktName." Double Patti',
                    amount = '$prizeMoney',
                    bankDetails = '',
                    data = '',
                    status = 'Success',
                    date = '$addedOn',
                    txnType = 'Deposit'
                    ");
                } else{
                    $looserId = $duPattiRow['userId'];
                    $recordId = $duPattiRow['id'];
                    echo "Loose User ".$looserId." Points: ".$duPattiRow['points']." ka 0"."<br>";
                    $conn->query("Update double_patti_bids set status = 'Lost' where userId = '$looserId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");
                }
            }
        }

// ------------------------TRIPLE PATTI BID RESULT --------------------------------------------------

        $trPattiRes = $conn->query("Select * from triple_patti_bids where marketId = '$mktId' and marketDate = '$marketDate' and status = 'Pending'");
        if($trPattiRes->num_rows > 0){
            while($trPattiRow = $trPattiRes->fetch_assoc()){
                echo $trPattiRow['panna']."<br>";
                if(($trPattiRow['type'] == "Open" && $trPattiRow['panna'] == $resultData['openScore']) || ($trPattiRow['type'] == "Close" && $trPattiRow['panna'] == $resultData['closeScore'])){
                    echo "Win User ".$trPattiRow['userId']." Points: ".$trPattiRow['points']." ka ".($trPattiRow['points'] * TrPRate)."<br>";
                    $prizeMoney = ($trPattiRow['points'] * TrPRate);
                    $winnerId = $trPattiRow['userId'];
                    $recordId = $trPattiRow['id'];

                    $conn->query("Update triple_patti_bids set status = 'Won' where userId = '$winnerId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");

                    $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$winnerId'");

                    $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                    $conn->query("Insert into passbook set
                    orderId = '$orderId',
                    userId = '$winnerId',
                    title = 'Reward from ".$mktName." Triple Patti',
                    amount = '$prizeMoney',
                    bankDetails = '',
                    data = '',
                    status = 'Success',
                    date = '$addedOn',
                    txnType = 'Deposit'
                    ");
                } else{
                    $looserId = $trPattiRow['userId'];
                    $recordId = $trPattiRow['id'];
                    echo "Loose User ".$looserId." Points: ".$trPattiRow['points']." ka 0"."<br>";
                    $conn->query("Update triple_patti_bids set status = 'Lost' where userId = '$looserId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");
                }
            }
        }

// ------------------------HALF SANGAM BID RESULT --------------------------------------------------

        if($resultData['jodiScore'][0] != '*' && $resultData['jodiScore'][1] != '*' && $resultData['openScore'] != '' && $resultData['closeScore'] != ''){
            $hlSangRes = $conn->query("Select * from half_sangam_bids where marketId = '$mktId' and marketDate = '$marketDate' and status = 'Pending'");
            if($hlSangRes->num_rows > 0){
                while($hlSangRow = $hlSangRes->fetch_assoc()){
                    echo $hlSangRow['panna']."<br>";
                    if(
                        ($hlSangRow['type'] == "OACP" && $hlSangRow['ank'] == $resultData['jodiScore'][0] && $hlSangRow['panna'] == $resultData['closeScore']) || 
                        ($hlSangRow['type'] == "CAOP" && $hlSangRow['ank'] == $resultData['jodiScore'][1] && $hlSangRow['panna'] == $resultData['openScore'])
                    ){
                        echo "Win User ".$hlSangRow['userId']." Points: ".$hlSangRow['points']." ka ".($hlSangRow['points'] * HlSangRate)."<br>";
                        $prizeMoney = ($hlSangRow['points'] * HlSangRate);
                        $winnerId = $hlSangRow['userId'];
                        $recordId = $hlSangRow['id'];

                        $conn->query("Update half_sangam_bids set status = 'Won' where userId = '$winnerId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");

                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$winnerId'");

                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$winnerId',
                        title = 'Reward from ".$mktName." Half Sangam',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Deposit'
                        ");
                    } else{
                        $looserId = $hlSangRow['userId'];
                        $recordId = $hlSangRow['id'];
                        echo "Loose User ".$looserId." Points: ".$hlSangRow['points']." ka 0"."<br>";
                        $conn->query("Update half_sangam_bids set status = 'Lost' where userId = '$looserId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");
                    }
                }
            }
        }

// ------------------------FULL SANGAM BID RESULT --------------------------------------------------

        if($resultData['jodiScore'][0] != '*' && $resultData['jodiScore'][1] != '*' && $resultData['openScore'] != '' && $resultData['closeScore'] != ''){
            $fullSangRes = $conn->query("Select * from full_sangam_bids where marketId = '$mktId' and marketDate = '$marketDate' and status = 'Pending'");
            if($fullSangRes->num_rows > 0){
                while($fullSangRow = $fullSangRes->fetch_assoc()){
                    echo $fullSangRow['openPanna']. " ".$fullSangRow['closePanna']."<br>";
                    if($fullSangRow['openPanna'] == $resultData['openScore'] && $fullSangRow['closePanna'] == $resultData['closeScore']){
                        echo "Win User ".$fullSangRow['userId']." Points: ".$fullSangRow['points']." ka ".($fullSangRow['points'] * FullSangRate)."<br>";
                        $prizeMoney = ($fullSangRow['points'] * FullSangRate);
                        $winnerId = $fullSangRow['userId'];
                        $recordId = $fullSangRow['id'];

                        $conn->query("Update full_sangam_bids set status = 'Won' where userId = '$winnerId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");

                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$winnerId'");

                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$winnerId',
                        title = 'Reward from ".$mktName." Full Sangam',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Deposit'
                        ");
                    } else{
                        $looserId = $fullSangRow['userId'];
                        $recordId = $fullSangRow['id'];
                        echo "Loose User ".$looserId." Points: ".$fullSangRow['points']." ka 0"."<br>";
                        $conn->query("Update full_sangam_bids set status = 'Lost' where userId = '$looserId' and marketDate = '$marketDate' and marketId = '$mktId' and id = '$recordId'");
                    }
                }
            }
        }
// -------------------------------------------------------------------------------------------------
    }
}

$start = date("Y-m-d H:i:s");
$addedOn = date('Y-m-d H:i:s',strtotime('+5 hour +30 minutes', strtotime($start)));

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

// Add/Update Bid result
if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Post-Bid-Result"){
    $marketDate = date('Y-m-d', strtotime(getSafeValue($_POST['marketDate'])));
    $marketIds = $_POST['marketIds'];
    $markets = $_POST['markets'];
    $openScores = $_POST['openScores'];
    $jodiScores = $_POST['jodiScores'];
    $closeScores = $_POST['closeScores'];

    for ($index=0; $index < count($marketIds); $index++) {
        
        $checkRes = $conn->query("Select id from bid_results where marketId = '".$marketIds[$index]."' and date = '$marketDate'");
        if($checkRes->num_rows > 0){
            
            $updateMarketId = $checkRes->fetch_assoc()['id'];
            $conn->query("Update bid_results set
            openScore = '".$openScores[$index]."',
            jodiScore = '".$jodiScores[$index]."',
            closeScore = '".$closeScores[$index]."'
            where marketId = '".$marketIds[$index]."' and date = '$marketDate' and id = '$updateMarketId'
            ");
            if($conn->affected_rows > 0){
                echo "Update"."<br>";
                if($openScores[$index] != '' || $closeScores[$index] != ''){
                    $title = $markets[$index];
                    $content = ($openScores[$index] == '' ? '***' : $openScores[$index]).'-'.$jodiScores[$index].'-'.($closeScores[$index] == '' ? '***' : $closeScores[$index]);
                    // echo $title.' '.$marketDate.', '.$content;
                    $currentDate = date('Y-m-d', strtotime($addedOn));
                    echo $currentDate."<br>";
                    manageWinnersFunction($marketIds[$index], $markets[$index]);
                    if($currentDate == $marketDate){
                        pushNotification($title.' | '.$marketDate, $content);
                    }
                }
            }
        } else{
            echo "Insert"."<br>";
            $conn->query("Insert into bid_results set
            openScore = '".$openScores[$index]."',
            jodiScore = '".$jodiScores[$index]."',
            closeScore = '".$closeScores[$index]."',
            marketId = '".$marketIds[$index]."',
            date = '$marketDate'
            ");
            if($conn->affected_rows > 0){

                if($openScores[$index] != '' || $closeScores[$index] != ''){
                    $title = $markets[$index];
                    $content = ($openScores[$index] == '' ? '***' : $openScores[$index]).'-'.$jodiScores[$index].'-'.($closeScores[$index] == '' ? '***' : $closeScores[$index]);
                    // echo $title.' '.$marketDate.', '.$content;
                    $currentDate = date('Y-m-d', strtotime($addedOn));
                    echo $currentDate."<br>";
                    manageWinnersFunction($marketIds[$index], $markets[$index]);
                    if($currentDate == $marketDate){
                        pushNotification($title.' | '.$marketDate, $content);
                    }
                }
            }
        }      
    }
    header("Location:../bid-result.php");
}
// ! Add/Update Bid Result
?>