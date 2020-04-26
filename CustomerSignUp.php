<!DOCTYPE html>
<html>
<body>
<div>Sign Up</div>
<div>
    <?php

    $servername = "localhost";
    $username = "project_15";
    $password = "V00827834";
    $dbname = "project_15";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['submit_frm'])) {
        $name = $email = $pwhash = $address = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = test_input($_POST["name"]);
            $email = test_input($_POST["email"]);
            $pwhash = test_input($_POST["pwhash"]);
            $address = test_input($_POST["address"]);
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    } 

    mysqli_close($conn);
    ?>
</div>

<h2>PHP Form Validation Example</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Name: <input type="text" name="name">
    <br><br>
    E-mail: <input type="text" name="email">
    <br><br>
    Password: <input type="text" name="pwhash">
    <br><br>
    Address: <input type="text" name="address">
    <br><br>
    <input type="submit" name="submit_frm" value="Submit">
</form>

<?php
if (isset($_POST['submit_frm'])) {
    echo "<h2>Your Input:</h2>";
    echo $name;
    echo "<br>";
    echo $email;
    echo "<br>";
    echo $pwhash;
    echo "<br>";
    echo $address;
    echo "<br>";
}
?>


<form method="POST" action="index.php">
    <input type="submit" value="Index">
</form>

</body>
</html>
