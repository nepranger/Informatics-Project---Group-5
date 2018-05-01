<?php

//we need to include these two files in order to work with the datbase
include_once('config.php');
include_once('dbutils.php');

//Get a connection to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

//get hawk_id to find the right sessions
session_start();
$hawk_ID = $_SESSION['username'];
$accountType = $_SESSION['accountType'];

if($accountType == 'tutor') {
    //Set up a query to get information on available sessions for student
    $query = "SELECT session_ID, session_date, cancelled_By_Tutor, cancelled_By_Student, slot_ID, name FROM Tutor_Session JOIN Account on Account.hawk_ID=Tutor_Session.student_hawk_ID WHERE Tutor_Session.tutor_hawk_ID='$hawk_ID';";
} else if ($accountType == 'student') {
    //Set up a query to get information on available sessions for tutor
    $query = "SELECT session_ID, session_date, cancelled_By_Tutor, cancelled_By_Student, slot_ID, name FROM Tutor_Session JOIN Account on Account.hawk_ID=Tutor_Session.tutor_hawk_ID WHERE Tutor_Session.student_hawk_ID='$hawk_ID';";
}

//run the query to get info on sessions
$result = queryDB($query, $db);

//assign results to an array we can then send back
$sessions = array();
$i = 0;

// go through the results one by one
while ($currSession = nextTuple($result)) {
    // don't include passed sessions
    if(strtotime($currSession['session_date']) >= strtotime('now')) {
        $sessions[$i] = $currSession;
    }

    $i++;
}

//put together a JSON object to send back the data on the sessions
$response = array();
$response['status'] = 'success';
$response['value']['sessions'] = $sessions;
$response['accountType'] = $hawk_ID;
header('Content-Type: application/json');
echo(json_encode($response));



?>