<!DOCTYPE html>
<html>
<head>
    <title>Customer Home</title>
</head>
<body>
<br>
<form method="POST" action="Logout.php">
    <input type="submit" value="Logout">
</form>
<br>
<form method="POST" action="CustomerProfile.php">
    <input type="submit" value="Profile">
</form>
<br>
<div>
    <?php
    include_once 'dbconnect.php';

    // We need to use sessions, so you should always start sessions using the below code.
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['c_loggedin'])) {
        header('Location: index.php');
        exit;
    }
    ?>

    <h2>Home Page</h2>
    <p>Welcome back, <?=$_SESSION['c_email']?>!</p>

    <?php
    mysqli_close($conn);
    ?>
</div>
</body>
</html>
