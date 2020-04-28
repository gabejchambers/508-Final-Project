<!DOCTYPE html>
<html>
<head>
    <title>Employee Sign Up</title>
</head>
<body>
<br>
<form method="POST" action="index.php">
    <input type="submit" value="Index">
</form>
<br>
<div>
    <?php

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

    if (isset($_POST['submit_frm'])) {
        $name = $EID = $pwhash = $rawpw = $address = $location = $salary = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = test_input($_POST["name"]);
            $EID = test_input($_POST["EID"]);
            $rawpw = test_input($_POST["rawpw"]);
            $address = test_input($_POST["address"]);
            $location = test_input($_POST["location"]);
            $salary = test_input($_POST["salary"]);

            $options = array("cost"=>4);
            $pwhash = password_hash($rawpw,PASSWORD_BCRYPT,$options);
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
</div>

<h2>Sign Up</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    EID: <input type="text" name="EID">
    <br><br>
    Password: <input type="password" name="rawpw" value="" placeholder="Password">
    <br><br>
    Location: <input type="text" name="location">
    <br><br>
    Name: <input type="text" name="name">
    <br><br>
    Salary: <input type="text" name="salary">
    <br><br>
    Address: <input type="text" name="address">
    <br><br>
    <input type="submit" name="submit_frm" value="Submit">
</form>

<?php
if (isset($_POST['submit_frm'])) {
    $sql = "insert into Employee values ('".$EID."', '".$pwhash."', '".$location."','".$name."', '".$salary."', '".$address."')";
    if(mysqli_query($conn, $sql))
    {
        echo "Registration successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>

</body>
</html>
