<!DOCTYPE html>
<html>
<head><title>Remove Employee</title></head>
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
if (isset($_POST['submit_fire'])) {
    $EID = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $EID = test_input($_POST["EID"]);
    }
}
?>

<h2>Remove Employee</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    EID: <input type="text" name="EID">
    <br><br>
    <input type="submit" name="submit_fire" value="Submit">
</form>

<?php
if (isset($_POST['submit_fire'])) {#did they click submit?
    if($EID != $_SESSION['e_id']) {#are you trying to fire yourself?
        
        #triggers an sql trigger which checks and handles if the employee is used
        #as a FK in relations: Supervise, Transaction, Store. trigger name delete_employee_check
        $sql = "delete from Employee where EID = '" . $EID . "'";
        if (mysqli_query($conn, $sql)) {#if query is successfully run
            echo "Removed successfully";
        } else {#if query couldnt be completed
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
