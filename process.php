<!DOCTYPE html>
<html>
<body>
<div>Process Page</div>
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

    echo "php load successfully<br>";

    mysqli_close($conn);
    ?>
</div>


<form method="POST" action="index.php">
    <input type="submit" value="Index">
</form>

</body>
</html>
