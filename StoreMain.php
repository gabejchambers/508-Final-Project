<!DOCTYPE html>
<html>
<head>
    <div>Store Home</div>
</head>
<body>
<div>
<?php
#phpinfo();
include_once 'dbconnect.php';
//need to add checks for customer/employee w/session but this covers guests for now

$store = $_POST['sid_val'];

//have to set this page up as select instead of input, covers errors so we dont have to
?>
    <h2 style="text-align:center">Viewing Store Number: <?php echo "$store" ?>!</h2>

    <br>
    <br>
    <h4> Store Information:</h4>

    <?php

    $st_sql = "SELECT * FROM Store WHERE SID = '".$store."'";
    $sDat = $conn->prepare($st_sql);
    $sDat->execute();
    $result_s = $sDat->get_result();

    $man_sql = "SELECT e.name FROM Employee e, Store s WHERE e.EID = s.manager and s.SID = '".$store."'";
    $m_name = mysqli_query($conn,$man_sql);
    $m_num = mysqli_num_rows($m_name);
    $row_m = mysqli_fetch_assoc($m_name);
    if ($result_s->num_rows == 1) {
        while ($row = $result_s->fetch_assoc()) {
            echo "Store: " . $row["SID"] . "<br>" . "Address: " . $row["address"] . "<br>" . "Manager: " . $row_m["name"];
        }
    } else {
        //temporary
        echo "bad input not a store";
    }
    ?>
    <br>
    <br>


    <h3 style="text-align: left">inventory by location</h3>
    <br>
    <h4>View all</h4>
    <br>
    <form method="post" action="StoreMain.php">
        <?php
        echo "<input type='hidden' value='" .$store."' name='sid_val'>"
        ?>
        <button type="submit" name="view">Our Books!</button>
    </form>
    <br>
    <div>
        <?php
        if (isset($_POST["view"])) {
            $v_sql = "SELECT * FROM Inventory WHERE store = '".$store."'";
            $vw_stmt = $conn->prepare($v_sql);
            $vw_stmt->execute();
            $result_v = $vw_stmt->get_result();

            $b_sql = "SELECT * FROM Book b, Inventory i WHERE i.book = b.ISBN and i.store = '".$store."'";
            $b_Dat = mysqli_query($conn,$b_sql);
            $b_row = mysqli_fetch_assoc($b_Dat);

            if($result_v->num_rows > 0){
                while ($row = $result_v->fetch_assoc()) {
                    echo "ISBN: " . $b_row["ISBN"] . "  Title: " . $b_row["title"] . "  Genre: " . $b_row["genre"] . "<br>";
                    echo "       # in Stock: " . $row["quantity"] . "  Price: " . $b_row['price'] . "<br>";
                    echo "<br>";

                }
            } else {
                echo "No books available";
            }

        }
        ?>
    </div>

    <?php
    #this function makes sure you dont do sql injections
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <br>
    <br>
    <h4>Local search</h4>
    <br>
    <form method="post" action="StoreMain.php">
        <?php
        echo "<input type='hidden' value='" .$store."' name='sid_val'>"
        ?>
        <input type="text" placeholder="Enter ISBN" name="isbn_val">
        <button type="submit" name="s_book">Search</button>
    </form>
    <br>
    <div>
        <?php
        if (isset($_POST["s_book"])) {
            $bookID = test_input($_POST["isbn_val"]);

            $sql = "SELECT * FROM Inventory WHERE store = '".$store."' and book = '".$bookID."'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            $b_sql = "SELECT * FROM Book WHERE ISBN = '".$bookID."'";
            $b_Dat = mysqli_query($conn,$b_sql);
            $b_row = mysqli_fetch_assoc($b_Dat);

            if($result->num_rows == 1){
                while ($row = $result->fetch_assoc()) {
                    echo "Title: " . $b_row["title"] . "  Genre: " . $b_row["genre"] . "<br>";
                    echo "       # in Stock: " . $row["quantity"] . "  Price: " . $b_row['price'] . "<br>";
                    echo "<br>";
                }
            } else {
                echo "book unavailable";
            }

        }
        ?>
    </div>
    <br>
    <br>

    <?php
    mysqli_close($conn)
    ?>
</div>
</body>
</html>


