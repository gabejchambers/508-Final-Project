<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
</head>
<body>
<div>Go to Process page (temp page just seeing how this works)</div>
<form method="POST" action="process.php">
    <input type="submit" value="Process">
</form>

<br>
<div>Type something here:</div>
<form method="post" name="form" action="index.php">
    <input type="text" placeholder="just testing stuff" name="data">
    <input type="submit" value="Submit">
</form>

<div>It'll appear here: </div>
<div>
    <?php

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

    if (isset($_POST['data'])) {
        $fromform = $_POST['data'];
        echo $fromform;
        echo "<br>";
    }

    echo "<br>This is a php query with formatted output:<br>";
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

    mysqli_close($conn);
    ?>
</div>

<br>
<div>Find emp name from emp id and open in new page:</div>
<form method="post" name="form" action="findemp.php">
    <input type="text" placeholder="Enter Employee ID" name="id_in">
    <input type="submit" value="Search">
</form>
<br>

<div>Find emp name from emp id and open in this page:</div>
<form method="post" name="form" action="index.php">
    <input type="text" placeholder="Enter Employee ID" name="id_in_same">
    <input type="submit" value="Search">
</form>
<br>
<div>
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

    if (isset($_POST['id_in_same'])) {
        $idin = $_POST['id_in_same'];


        #Query w php and php variable:
        $sql = "SELECT name FROM Employee WHERE EID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $idin);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "Name: " . $row["name"] . "<br>";
            }
        } else {
            echo "0 results";
        }
    }


    mysqli_close($conn);
    ?>
</div>


</body>
</html>




