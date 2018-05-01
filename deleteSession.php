<?php

// We need to include these two files in order to work with the database
include_once('config.php');
include_once('dbutils.php');


// get a handle to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

// get data from the angular controller
// decode the json object
$slot_ID = json_decode(file_get_contents('php://input'), true);

//get hawk_id to find the right session
session_start();
$hawk_ID = $_SESSION['username'];

// set up variables to handle errors
// is complete will be false if we find any problems when checking on the data
$isComplete = true;

// error message we'll send back to angular if we run into any problems
$errorMessage = "";

//
// Validation
//

// check if slot_ID got sent
if (!isset($slot_ID)) {
    $isComplete = false;
    $errorMessage .= "The deleteSession.php file requires an integer slot_ID to be sent. ";
}

// check if we there is a record in the database matching the id
if ($isComplete) {
    // set up a query to check if the id passed to this file corresponds to a record in the database
    $query = "SELECT hawk_ID, scheduled FROM Tutor_Availability WHERE slot_ID=$slot_ID";
    
    // we need to run the query
    $result = queryDB($query, $db);
    
    // check on the number of records returned
    if (nTuples($result) == 0) {
        // if we get no recors back, it means no records match the slot_ID that we got
        $isComplete = false;
        $errorMessage .= "The slot_ID $slot_ID did not match any records in the Tutor_Availability table. ";
    }

}

$session = nextTuple($result);

if ($session['hawk_ID'] != $hawk_ID) {
    $isComplete = false;
    $errorMessage .= "hawk_ID $hawk_ID does not match available session creator's hawk_ID. ";
}

if ($session['scheduled']) {
    $isComplete = false;
    $errorMessage .= "Cannot delete a session that has already been scheduled. ";
}

// if we got this far and $isComplete is true it means we should delete the session from the database
if ($isComplete) {
    // we will set up the delete statement to remove the session from the database
    $deletequery = "DELETE FROM Tutor_Availability WHERE slot_ID='$slot_ID' AND hawk_ID='$hawk_ID'";
    
    // run the delete statement
    queryDB($deletequery, $db);
        
    // send a response back to angular
    $response = array();
    $response['status'] = 'success';
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