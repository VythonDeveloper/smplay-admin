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


// Manage App FAQ
else if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Create-App-FAQ"){
    $mandatoryVal = isset($_POST["title"]) && isset($_POST["imageLink"]) && isset($_POST["content"]);

    if($mandatoryVal){
        $title = getSafeValue($_POST['title']);
        $imageLink = getSafeValue($_POST['imageLink']);
        $content = getSafeValue($_POST['content']);

        if($processStatus["error"] == false){
            $conn->query("Insert into app_faq set 
                title = '$title',
                image = '$imageLink',
                content = '$content',
                date = '$addedOn'
                ");

            if($conn->affected_rows > 0){
                $processStatus["error"] = false;
                $processStatus["message"] = "Posted App FAQ";
            } else{
                $processStatus["error"] = true;
                $processStatus["message"] = "Something went wrong. Try again";
            }
        } 
    } else{
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "All fields are required.";
    }
    mysqli_close($conn);
    echo json_encode($processStatus);
}
else if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Delete-App-FAQ"){
    $faqId = getSafeValue($_POST['faqId']);
    $conn->query("Delete from app_faq where id = '$faqId' ");
    header("Location:../manage-app-faq.php");
}
// ! Manage App FAQ


// Manage App Achievers
else if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Create-App-Achievers"){
    $mandatoryVal = isset($_POST["imageLink"]) && isset($_POST["title"]) && isset($_POST["content"]);

    if($mandatoryVal){
        $imageLink = getSafeValue($_POST['imageLink']);
        $title = getSafeValue($_POST['title']);
        $content = getSafeValue($_POST['content']);

        if($processStatus["error"] == false){
            $conn->query("Insert into achievers set 
                image = '$imageLink',
                title = '$title',
                content = '$content'
                ");

            if($conn->affected_rows > 0){
                $processStatus["error"] = false;
                $processStatus["message"] = "Posted App Stat";
            } else{
                $processStatus["error"] = true;
                $processStatus["message"] = "Something went wrong. Try again";
            }
        } 
    } else{
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "All fields are required.";
    }
    mysqli_close($conn);
    echo json_encode($processStatus);
}
else if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Delete-App-Achievers"){
    $achieverId = getSafeValue($_POST['achieverId']);
    $conn->query("Delete from achievers where id = '$achieverId' ");
    header("Location:../manage-app-achievers.php");
}
// ! Manage App Achievers


// Manage App Startup Popup
else if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Update-App-Startup-Popup"){
    $mandatoryVal = isset($_POST["title"]) && isset($_POST["buttonLink"]) && isset($_POST["content"]) && isset($_POST["status"]);

    if($mandatoryVal){
        $title = getSafeValue($_POST['title']);
        $buttonLink = getSafeValue($_POST['buttonLink']);
        $content = getSafeValue($_POST['content']);
        $status = getSafeValue($_POST['status']);

        if($processStatus["error"] == false){
            $conn->query("Update app_startup_popup set 
                title = '$title',
                buttonLink = '$buttonLink',
                content = '$content',
                status = '$status'
                where id = '1'
                ");

            if($conn->affected_rows > 0){
                $processStatus["error"] = false;
                $processStatus["message"] = "Update App Startup Popup Details";
            } else{
                $processStatus["error"] = true;
                $processStatus["message"] = "Something went wrong. Try again";
            }
        } 
    } else{
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "All fields are required.";
    }
    mysqli_close($conn);
    echo json_encode($processStatus);
}
// ! Manage App  Startup Popup


// Manage App Contact Links
else if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Update-App-Contact-Links"){
    $mandatoryVal = isset($_POST["whatsApp"]) && isset($_POST["telegram"]) && isset($_POST["telegramChannel"]);

    if($mandatoryVal){
        $whatsApp = getSafeValue($_POST['whatsApp']);
        $telegram = getSafeValue($_POST['telegram']);
        $telegramChannel = getSafeValue($_POST['telegramChannel']);

        if($processStatus["error"] == false){
            $conn->query("Update contactus_links set 
            link = '$whatsApp', 
            date = '$addedOn' 
            where medium = 'WhatsApp'
            ");

            $conn->query("Update contactus_links set 
            link = '$telegram', 
            date = '$addedOn' 
            where medium = 'Telegram'
            ");

            $conn->query("Update contactus_links set 
                link = '$telegramChannel', 
                date = '$addedOn' 
                where medium = 'Telegram Channel'
                ");

            $processStatus["error"] = false;
            $processStatus["message"] = "Update App Contact Links";
    
        } 
    } else{
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "All fields are required.";
    }
    mysqli_close($conn);
    echo json_encode($processStatus);
}
// ! Manage App  Startup Popup
?>