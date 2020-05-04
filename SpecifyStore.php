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

    <h2 style="text-align:center"><strong>Must Specify Store to View!!</strong></h2>


    <div>
        <h4>select store location id</h4>
        <?php
        $st_sql = "select SID, branch_name from Store s, Inventory i WHERE s.SID = i.store and i.book = '".$book_b."' and i.quantity > 0";
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
                    echo "<option value='" . $s_id . "'>" . $row['branch_name'] . "</option>";
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