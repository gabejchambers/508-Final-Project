<!DOCTYPE html>
<html>
<body>
<div>Process Page</div>
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

    echo "php load successfully<br>";

    mysqli_close($conn);
    ?>
</div>


<form method="POST" action="index.php">
    <input type="submit" value="Index">
</form>

</body>
</html>
