<?php
// NOTE CHANGE THIS FILE LOGIN.PHP TO ESSENTIALLY THE SAME AS THE HOMEWORK BUT JUST LOOK AT THE QUERIES.
//In order to check for different account types we have to write different queriers for each account type here in login.php

//we need to include these files in order to work with the database
include_once('config.php');
include_once('dbutils.php');

//get a handle to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

//retrieve data from the angular controller
//decode the json object
$data = json_decode(file_get_contents('php://input'), true);

//get each piece of data
$hawk_ID = $data['username'];
$password = $data['password'];

//set up variables to handle errors
//is complete will be false if we find any problems when checking the data
$isComplete = true;

//error message we will send back to angular if we have any problems
$errorMessage = "";

//
// Validation
//

//check if hawkid, hashedpass, and name meet criteria
if (!isset($hawk_ID) || (strlen($hawk_ID) < 2)){
    $isComplete = false;
    $errorMessage .= "Please enter a HawkID with at least two characters.";
    
} else {
    $title = makeStringSafe($db, $hawk_ID);
    
}


if (!isset($password) || (strlen($password)< 6)){
    $isComplete = false;
    $errorMessage .= "Please enter a password with at least six characters. ";
    
    
} else


//check if we already have a hawkId that matches the one entered.
if($isComplete){
    //set up a query to check if this username is in the database
    $query = "SELECT hawk_ID, hashedpass FROM Account WHERE hawk_ID = '$hawk_ID'";
    
    //we need to now run the query
    $result = queryDB($query, $db);
    
    //make sure the hawkID is correct here
    if (nTuples($result) ==0){
        $errorMessage .= "The HawkID $hawk_ID, does not correspond to any account in the system. ";
        $isComplete = false;
        
    }
}

if ($isComplete){
    //there is an account that corresponds to the HawkID that the user entered
    //get the hashed password for that account
    $row = nextTuple($result);
    $hashedpass = $row['hashedpass'];
    $hawk_ID = $row['hawk_ID'];
    
    //compare entered password to the password on the database
    if ($hashedpass != crypt($password, $hashedpass)){
        //if password is incorrect
        $errorMessage .= "The password you entered is incorrect. ";
        $isComplete = false;
        
    }
}
if ($isComplete){
    //password was correctly entered
    
    //CHECK WHAT ACCOUNT TYPE/ROLE THEY ARE HERE -- AKA PUT THE QUERIES FOR THE OTHER ACCOUNT TYPES HERE!
    
    //start a session
    //if the session variable hawkID is set, then we assume that the user is logged in.
    $_SESSION['username'] = $hawk_ID;
    
    //send a response back
    $response = array();
    $response['status'] = 'success';
    $response['message'] = 'logged in';
    header('Content-Type: application/json');
    echo(json_encode($response));
} else {
    //there's been an error. we need to report it to the angular controller.
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
