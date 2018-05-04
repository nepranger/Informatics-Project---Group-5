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

// check if name meets criteria
if (!isset($hawk_ID) || (strlen($hawk_ID) < 5)) {
    $isComplete = false;
    $errorMessage .= "Please enter a hawk_ID with at least five characters. ";
} else {
    $hawk_ID = makeStringSafe($db, $hawk_ID);
}




// check if we already have a user with the same hawk_ID
if ($isComplete) {
    // set up a query to check if this user is in the database already
    $query = "SELECT hawk_ID FROM Student WHERE hawk_ID='$hawk_ID'";
    
    // we need to run the query
    $result = queryDB($query, $db);
    
    // check on the number of records returned
    if (nTuples($result) > 0) {
        // if we get at least one record back it means the user is already in the database, so we have a duplicate
        $isComplete = false;
        $errorMessage .= "The user $hawk_ID is already in the database. ";
    }
}


// check if the id passed to this api corresponds to an existing record in the database
if ($isComplete) {
    // set up a query to check if this user is in the database already
    $query = "SELECT hawk_ID FROM Student WHERE hawk_ID='$hawk_ID'";
    
    // we need to run the query
    $result = queryDB($query, $db);
    
    // check on the number of records returned
    if (nTuples($result) == 0) {
        // if we get no results it means the id we got does not correspond to any records in the Student table
        $isComplete = false;
        $errorMessage .= "The hawk_ID $hawk_ID does not correspond to any users in the Student table. ";
    }
}


// if we got this far and $isComplete is true it means we should edit the user in the database
if ($isComplete) {
    // we will set up the insert statement to add this new record to the database
    $updatequery = "UPDATE Student SET hawk_ID='$hawk_ID'";
    
    // run the update statement
    queryDB($updatequery, $db);
    
    // we will set up the insert statement to add this new record to the database
    $updatequery = "UPDATE Account SET hawk_ID='$hawk_ID'";
    
    // run the update statement
    queryDB($updatequery, $db)
    
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