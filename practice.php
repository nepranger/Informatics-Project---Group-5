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

// 
$practice_problems = $data['practice_problems'];


// set up variables to handle errors
// is complete will be false if we find any problems when checking on the data
$isComplete = true;

// error message we'll send back to angular if we run into any problems
$errorMessage = "error";

//
// Validation
//

// check if username meets criteria
if (!isset($practice_problems) || (strlen($practice_problems) < 2)) {
    $isComplete = false;
    $errorMessage .= "Please enter a username with at least two characters. ";
} else {
    $isComplete = true;
    $practice_problems = makeStringSafe($db, $practice_problems);
}


if ($isComplete) {
        
    $insertquery = 'INSERT INTO Problem_Set(course_ID, text_box) VALUES ("CS:1110", "'.$practice_problems.'");';
        
    // run the insert statement
    queryDB($insertquery, $db);
    
      
    // get the id of the account we just entered
    $accountid = mysqli_insert_id($db);
        
    // send a response back to angular
    $response = array();
    $response['status'] = 'success';
    $response['id'] = $accountid;
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