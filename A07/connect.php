<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = ""; 
$db = "accountsystem";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connection failed: %s\n" . $conn->error);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
    echo "Can't connect to database";
}

function executeQuery($query) {
    $conn = $GLOBALS['conn'];
    return mysqli_query($conn, $query);
}
?>