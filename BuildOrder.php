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
    $book_v = $_POST['book_val']

    ?>

    <h2 style="text-align:center"> Checkout </h2>

    <div>
        <?php
        //just basic outline to get started, test links from store page
        //add purchase button, list 'similar' books, lmao add author oops,
        $sql = "SELECT * FROM Inventory WHERE store = '".$store."' and book = '".$book_v."'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $b_sql = "SELECT * FROM Book WHERE ISBN = '".$book_v."'";
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

    <div>
        <form method="post" action=BuildOrder.php>
            Name: <input type="text" name="name">
            <br><br>
            Address: <input type="text" name="address">
            <br><br>
            E-mail: <input type="text" name="email">
            <br><br>
            <input type="submit" name="submit_frm" value="Submit Order">
        </form>
    </div>

</div>
</body>