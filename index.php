<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
</head>
<body>

<h2>Example Templates:</h2>
<div>
    <?php
    include_once 'dbconnect.php';
    session_start();
    ?>

    <?php if(isset($_SESSION['c_loggedin'])){
        ?>
        <form method="POST" action="Logout.php">
            <input type="submit" value="Logout">
        </form>
        <br>
        <form method="POST" action="CustomerHome.php">
            <input type="submit" value="Home">
        </form>
        <br>
    <?php } elseif (isset($_SESSION['e_loggedin'])) { ?>
    <form method="POST" action="Logout.php">
        <input type="submit" value="Logout">
    </form>
    <?php
        if($_SESSION['ismanager']){
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
        <br>
    <?php } ?>
</div>

<br>
<div>Find emp name from emp id and open in new page (ex 1111 is valid id):</div>
<form method="post" name="form" action="findemp.php">
    <input type="text" placeholder="Enter Employee ID" name="id_in">
    <input type="submit" value="Search">
</form>
<br>

<div>Find emp name from emp id and display in this page:</div>
<form method="post" name="form" action="index.php">
    <input type="text" placeholder="Enter Employee ID" name="id_in_same">
    <input type="submit" value="Search">
</form>

<div>
    <?php
    if (isset($_POST['id_in_same'])) {
        $idin = $_POST['id_in_same'];


        #Query w php and php variable:
        #WARNING: not injection safe, see CistomerSignUp.php for that
        $sql = "SELECT name FROM Employee WHERE EID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $idin);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "Name: " . $row["name"] . "<br>";
            }
        } else {
            echo "0 results";
        }
    }
    ?>
</div>

<br><br>
<div>Real functionality starts here:</div> <!--#####################################################################-->
<h2>Customer Login</h2>


<?php
#this function makes sure you dont do sql injections
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<form action="CustomerAuthentification.php" method="post">
    <input type="text" name="email" value="" placeholder="Email ex test">
    <input type="password" name="c_pw" value="" placeholder="Password ex test">
    <button type="submit" name="c_submit">Submit</button>
</form>
<br>
<div>
    <?php
    if(isset($_POST['c_submit'])){
        $email = test_input($_POST["email"]);
        $c_pw = test_input($_POST['c_pw']);

        $c_sql = "select * from Customer where email = '".$email."'";
        $c_rs = mysqli_query($conn,$c_sql);
        $c_numRows = mysqli_num_rows($c_rs);
        if($c_numRows  == 1){
            $row = mysqli_fetch_assoc($c_rs);
            if(password_verify($c_pw,$row['pwhash'])){
                echo "Password verified";
            }
            else {
                echo "Wrong Password";
            }
        }
        else{
            echo "No User found";
        }
    }
    ?>
</div>

<h2>Employee Login</h2>

<form action="EmployeeAuthentication.php" method="post">
    <input type="text" name="EID" value="" placeholder="EID ex 0123">
    <input type="password" name="e_pw" value="" placeholder="Password ex test">
    <button type="submit" name="e_submit">Submit</button>
</form>
<br>
<div>
    <?php
    if(isset($_POST['e_submit'])){
        $EID = test_input($_POST['EID']);
        $e_pw = test_input($_POST['e_pw']);

        $e_sql = "select * from Employee where EID = '".$EID."'";
        $e_rs = mysqli_query($conn,$e_sql);
        $e_numRows = mysqli_num_rows($e_rs);
        if($e_numRows  == 1){
            $row = mysqli_fetch_assoc($e_rs);
            if(password_verify($e_pw,$row['pwhash'])){
                echo "Password verified";
            }
            else {
                echo "Wrong Password";
            }
        }
        else{
            echo "No User found";
        }
    }
    ?>
</div>
<pr>manager eid: 1234</pr>
<br>
<pr>manager pw: manager</pr>
<br>
<br>

<h2>Info By Store</h2>

<div>
    <?php
    $st_sql = "select SID from Store";
    $st_rs = $conn->prepare($st_sql);
    $st_rs->execute();
    $st_result = $st_rs->get_result();
    ?>

    <form method="POST" action="StoreMain.php" id="sidList">
        <label for="storeID">Select Store ID</label>
        <select name="sid_val" id="sid_val" form="sidList">
        <?php
            while($row = $st_result->fetch_assoc())
            {
                $s_id = $row['SID'];
                echo "<option value='" . $s_id . "'>" . $s_id . "</option>";
            }
        ?>
        </select>
        <button type="submit">Go!</button>
    </form>

</div>


<br>
<br>
<h2>Find Books!</h2>
<form method="POST" action="BookMain.php">
    <input type="submit" value="View or find books!">
</form>
<br>
<br>
<form method="POST" action="CustomerSignUp.php">
    <input type="submit" value="Customer Sign Up">
</form>

<?php
mysqli_close($conn);
?>

</body>
</html>
