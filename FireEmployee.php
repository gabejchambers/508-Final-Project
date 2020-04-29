<!DOCTYPE html>
<html>
<head><title>Employee Sign Up</title></head>
<!--manager access header-->
<?php
session_start();
if ((!isset($_SESSION['e_loggedin'])) OR (!$_SESSION['ismanager'])) {
    header('Location: logout.php');
    exit;
}
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
?>
<body>
<br>
<form method="POST" action="Logout.php">
    <input type="submit" value="Logout">
</form>
<br>

<form method="POST" action="ManagerHome.php">
    <input type="submit" value="Home">
</form>
<br>
<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<?php
if (isset($_POST['submit_fire'])) {
    $EID = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $EID = test_input($_POST["EID"]);
    }
}
?>
<h2>Fire Employee</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    EID: <input type="text" name="EID">
    <br><br>
    <input type="submit" name="submit_fire" value="Submit">
</form>

<?php
if (isset($_POST['submit_fire'])) {
    if($EID != _SESSION['id']) {
        $sql = "delete from Employee where EID = '" . $EID . "')";
        if (mysqli_query($conn, $sql)) {
            echo "Registration successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {#if the user is trying to fire themselves:
        echo "Don't fire yourself";
    }
}
mysqli_close($conn);
?>

</body>
</html>
