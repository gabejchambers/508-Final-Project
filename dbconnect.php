<?php

//replace this on each page with include_once <<filename>>
$servername = "localhost";
$db_username = "project_15";
$db_password = "V00827834";
$dbname = "project_15";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}