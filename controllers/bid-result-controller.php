<?php
include "../dbcon.php";
include "./push-notification-function.php";

function getSafeValue($value){
    global $conn;
    return strip_tags(
        mysqli_real_escape_string($conn, $value)
    );
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
                if($openScores[$index] != '' || $closeScores[$index] != ''){
                    $title = $markets[$index];
                    $content = ($openScores[$index] == '' ? '***' : $openScores[$index]).'-'.$jodiScores[$index].'-'.($closeScores[$index] == '' ? '***' : $closeScores[$index]);

                    // echo $title.' '.$marketDate.', '.$content;
                    $currentTime = date('Hi', strtotime($addedOn));
                    if($currentTime == $marketDate){
                        pushNotification($title.' | '.$marketDate, $content);
                    }
                }
            }
       } else{
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
                    if($currentTime == $marketDate){
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