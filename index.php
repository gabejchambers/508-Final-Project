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


    $sql = "INSERT INTO Employee 
        VALUES ('4444', '372e25f23b5a8ae33c7ba203412ace30', '3342', 'Hugo', 3400.00, '1 Your Street')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }


    $sql2 = "INSERT INTO Store VALUES ('3342', '321 North Street', '4444')";
    if (mysqli_query($conn, $sql2)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>