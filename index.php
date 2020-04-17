<?php
    #phpinfo();

    $servername = "localhost";
    $username = "project_15";
    $password = "V00827834";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
    echo "what it do boy";
?>