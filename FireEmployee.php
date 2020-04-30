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
        
        #if firing a manager:
        $ism_sql = "select * from Store s, Employee e where e.EID = s.manager and e.EID = '".$EID."'";
        $ism_result = mysqli_query($conn, $ism_sql);
        if(mysqli_num_rows($ism_result)!=0) {
            #set manager of their store to null
            $store_manager_rows = mysqli_fetch_assoc($ism_result);
            $man_to_null_query = "update Store set manager = null WHERE manager = '".$EID."'";
            if (!mysqli_query($conn, $man_to_null_query)) { echo "Error: " . $sql . "<br>" . mysqli_error($conn); }
        }
        
        #if firing a supervisor or someone who is supervised:
        $iss_sql = "select * from Supervise where shift_lead = '".$EID."' or employee = '".$EID."'";
        $iss_result = mysqli_query($conn, $iss_sql);
        if(mysqli_num_rows($iss_result)!=0) { #if they are a supervisor
            #delete the entries is supervisors that they occur
            while($sup_rows = $iss_result->fetch_assoc()) {
                $sup_delete_query = "delete from Supervise where shift_lead = '".$sup_rows['shift_lead']."' and employee = '".$sup_rows['employee']."'";
                if (!mysqli_query($conn, $sup_delete_query)) { echo "Error: " . $sql . "<br>" . mysqli_error($conn); }
            }
        }
        
        
        #if firing an employee who has made a transaction:
        $isc_sql = "select * from Transaction where cashier = '".$EID."'";
        $isc_result = mysqli_query($conn, $isc_sql);
        if(mysqli_num_rows($isc_result)!=0) { #if they have done a transaction
            #remove them from being cashier
            while($sup_rows = $isc_result->fetch_assoc()) {
                $sup_delete_query = "update Transaction set cashier = null WHERE cashier = '".$EID."'";
                if (!mysqli_query($conn, $sup_delete_query)) { echo "Error: " . $sql . "<br>" . mysqli_error($conn); }
            }
        }
        

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