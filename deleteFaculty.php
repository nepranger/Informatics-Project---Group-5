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

// 'name' matches the name attribute in the form
$hawk_ID = $data['hawk_ID'];


// set up variables to handle errors
// is complete will be false if we find any problems when checking on the data
$isComplete = true;

// error message we'll send back to angular if we run into any problems
$errorMessage = "";

//
// Validation
//

// check if id got sent
if (!isset($hawk_ID)) {
    $isComplete = false;
    $errorMessage .= "The deleteFaculty.php file requires a hawk_ID to be sent. ";
}

// check if we there is a record in the database matching the id
if ($isComplete) {
    // set up a query to check if the hawk_id passed to this file corresponds to a record in the database
    $query = "SELECT hawk_ID FROM Faculty WHERE hawk_ID='$hawk_ID'";
    
    // we need to run the query
    $result = queryDB($query, $db);
    
    // check on the number of records returned
    if (nTuples($result) == 0) {
        // if we get no recors back, it means no records match the id that we got
        $isComplete = false;
        $errorMessage .= "The hawk_ID $hawk_ID did not match any records in the Faculty table. ";
    }
}

// if we got this far and $isComplete is true it means we should delete the player from the database
if ($isComplete) {
    // we will set up the delate statement to remove the player from the database
    $deletequery = "DELETE FROM Faculty WHERE hawk_ID='$hawk_ID'";
    
    // run the delete statement
    queryDB($deletequery, $db);

    // we will set up the delate statement to remove the player from the database
    $deletequery = "DELETE FROM Account WHERE hawk_ID='$hawk_ID'";
    
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