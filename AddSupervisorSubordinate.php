<!DOCTYPE html>
<html>
<head><title>Remove Employee</title></head>
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
#trim user input for sql injectios
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<?php
if (isset($_POST['submit_sup'])) {
    $sup_EID = $emp_EID = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sup_EID = test_input($_POST["sup_EID"]);
        $emp_EID = test_input($_POST["emp_EID"]);
    }
}
?>

<h2>New Supervisor/Employee Relationship</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Supervisor EID: <input type="text" name="sup_EID">
    <br><br>
    Subordinate EID: <input type="text" name="emp_EID">
    <br><br>
    <input type="submit" name="submit_sup" value="Submit">
</form>

<?php
if (isset($_POST['submit_sup'])) {#did they click submit?
    $sql = "insert into Supervise values ('".$sup_EID."', '".$emp_EID."')";
    if(mysqli_query($conn, $sql))
    {
        echo "Assigned successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>



<?php
mysqli_close($conn);
?>
</body>
</html>
