<?php
include "../dbcon.php";
require_once('../vendor/autoload.php');
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

// Push Notification
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

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
                'body' => '{"app_id": "0b0d49dd-8df1-4997-8e19-289e52dbf784","included_segments":["Subscribed Users"],"contents":{"en":"'.$content.'"},"headings":{"en":"'.$title.'"},"name":"SM Plays Notification"}',
                'headers' => [
                    'Authorization' => 'Basic NzdhM2ExYmItYTUzOS00NmUyLWIzZGQtZWM2ODE5MWE0OGFm',
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);
            $response->getBody();
            echo json_encode(array("error"=>false, "message"=>"Notification executed Successfully", "serverResponse"=> $response->getBody()));

            // if($conn->affected_rows > 0){
            //     echo "<script>alert('Notification sent to everyone.');</script>";
            // } else{
            //     echo "<script>alert('Something went wrong. Try again');</script>";
            // }
        }     
    } else{
        // Error Part
        echo "<script>alert('All fields are required.');</script>";
    }
    mysqli_close($conn);
    // header("Location:../push-notification.php");
}
// ! Push Notification

?>