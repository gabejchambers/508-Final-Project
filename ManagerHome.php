<!DOCTYPE html>
<html>
<head>
    <title>Manager Home</title>
</head>
<body>
<br>
<form method="POST" action="Logout.php">
    <input type="submit" value="Logout">
</form>
<br>
<form method="POST" action="ManagerProfile.php">
    <input type="submit" value="Profile">
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
    if (!isset($_SESSION['e_loggedin'])) {
        header('Location: index.php');
        exit;
    }
    ?>

    <h2>Home Page</h2>
    <p>Welcome back, <?=$_SESSION['e_name']?>!</p>

    <form method="POST" action="EmployeeSignUp.php">
        <input type="submit" value="Add New Employee">
    </form>

    <?php
    mysqli_close($conn);
    ?>
</div>
</body>
</html>