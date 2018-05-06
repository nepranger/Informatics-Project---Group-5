<?php



//we need to include these two files in order to work with the datbase
include_once('config.php');
include_once('dbutils.php');

//Get a connection to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

//Set up a query to get information on student
$query = "SELECT * FROM Student";

//run the query to get info on students
$result = queryDB($query, $db);

//assign results to an array we can then send back
$students = array();
$i = 0;

// go through the results one by one
while ($currStudent = nextTuple($result)) {
    $students[$i] = $currStudent;
    $i++;
}

//put together a JSON object to send back the data on the students
$response = array();
$response['status'] = 'success';
$response['value']['students'] = $students;
header('Content-Type: application/json');
echo(json_encode($response));



?>
