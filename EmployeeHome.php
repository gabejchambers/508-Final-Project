<!DOCTYPE html>
<html>
<head>
    <title>Employee Home</title>
</head>
<body>
<br>
<form method="POST" action="Logout.php">
    <input type="submit" value="Logout">
</form>
<br>
<form method="POST" action="EmployeeProfile.php">
    <input type="submit" value="Profile">
</form>
<br>
<div>
    <?php
    include_once 'dbconnect.php';

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

<!--update inventory button:-->
<form method="POST" action="UpdateInventory.php">
    <input type="submit" value="Update Invenotry">
</form>
<br>

<?php
    mysqli_close($conn);
?>
</div>
</body>
</html>
