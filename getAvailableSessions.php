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
    // set up query to get available sessions created by the tutor that is currently logged in
    $query = "SELECT slot_ID, available_date, scheduled FROM Tutor_Availability WHERE hawk_ID='$hawk_ID';";
} else if ($accountType == 'student') {
    // set up query to get available sessions with the same course_ID that the logged in student has
    $query = "SELECT slot_ID, available_date, scheduled, name FROM Tutor_Availability JOIN Tutor on Tutor.hawk_ID=Tutor_Availability.hawk_ID JOIN Account ON Tutor_Availability.hawk_ID=Account.hawk_ID WHERE Tutor.course_ID=(SELECT course_ID FROM Student WHERE hawk_ID='$hawk_ID');";
}

//run the query to get info on sessions
$result = queryDB($query, $db);

//assign results to an array we can then send back
$sessions = array();
$i = 0;

// go through the results one by one
while ($currSession = nextTuple($result)) {
    // don't include passed or scheduled sessions
    if(strtotime($currSession['available_date']) >= strtotime('now') && !$currSession['scheduled']) {
        $sessions[$i] = $currSession;
    }

    $i++;
}

//put together a JSON object to send back the data on the sessions
$response = array();
$response['status'] = 'success';
$response['value']['sessions'] = $sessions;
header('Content-Type: application/json');
echo(json_encode($response));



?>