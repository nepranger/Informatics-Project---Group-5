<?php

//we need to include these two files in order to work with the datbase
include_once('config.php');
include_once('dbutils.php');

//Get a connection to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

// get data from the angular controller
// decode the json object
$data = json_decode(file_get_contents('php://input'), true);
$session_ID = $data['session_ID'];
$slot_ID = $data['slot_ID'];

//get hawk_id to find the right sessions
session_start();
$hawk_ID = $_SESSION['username'];
$accountType = $_SESSION['accountType'];

// set up variables to handle errors
// is complete will be false if we find any problems when checking on the data
$isComplete = true;

// error message we'll send back to angular if we run into any problems
$errorMessage = "error";

//
// Validation
//

// check if id is present
if (!isset($session_ID)) {
    $isComplete = false;
    $errorMessage .= "Must include slot ID";
} else {
    $session_ID = makeStringSafe($db, $session_ID);
}

if ($isComplete) {
    //cancel the session
    if($accountType == 'tutor') {
        //cancelled by tutor
        $updateQuery = "UPDATE Tutor_Session SET cancelled_By_Tutor=1 WHERE tutor_hawk_ID='$hawk_ID' AND session_ID='$session_ID';";
    } else if ($accountType == 'student') {
        //cancelled by student
        $updateQuery = "UPDATE Tutor_Session SET cancelled_By_Student=1 WHERE student_hawk_ID='$hawk_ID' AND session_ID='$session_ID';";
        $updateQuery = "UPDATE Student SET budget= budget +1 WHERE hawk_ID='$hawk_ID';";


    }

    //mark session as available again
    $updateAvailabilityQuery = "UPDATE Tutor_Availability SET scheduled=0 WHERE slot_ID='$slot_ID';";
    queryDB($updateAvailabilityQuery, $db);    


    queryDB($updateQuery, $db);
    
    // get the id of the session we just cancelled
    $sessionid = mysqli_insert_id($db);

    // send a response back to angular
    $response = array();
    $response['status'] = 'success';
    $response['id'] = $sessionid;
    $response['budget'] = $budget;
    
    header('Content-Type: application/json');
    echo(json_encode($response));    
} else {
    // there's been an error. We need to report it to the angular controller.

    // one of the things we want to send back is the data that his php file received
    ob_start();
    var_dump($data);
    $postdump = ob_get_clean();

    // set up our response array
    $response = array();
    $response['status'] = 'error';
    $response['message'] = $errorMessage . $postdump;
    header('Content-Type: application/json');
    echo(json_encode($response));    
}


?>