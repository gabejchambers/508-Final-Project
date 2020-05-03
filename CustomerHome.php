<!DOCTYPE html>
<html>
<head>
    <title>Customer Home</title>
</head>
<body>
<br>
<form method="POST" action="Logout.php">
    <input type="submit" value="Logout">
</form>
<br>
<form method="POST" action="CustomerProfile.php">
    <input type="submit" value="Profile">
</form>
<br>
<div>
    <?php
    include_once 'dbconnect.php';

    // We need to use sessions, so you should always start sessions using the below code.
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['c_loggedin'])) {
        header('Location: index.php');
        exit;
    }
    ?>

    <h2>Home Page</h2>
    <p>Welcome back, <?=$_SESSION['c_email']?>!</p>

    <h2>Info By Store</h2>

    <div>
        <?php
        $st_sql = "select SID, branch_name from Store";
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
                    echo "<option value='" . $row['branch_name'] . "'>" . $s_id . "</option>";
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

    <?php
    mysqli_close($conn);
    ?>
</div>
</body>
</html>
