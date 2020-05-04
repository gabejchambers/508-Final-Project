<!DOCTYPE html>
<html>
<body>
<div>
    <?php

    include_once 'dbconnect.php';
    session_start();
    $store = $_POST['sid_val'];
    $book_b = $_POST['book_val'];
    $q_in = $_POST['q_val']

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

    <h2 style="text-align:center"> Return </h2>

    <div>
        <?php

        $sql = "SELECT * FROM Inventory WHERE store = '".$store."' and book = '".$book_b."'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $b_sql = "SELECT * FROM Book WHERE ISBN = '".$book_b."'";
        $b_Dat = mysqli_query($conn,$b_sql);
        $b_row = mysqli_fetch_assoc($b_Dat);

        if($result->num_rows == 1){
            while ($row = $result->fetch_assoc()) {
                echo "Confirm Return of: " . $b_row["title"] . " ? <br>";
            }
        } else {
            echo "if you're seeing this you did something wrong";
        }
        ?>
    </div>
    <br>

    <div>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <?php
            echo "<input type='hidden' value='" .$book_b."' name='book_val'>";
            echo "<input type='hidden' value='" .$store."' name='sid_val'>";
            echo "<input type='hidden' value='" .$q_in."' name='q_val'>";
            #echo "# of copies: <input type='number' name='buy_q' max='".$bq_num."' min='1'>";
            ?>
            <button type="submit" name="submit_ret" onclick="alert('Return Successful!')">Submit Order</button>
        </form>
    </div>

    <div>
        <?php
        if (isset($_POST['submit_ret'])){
        #$num_ord = $_POST['buy_q'];
        #$new_q = $bq_num - $num_ord;
            if(isset($_SESSION['c_loggedin'])){
                $email = $_SESSION['c_email'];
                $ct_sql = "INSERT INTO Transaction (customer, is_return) VALUES ('".$email."', 1 )";
                if(mysqli_query($conn, $ct_sql)) {
                    //echo "test transaction query";
                } else {
                    echo " transaction Error: " . $ct_sql . "<br>" . mysqli_error($conn);
                }
            }
            else {
                $t_sql = "INSERT INTO Transaction ( is_return ) VALUES ( 1 )";
                if (mysqli_query($conn, $t_sql)) {
                    //echo "test transaction query";
                } else {
                    echo " transaction Error: " . $t_sql . "<br>" . mysqli_error($conn);
                }
            }
            $q_in += 1;
            $i_sql = "UPDATE Inventory SET quantity = '".$q_in."' WHERE store ='".$store."' and book = '".$book_b."'";
            if(mysqli_query($conn, $i_sql)) {
                echo "success";
            } else{
                echo " invetory return Error: " . $i_sql . "<br>" . mysqli_error($conn);
            }
        }
        ?>
    </div>

    <?php
    mysqli_close($conn);
    ?>


</div>
</body>
</html>

