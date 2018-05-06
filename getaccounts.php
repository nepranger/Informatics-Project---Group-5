<?php

//we need to include these two files in order to work with the datbase
include_once('config.php');
include_once('dbutils.php');

//Get a connection to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

$query = "SELECT * FROM Account;";

$result = queryDB($query, $db);

//assign results to an array we can then send back
$accounts = array();
$i = 0;

// go through the results one by one
while ($currAccount = nextTuple($result)) {
    $accounts[$i] = $currAccount;
    $i++;
}

//put together a JSON object to send back the data 
$response = array();
$response['status'] = 'success';
$response['value']['titles'] = $movies;
header('Content-Type: application/json');
echo(json_encode($response));



?>