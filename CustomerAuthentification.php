<!DOCTYPE html>
<html>
<head>
    <title>Customer Authentication</title>
</head>
<body>
<br>
<form method="POST" action="index.php">
    <input type="submit" value="Index">
</form>
<br>
<div>
    <?php
    session_start();
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

    #if a email and password were sent:
    if ( isset($_POST['email'], $_POST['c_pw']) ){
        $email = trim($_POST['email']);
        $c_pw = trim($_POST['c_pw']);

        $c_sql = "select * from Customer where email = '".$email."'";
        $c_rs = mysqli_query($conn,$c_sql);
        $c_numRows = mysqli_num_rows($c_rs);
        if($c_numRows  == 1){
            $row = mysqli_fetch_assoc($c_rs);
            if(password_verify($c_pw,$row['pwhash'])){
                session_regeneratc_id();
                $_SESSION['c_loggedin'] = TRUE;
                $_SESSION['c_name'] = $_POST['email'];
                $_SESSION['c_id'] = $email;
                header('Location: CustomerHome.php');
            }
            else {
                echo "Wrong Password.";
            }
        }
        else{
            echo "No User found.";
        }
    }

    mysqli_close($conn);
    ?>
</div>
</body>
</html>
