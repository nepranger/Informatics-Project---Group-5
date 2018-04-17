<<<<<<< HEAD
<?php

//log in user by checking whether the session variable username is set

$isloggedin = false;
$username = "not logged in";

session_start();
if (isset($_SESSION['username'])) {
    //if the session variable username is set, then we are logged in
    $isloggedin = true;
    $username = $_SESSION['username'];  
}

//send response back
$response = array();
$response['status'] = 'success';
$response['loggedin'] = $isloggedin;
$response['username'] = $username;
header('Content-Type: application/json');
echo(json_encode($response));




=======
<?php

//log in user by checking whether the session variable username is set

$isloggedin = false;
$username = "not logged in";

session_start();
if (isset($_SESSION['username'])) {
    //if the session variable username is set, then we are logged in
    $isloggedin = true;
    $username = $_SESSION['username'];  
}

//send response back
$response = array();
$response['status'] = 'success';
$response['loggedin'] = $isloggedin;
$response['username'] = $username;
header('Content-Type: application/json');
echo(json_encode($response));




>>>>>>> d05e94baa4d18daaa065144df5d1fe02991494d1
?>