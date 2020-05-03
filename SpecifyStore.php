<!DOCTYPE html>
<html>
<body>
<form method="POST" action="index.php">
    <input type="submit" value="Index">
</form>
<div>
<?php
#phpinfo();
include_once 'dbconnect.php';
session_start();

$book_b = $_POST['book_val'];

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
    <?php } else { ?>
        <form method="POST" action="index.php">
            <input type="submit" value="Index">
        </form>
        <br>
    <?php } ?>

    <h2 style="text-align:center"><strong>Must Specify Store to View!!</strong></h2>


    <div>
        <h4>select store location id</h4>
        <?php
        $st_sql = "select SID from Store";
        $st_rs = $conn->prepare($st_sql);
        $st_rs->execute();
        $st_result = $st_rs->get_result();
        ?>

        <form method="POST" action="BookView.php" id="sidList">
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
            <?php
            echo "<input type='hidden' value='" .$book_b."' name='book_val'>";
            ?>
            <button type="submit">Go!</button>
        </form>

    </div>

    <?php
    mysqli_close($conn)
    ?>
</div>
</body>
</html>

