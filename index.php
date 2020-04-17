<?php
    #phpinfo();

    $servername = "project_15@3.234.246.29";
    #$username = "project_15";
    $password = "V00827834";

    // Create connection
    #$conn = new mysqli($servername, $username, $password);
    $conn = new mysqli($servername, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
?>