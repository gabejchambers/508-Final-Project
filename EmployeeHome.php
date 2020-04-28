<!DOCTYPE html>
<html>
<head>
    <title>Employee Home</title>
</head>
<body>
<br>
<form method="POST" action="index.php">
    <input type="submit" value="Index">
</form>
<br>
<div>
    <?php
    session_start();
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
    if ( !isset($_POST['EID'], $_POST['e_pw']) ) {
        // Could not get the data that should have been sent.
        exit('Please fill both the username and password fields!');
    } else {
        echo "correct ish";
        echo "<br>";
        echo $_POST['EID'];
    }

    mysqli_close($conn);
    ?>
</div>
</body>
</html>
