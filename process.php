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


#Inserting data w php
/* This worked!
    $sql = "INSERT INTO Employee
        VALUES ('5656', '372e25f23b5a8ae33c5ba203412ace30', '1600', 'Hannah', 400.00, '12 Your Street')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
*/

$fromform = $_GET['data'];
    echo $fromform;


#Query w php:
$sql = "SELECT name, salary FROM Employee WHERE EID = 5656";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Name: " . $row["name"]. " - Salary: " . $row["salary"]. "<br>";
    }
} else {
    echo "0 results";
}


echo "Connected successfully";
mysqli_close($conn);
?>