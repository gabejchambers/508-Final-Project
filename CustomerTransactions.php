<!DOCTYPE html>
<html>
<head>
    <title>Your Transactions</title>
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

    <h2>Your Transactions</h2>
    <p>Your account information is below:</p>
    <br>

    <?php
    $c_email = $_SESSION['c_email'];
    $c_book_sql = "select t.TID, b.title from Book b, Customer_Transactions ct, Merchandise m, Transaction t where ct.email = '".$c_email."' and ct.TID = t.TID and t.TID = m.transaction";
    $iss_result = mysqli_query($conn, $c_book_sql);
    if(mysqli_num_rows($iss_result)!=0) {
        while($sup_rows = $iss_result->fetch_assoc()) {
            echo "Transaction number: " . $sup_rows['t.TID'] . "<br>";
            echo "Title: " . $sup_rows['b.title'] . "<br>";
        }
    }
    ?>