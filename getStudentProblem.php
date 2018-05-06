<?php

//we need to include these two files in order to work with the datbase
include_once('config.php');
include_once('dbutils.php');

//Get a connection to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

//Set up a query to get information on course
$query = "SELECT * FROM Problem_Set";

//run the query to get info on course
$result = queryDB($query, $db);

//assign results to an array we can then send back
$students = array();
$i = 0;

// go through the results one by one
while ($currCourse = nextTuple($result)) {
    $courses[$i] = $currCourse;
    $i++;
}

//put together a JSON object to send back the data on the courses
$response = array();
$response['status'] = 'success';
$response['value']['courses'] = $courses;
header('Content-Type: application/json');
echo(json_encode($response));

?>
