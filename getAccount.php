<?php

//we need to include these two files in order to work with the datbase
include_once('config.php');
include_once('dbutils.php');

//Get a connection to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

//Set up a query to get information on movies
$query = "SELECT * FROM Account";

    //hawk_ID VARCHAR(120) NOT NULL,
    //hashedpass VARCHAR(255) NOT NULL,
    //name VARCHAR(120) NOT NULL,
    //administrator BIT DEFAULT 0,
    //PRIMARY KEY(hawk_ID)

//run the query to get info on players
$result = queryDB($query, $db);

//assign results to an array we can then send back
$accounts = array();
$i = 0;

// go through the results one by one
while ($currAccount = nextTuple($result)) {
    $accounts[$i] = $currAccount;
    $i++;
}

//put together a JSON object to send back the data on the movies
$response = array();
$response['status'] = 'success';
$response['value']['accounts'] = $accounts;
header('Content-Type: application/json');
echo(json_encode($response));



?>
