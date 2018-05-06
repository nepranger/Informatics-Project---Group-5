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
if (!isset($hawk_ID) || (strlen($hawk_ID) < 2)) {
    $isComplete = false;
    $errorMessage .= "Please enter a title with at least two characters. ";
} else {
    $title = makeStringSafe($db, $hawk_ID);
}




// check if we already have a player with the same name, country, and club as the one we are processing
if ($isComplete) {
    // set up a query to check if this player is in the database already
    $query = "SELECT hawk_ID FROM tables WHERE hawk_ID='$hawk_ID';
    
    // we need to run the query
    $result = queryDB($query, $db);
    
    // check on the number of records returned
    if (nTuples($result) > 0) {
        // if we get at least one record back it means the player is already in the database, so we have a duplicate
        $isComplete = false;
        $errorMessage .= "The movie $title, with $director, from the year $year1 is already in the database. ";
    }
}

// if we got this far and $isComplete is true it means we should add the player to the database
if ($isComplete) {
    // we will set up the insert statement to add this new record to the database
    $insertquery = "INSERT INTO Account(hawk_ID, director, year1, video) VALUES ('$hawk_ID')";
    
    // run the insert statement
    queryDB($insertquery, $db);
    
    // get the id of the player we just entered
    $movieid = mysqli_insert_id($db);
    
    // send a response back to angular
    $response = array();
    $response['status'] = 'success';
    $response['id'] = $movieid;
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