<?php

//log in user by checking whether the session variable username is set

$isloggedin = false;
$hawk_ID = "not logged in";

session_start();
if (isset($_SESSION['username'])) {
    //if the session variable username is set, then we are logged in
    $isloggedin = true;
    $hawk_ID = $_SESSION['username'];  
}

//send response back
$response = array();
$response['status'] = 'success';
$response['loggedin'] = $isloggedin;
$response['username'] = $hawk_ID;
header('Content-Type: application/json');
echo(json_encode($response));




?>
