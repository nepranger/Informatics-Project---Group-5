<?php

//we need to include these two files in order to work with the datbase
include_once('config.php');
include_once('dbutils.php');

//Get a connection to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

session_start();
$hawk_ID = $_SESSION['username'];

//Set up a query to get information on movies
$query = "SELECT Course.course_ID, Course.course_name, Course.course_number, Course.course_section FROM Course, Student WHERE Student.hawk_ID = '$hawk_ID' AND Student.course_ID = Course.course_ID";

    //course_ID VARCHAR(120) NOT NULL,
    //course_name VARCHAR(255) NOT NULL,
    //course_number VARCHAR(120) NOT NULL,
    //course_section VARCHAR(255) NOT NULL,

//run the query to get info on players
$result = queryDB($query, $db);

//assign results to an array we can then send back
$students = array();
$i = 0;

// go through the results one by one
while ($scurrCourse = nextTuple($result)) {
    $scourses[$i] = $scurrCourse;
    $i++;
}

//put together a JSON object to send back the data on the students
$response = array();
$response['status'] = 'success';
$response['value']['scourses'] = $scourses;
header('Content-Type: application/json');
echo(json_encode($response));

?>
