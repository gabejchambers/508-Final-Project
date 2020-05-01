<!DOCTYPE html>
<html>
<head>
    <title>Customer Profile</title>
</head>
<body>
<br>
<form method="POST" action="Logout.php">
    <input type="submit" value="Logout">
</form>
<br>
<form method="POST" action="CustomerHome.php">
    <input type="submit" value="Home">
</form>
<br>
<div>
    <?php
    session_start();
    include_once 'dbconnect.php';

    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['c_loggedin'])) {
        header('Location: index.php');
        exit;
    }

    ?>

    <h2>Customer Profile</h2>
    <p>Your account information is below:</p>
    <br>
    <?php
    $sql = "SELECT * FROM Customer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['c_email']);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "Name: " . $row["name"] . "<br>";
            echo "Email: " . $row["email"] . "<br>";
            echo "Address: " . $row["address"] . "<br>";
        }
    }
    ?>

    <?php
    mysqli_close($conn);
    ?>
</div>
</body>
</html>
