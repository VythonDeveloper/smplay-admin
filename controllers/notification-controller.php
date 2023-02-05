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

// Manage App APK
if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Push-Notification"){
    $mandatoryVal = isset($_POST["title"]) && isset($_POST["content"]) && isset($_POST['priority']);

    if($mandatoryVal){
        $title = getSafeValue($_POST['title']);
        $content = getSafeValue($_POST['content']);
        $priority = getSafeValue($_POST['priority']);

        if($processStatus["error"] == false){
            $conn->query("Insert into notifications set
            title = '$title',
            content = '$content',
            priority = '$priority',
            date = '$addedOn'
            ");

            if($conn->affected_rows > 0){
                echo "<script>alert('Notification sent to everyone.');</script>";
            } else{
                echo "<script>alert('Something went wrong. Try again');</script>";
            }
        }     
    } else{
        // Error Part
        echo "<script>alert('All fields are required.');</script>";
    }
    mysqli_close($conn);
    header("Location:../push-notification.php");
}
// ! Create satta market

?>