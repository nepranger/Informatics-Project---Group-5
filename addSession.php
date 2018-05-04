<?php

// We need to include these two files in order to work with the database
include_once('config.php');
include_once('dbutils.php');


// get a handle to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

// get data from the angular controller
// decode the json object
$data = json_decode(file_get_contents('php://input'), true);


// get each piece of data

$available_date = $data['available_date'];

// set up variables to handle errors
// is complete will be false if we find any problems when checking on the data
$isComplete = true;

// error message we'll send back to angular if we run into any problems
$errorMessage = "error";

//
// Validation
//

// check if session meets criteria
if (!isset($available_date)) {
    $isComplete = false;
    $errorMessage .= "Please enter a date";
} else {
    $available_date = makeStringSafe($db, $available_date);
}
//check for type
session_start();
$hawk_ID = $_SESSION['username'];
$account_type = $_SESSION['accountType'];

// Be sure the user is a tutor
if (!isset($account_type) || $account_type != 'tutor') {
    $isComplete = false;
    $errorMessage .= "You must be a tutor to schedule a session.";
}

// if we got this far and $isComplete is true it means we should add the availble session
if ($isComplete) {
    
    // we will set up the insert statement to add this new record to the database
    $insertquery = "INSERT INTO Tutor_Availability(hawk_ID, available_date) VALUES ('$hawk_ID', '$available_date')";

    // run the insert statement
    queryDB($insertquery, $db);
    
    // get the id of the session we just entered-- keep track 
    $sessionid = mysqli_insert_id($db);
    
    // send a response back to angular
    $response = array();
    $response['status'] = 'success';
    $response['id'] = $sessionid;
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