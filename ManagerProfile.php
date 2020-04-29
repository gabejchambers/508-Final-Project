<!DOCTYPE html>
<html>
<head>
    <title>Manager Profile</title>
</head>
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
<div>
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

    <h2>Manager Profile</h2>
    <p>Your account information is below:</p>
    <br>
    <?php
    $sql = "SELECT * FROM Employee WHERE EID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['e_name']);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result

    $s_sql = "select * from Store s, Employee m WHERE m.EID = s.manager and m.EID = '".$_SESSION['e_name']."'";
    $s_rs = mysqli_query($conn,$s_sql);
    $s_row = mysqli_fetch_assoc($s_rs);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "Managages Location: " . $s_row["SID"] . "<br>";
            echo "Name: " . $row["name"] . "<br>";
            echo "EID: " . $row["EID"] . "<br>";
            echo "Store Location: " . $row["location"] . "<br>";
            echo "Address: " . $row["address"] . "<br>";
            echo "Salary: " . $row["salary"] . "<br>";
        }
    }
    ?>

    <?php
    mysqli_close($conn);
    ?>
</div>
</body>
</html>
