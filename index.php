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
    echo "Connected successfully\n";
    echo "what it do boy";

/* This worked!
    $sql = "INSERT INTO Employee 
        VALUES ('5656', '372e25f23b5a8ae33c5ba203412ace30', '1600', 'Hannah', 400.00, '12 Your Street')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
*/

    mysqli_close($conn);
?>