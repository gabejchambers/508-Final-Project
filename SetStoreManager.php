<!DOCTYPE html>
<html>
<head><title>Set Manager</title></head>
<!--manager access header-->
<?php
session_start();
include_once 'dbconnect.php';

if ((!isset($_SESSION['e_loggedin'])) OR (!$_SESSION['ismanager'])) {
    header('Location: logout.php');
    exit;
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
if (isset($_POST['submit_man'])) {
    $SID = $man_EID = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $SID = test_input($_POST["SID"]);
        $man_EID = test_input($_POST["man_EID"]);
    }
}
?>

<h2>Set Store Manager:</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Store ID: <input type="text" name="SID">
    <br><br>
    New Manager ID: <input type="text" name="man_EID">
    <br><br>
    <input type="submit" name="submit_man" value="Submit">
</form>

<?php
if (isset($_POST['submit_man'])) {#did they click submit?
    $sql = "update Store set manager = '".$man_EID."' where SID = '".$SID."'";
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
