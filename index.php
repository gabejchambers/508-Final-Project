<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
</head>
<body>

<h2>Example Templates:</h2>
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


    echo "This is a php query with formatted output:<br>";
    #Query w php:
    $sql = "SELECT name, salary FROM Employee WHERE EID = 5656";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "Name: " . $row["name"]. " - Salary: " . $row["salary"]. "<br>";
        }
    } else {
        echo "0 results";
    }

    mysqli_close($conn);
    ?>
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
    #phpinfo();

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

    if (isset($_POST['id_in_same'])) {
        $idin = $_POST['id_in_same'];


        #Query w php and php variable:
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
<div>Real functionality starts here:</div>
<br>
<h2>Login</h2>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <input type="text" name="email" value="" placeholder="Email">
    <input type="password" name="pw" value="" placeholder="Password">
    <button type="submit" name="submit">Submit</button>
</form>
<br>
<div>
    <?php
    #phpinfo();



    if(isset($_POST['submit'])){
        $email = trim($_POST['email']);
        $pw = trim($_POST['pw']);

        $sql = "select * from Customer where email = '".$email."'";
        $rs = mysqli_query($conn,$sql);
        $numRows = mysqli_num_rows($rs);
        if($numRows  == 1){
            $row = mysqli_fetch_assoc($rs);
            if(password_verify($pw,$row['pwhash'])){
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


    mysqli_close($conn);
    ?>
</div>
<br>
<form method="POST" action="CustomerSignUp.php">
    <input type="submit" value="Sign Up">
</form>

</body>
</html>




