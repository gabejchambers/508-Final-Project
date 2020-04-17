<?php
    #phpinfo();

    $servername = "http://3.234.246.29/~project_15/508-Final-Project/index.php";
    $username = "project_15";
    $password = "V00827834";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
?>