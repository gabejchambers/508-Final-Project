<!DOCTYPE html>
<html>
<head>
    <title>Update Inventory</title>
</head>
<!--standard employee header-->
<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['e_loggedin'])) {
    header('Location: index.php');
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

<!-- home button take you differnet page depending on manager or employee-->
<?php if($_SESSION['ismanager']){
?>
    <form method="POST" action="ManagerHome.php">
        <input type="submit" value="Home">
    </form>
    <br>
<?php } else { ?>
    <form method="POST" action="EmployeeHome.php">
        <input type="submit" value="Home">
    </form>
    <br>
<?php } ?>



<div>
    <?php
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
</div>
<?php
if (isset($_POST['submit_frm'])) {
    $ISBN = $quantity = $location = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ISBN = test_input($_POST["ISBN"]);
        $location = test_input($_POST["location"]);
        $quantity = test_input($_POST["quantity"]);
    }
}
?>
<h2>Sign Up</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    ISBN: <input type="text" name="ISBN">
    <br><br>
    Store ID: <input type="text" name="location">
    <br><br>
    Quantity: <input type="text" name="quantity">
    <br><br>
    <input type="submit" name="submit_frm" value="Submit">
</form>

<?php
if (isset($_POST['submit_frm'])) {
    #if a quantity for that book/store pair already exists, delete it:
    $isi_sql = "select * from Inventory where ISBN = '".$ISBN."' and store = '".$location."'";
    $isi_result = mysqli_query($conn, $isi_sql);
    if(mysqli_num_rows($isi_result)!=0) {
        #set manager of their store to null
        $inventory_rows = mysqli_fetch_assoc($isi_result);
        $delete_inv_query = "delete from Inventory where ISBN = '".$ISBN."' and store = '".$location."'";
        if (!mysqli_query($conn, $delete_inv_query)) { echo "Error: " . $sql . "<br>" . mysqli_error($conn); }
    }

    #insert new quantity for the book/store pair
    $sql = "insert into Inventory values ('".$ISBN."', '".$location."', '".$quantity."')";
    if(mysqli_query($conn, $sql))
    {
        echo "Inventory updated successfully";
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

