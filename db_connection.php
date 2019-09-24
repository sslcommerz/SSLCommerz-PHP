<?php

$servername = "localhost";
$username = "<DB_USERNAME>"; // Put the MySQL Username
$password = "<DB_PASSWORD>"; // Put the MySQL Password
$database = "<DB_NAME>"; // Put the Database Name

// Create connection for integration
$conn_integration = mysqli_connect($servername, $username, $password, $database);

// Check connection for integration
if (!$conn_integration) {
    die("Connection failed: " . mysqli_connect_error());
}

