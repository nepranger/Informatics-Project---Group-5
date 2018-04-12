<?php


//we need to include these two files in order to work with the datbase
include_once('config.php');
include_once('dbutils.php');

echo crypt("hawkeyes", getsalt());
echo "\n"
?>
