<?php
#phpinfo();

$servername = "localhost";
$username = "project_15";
$password = "V00827834";
$dbname = "project_15";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$intext = $_POST['data'];

echo "other page Connected successfully";
mysqli_close($conn);
?>