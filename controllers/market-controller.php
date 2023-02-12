<?php
include "../dbcon.php";
function getSafeValue($value){
    global $conn;
    return strip_tags(
        mysqli_real_escape_string($conn, $value)
    );
}

$start = date("Y-m-d H:i:s");
$addedOn = date('Y-m-d H:i:s',strtotime('+5 hour +30 minutes',strtotime($start)));

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

// Create satta market
if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Create-Satta-Market"){
    $mandatoryVal = isset($_POST["title"]) && isset($_POST["bidOpenTime"]) && isset($_POST["bidCloseTime"]) && isset($_POST["resultOpenTime"]) && isset($_POST["resultCloseTime"]);

    if(isset($_POST['marketStatus'])){
        $_POST['marketStatus'] = 'Active';
    } else {
        $_POST['marketStatus'] = 'Inactive';
    }
    if($mandatoryVal){
        $title = getSafeValue($_POST['title']);
        $marketStatus = getSafeValue($_POST['marketStatus']);
        $bidOpenTime = getSafeValue($_POST['bidOpenTime']);
        $bidCloseTime = getSafeValue($_POST['bidCloseTime']);
        $resultOpenTime = getSafeValue($_POST['resultOpenTime']);
        $resultCloseTime = getSafeValue($_POST['resultCloseTime']);

        if($processStatus["error"] == false){
            $conn->query("Insert into satta_markets set 
            title = '$title',
            status = '$marketStatus',
            bidOpenTime = '$bidOpenTime',
            bidCloseTime = '$bidCloseTime',
            resultOpenTime = '$resultOpenTime',
            resultCloseTime = '$resultCloseTime',
            date = '$addedOn'
            ");

            if($conn->affected_rows > 0){
                echo "<script>alert('New Satta Market is recorded.');</script>";
            } else{
                echo "<script>alert('Something went wrong. Try again');</script>";
            }
        }     
    } else{
        // Error Part
        echo "<script>alert('All fields are required.');</script>";
    }
    mysqli_close($conn);
    header("Location:../add-market.php");
}
// ! Create satta market


// Update satta market
if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Update-Satta-Market"){
    $mandatoryVal = isset($_POST["marketId"]) && isset($_POST["title"]) && isset($_POST["bidOpenTime"]) && isset($_POST["bidCloseTime"]) && isset($_POST["resultOpenTime"]) && isset($_POST["resultCloseTime"]);

    if(isset($_POST['marketStatus'])){
        $_POST['marketStatus'] = 'Active';
    } else {
        $_POST['marketStatus'] = 'Inactive';
    }
    if($mandatoryVal){
        $marketId = getSafeValue($_POST['marketId']);
        $title = getSafeValue($_POST['title']);
        $marketStatus = getSafeValue($_POST['marketStatus']);
        $bidOpenTime = getSafeValue($_POST['bidOpenTime']);
        $bidCloseTime = getSafeValue($_POST['bidCloseTime']);
        $resultOpenTime = getSafeValue($_POST['resultOpenTime']);
        $resultCloseTime = getSafeValue($_POST['resultCloseTime']);

        if($processStatus["error"] == false){
            $conn->query("Update satta_markets set 
            title = '$title',
            status = '$marketStatus',
            bidOpenTime = '$bidOpenTime',
            bidCloseTime = '$bidCloseTime',
            resultOpenTime = '$resultOpenTime',
            resultCloseTime = '$resultCloseTime'
            where id = '$marketId'
            ");

            if($conn->affected_rows > 0){
                echo "<script>alert('Satta Market is updated.');</script>";
            } else{
                echo "<script>alert('Something went wrong. Try again');</script>";
            }
        }     
    } else{
        // Error Part
        echo "<script>alert('All fields are required.');</script>";
    }
    mysqli_close($conn);
    header("Location:../market-list.php");
}
// ! Update satta market
?>