<!DOCTYPE html>
<html>
<head>
    <title>Employee Home</title>
</head>
<body>
<h2>Home Page</h2>
<p>Welcome back, <?=$_SESSION['name']?>!</p>
<br>
<form method="POST" action="index.php">
    <input type="submit" value="Index">
</form>
<br>
<div>
    <?php
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


    // We need to use sessions, so you should always start sessions using the below code.
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit;
    }


    mysqli_close($conn);
    ?>
</div>
</body>
</html>
