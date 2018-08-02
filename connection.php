<?php

$servername = "localhost";
$username = "";
$password = "";
$database = "";

// Create connection for integration
$conn_integration = mysqli_connect($servername, $username, $password, $database);

// Check connection for integration
if (!$conn_integration) 
{
    die("Connection failed: " . mysqli_connect_error());
} 
else 
{
    echo "Database connected successfully!";
}

