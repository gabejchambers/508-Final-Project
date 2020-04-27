<!DOCTYPE html>
<html>
<body>
<div>Employee Name</div>
<div>
    <?php
    #phpinfo();

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

    $idin = $_POST['id_in'];

    #Query w php and php variable:
    $sql = "SELECT name FROM Employee WHERE EID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idin);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "Name: " . $row["name"]. "<br>";
        }
    } else {
        echo "0 results";
    }


    mysqli_close($conn);
    ?>
</div>


<form method="POST" action="index.php">
    <input type="submit" value="Index">
</form>

</body>
</html>
