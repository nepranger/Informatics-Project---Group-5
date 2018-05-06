<?php

// We need to include these two files in order to work with the database
include_once('config.php');
include_once('dbutils.php');


// get a handle to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

// get data from the angular controller
// decode the json object
$slot_ID = json_decode(file_get_contents('php://input'), true);


// set up variables to handle errors
// is complete will be false if we find any problems when checking on the data
$isComplete = true;

// error message we'll send back to angular if we run into any problems
$errorMessage = "error";

//
// Validation
//

// check if id is present
if (!isset($slot_ID)) {
    $isComplete = false;
    $errorMessage .= "Must include slot ID";
} else {
    $slot_ID = makeStringSafe($db, $slot_ID);
}
//needed to differentiate
session_start();
$student_hawk_ID = $_SESSION['username'];
$account_type = $_SESSION['accountType'];

// check if the user is a student
if (!isset($account_type) || $account_type != 'student') {
    $isComplete = false;
    $errorMessage .= "You must be a student to sign up for a session.";
}

// get Tutor_Available info to fill in Tutor_session info-- remember to join tables
if ($isComplete) {
    $query = "SELECT * FROM Tutor_Availability JOIN Tutor ON Tutor.hawk_ID=Tutor_Availability.hawk_ID WHERE slot_ID='$slot_ID';";

    //run the query to get info on session
    $result = queryDB($query, $db);
    $availSession = nextTuple($result);

    //take the attributes we need from the result
    $tutor_hawk_ID = $availSession['hawk_ID'];
    $session_date = $availSession['available_date'];
    $course_ID = $availSession['course_ID'];    

    //make sure session hasn't been scheduled
    if ($availSession['scheduled']) {
        $isComplete = false;
        $errorMessage .= "This session is already taken.";    
    }
}

// if we got this far and $isComplete is true it means we should add the scheduled session
if ($isComplete) {
    // Set available session to scheduled
    $updateQuery = "UPDATE Tutor_Availability SET scheduled=1 WHERE slot_ID='$slot_ID';";
    queryDB($updateQuery, $db);-
// student budget 
    $updateQuery = "UPDATE Student SET budget= budget-1 WHERE hawk_ID='$hawk_ID';";
    queryDB($updateQuery, $db);  

    $insertquery = "INSERT INTO Tutor_Session(tutor_hawk_ID, student_hawk_ID, course_ID, session_date, slot_ID) VALUES ('$tutor_hawk_ID', '$student_hawk_ID', '$course_ID', '$session_date', '$slot_ID')";

    // run the insert statement
    queryDB($insertquery, $db);
    
    // get the id of the session we just entered
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
    var_dump($slot_ID);
    $postdump = ob_get_clean();
    
    // set up our response array
    $response = array();
    $response['status'] = 'error';
    $response['message'] = $errorMessage . $postdump;
    header('Content-Type: application/json');
    echo(json_encode($response));    
}

?>