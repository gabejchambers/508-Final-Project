<!DOCTYPE html>
<html>
<body>
<div>
    <?php
    #start to manage transactions, inventory, etc from here
    #charging customers?
    #offer customer sign up @ check out
    #phpinfo();
    include_once 'dbconnect.php';
    session_start();
    $store = $_POST['sid_val'];
    $book_b = $_POST['book_val'];
    $bq_num = $_POST['q_val']

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

    <h2 style="text-align:center"> Checkout </h2>

    <?php
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <div>
        <?php
        //just basic outline to get started, test links from store page
        //add purchase button, list 'similar' books, lmao add author oops,
        $sql = "SELECT * FROM Inventory WHERE store = '".$store."' and book = '".$book_b."'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $b_sql = "SELECT * FROM Book WHERE ISBN = '".$book_b."'";
        $b_Dat = mysqli_query($conn,$b_sql);
        $b_row = mysqli_fetch_assoc($b_Dat);

        if($result->num_rows == 1){
            while ($row = $result->fetch_assoc()) {
                echo "Title: " . $b_row["title"] . "<br>";
                echo "       # in Stock: " . $row["quantity"] . "  Price: " . $b_row['price'] . "<br>";
                echo "<br>";
            }
        } else {
            echo "if you're seeing this you did something wrong";
        }
        ?>
    </div>
    <br>

    <br>
    <div>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <?php
            if (!isset($_SESSION['c_loggedin'])) {
            ?>
                Name: <input type='text'>
                <br><br>
                Address: <input type='text'>
                <br><br>
            <?php
            }
            ?>
            <?php
            echo "<input type='hidden' value='" .$book_b."' name='book_val'>";
            echo "<input type='hidden' value='" .$store."' name='sid_val'>";
            echo "<input type='hidden' value='" .$bq_num."' name='q_val'>";
            #echo "# of copies: <input type='number' name='buy_q' max='".$bq_num."' min='1'>";

            ?>
            <input type="submit" name="submit_o" value="Submit Order">
        </form>
    </div>

    <div>
        <?php
        if (isset($_POST['submit_o']))
            #$num_ord = $_POST['buy_q'];
            #$new_q = $bq_num - $num_ord;
            $t_id = rand(3000,3999);

            if(isset($_SESSION['c_loggedin'])){
                $email = $_SESSION['c_email'];
                $ct_sql = "INSERT INTO Transaction (customer, is_return) VALUES ('".$email."', 0 )";
                if(mysqli_query($conn, $ct_sql)) {
                    echo "test transaction query";
                } else {
                echo " transaction Error: " . $ct_sql . "<br>" . mysqli_error($conn);
                }
            }
            else{
                $t_sql = "INSERT INTO Transaction ( is_return ) VALUES ( 0 )";
                if(mysqli_query($conn, $t_sql)) {
                    echo "test transaction query";
                } else {
                    echo " transaction Error: " . $t_sql . "<br>" . mysqli_error($conn);
                }

            }

            $m_sql = "UPDATE Merchandise SET book = '".$book_b."' WHERE book IS NULL";
            if(mysqli_query($conn, $m_sql)) {
                echo "test merch query";
                $bq_num -= 1;
                $i_sql = "UPDATE Inventory SET quantity = '".$bq_num."' WHERE store ='".$store."' and book = '".$book_b."'";
                if(mysqli_query($conn, $i_sql)) {
                    echo "test inventory update";
                } else {
                    echo "inv error " . $i_sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "merch Error: " . $m_sql . "<br>" . mysqli_error($conn);
            }

            ?>
    </div>

</div>
</body>