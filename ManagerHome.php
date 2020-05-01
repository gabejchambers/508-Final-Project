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

    <!--new employee sign up button:-->
    <form method="POST" action="EmployeeSignUp.php">
        <input type="submit" value="Add New Employee">
    </form>
    <br>
    <!--fire button:-->
    <form method="POST" action="FireEmployee.php">
        <input type="submit" value="Remove Employee">
    </form>
    <br>
    <!--New supervisor/subordinate button:-->
    <form method="POST" action="AddSupervisorSubordinate.php">
        <input type="submit" value="New Supervisor/Subordinate">
    </form>
    <br>
    <!--update inventory button:-->
    <form method="POST" action="UpdateInventory.php">
        <input type="submit" value="Update Invenotry">
    </form>
    <br>
    <!--update manager button:-->
    <form method="POST" action="SetStoreManager.php">
        <input type="submit" value="Set Store Manager">
    </form>
    <br>



    <?php
    mysqli_close($conn);
    ?>
</div>
</body>
</html>
