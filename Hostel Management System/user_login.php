<?php
// Database configuration
$dbHost     = 'localhost'; // Database host
$dbUsername = 'root'; // Database username
$dbPassword = ''; // Database password
$dbName     = 'userlogin'; // Database name

// Create database connection
$scon = mysqli_connect($localhost, $root, $, $userlogin);

// Check connection
if (!$scon) {
    die("Connection failed: " . mysqli_connect_error());
}
