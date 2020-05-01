<!DOCTYPE html>
<html>
<head>
    <title>Customer Sign Up</title>
</head>
<body>
<br>
<form method="POST" action="index.php">
    <input type="submit" value="Index">
</form>
<br>
<div>
    <?php

    include_once 'dbconnect.php';

    if (isset($_POST['submit_frm'])) {
        $name = $email = $pwhash = $rawpw = $address = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = test_input($_POST["name"]);
            $email = test_input($_POST["email"]);
            $rawpw = test_input($_POST["rawpw"]);
            $address = test_input($_POST["address"]);

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
    Name: <input type="text" name="name">
    <br><br>
    E-mail: <input type="text" name="email">
    <br><br>
    Password: <input type="password" name="rawpw" value="" placeholder="Password">
    <br><br>
    Address: <input type="text" name="address">
    <br><br>
    <input type="submit" name="submit_frm" value="Submit">
</form>

<?php
if (isset($_POST['submit_frm'])) {
    $sql = "insert into Customer values ('".$email."', '".$pwhash."', '".$name."','".$address."')";
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
