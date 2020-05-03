<!DOCTYPE html>
<html>
<head>
    <div>Book Details</div>
</head>
<body>
<div>
<?php
#phpinfo();
include_once 'dbconnect.php';
session_start();
$branch = $_POST['branch_name_val'];
$book_v = $_POST['book_val'];

?>

    <?php
    $st_sql = "select SID from Store where branch_name LIKE '".$branch."'";
    $result = $conn->query($st_sql);
    $row = $result->fetch_assoc();
    $store = $row["SID"];
    $_POST['sid_val'] = $store;
    ?>


    <?php if (isset($_POST['q_val'])){
        $bq_num = $_POST['q_val'];
    }
    else{
        $bq_sql = "SELECT quantity FROM Inventory WHERE store = '".$store."' and book = '".$book_v."'";
        $bq_Dat = mysqli_query($conn,$bq_sql);
        $br_row = mysqli_num_rows($bq_Dat);
        if($br_row == 1){
            $row = mysqli_fetch_assoc($bq_Dat);
            $bq_num = $row['quantity'];
        }
    }
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

    <h2 style="text-align:center">Viewing Book ID <?php echo "$book_v" ?> at Store Number: <?php echo "$store" ?>!</h2>

    <br>
    <br>
    <h4> Book Information:</h4>

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
                echo "  Genre: " . $b_row["genre"] . "Publisher: " . $b_row["publisher"] . "<br>";
                echo "       # in Stock: " . $row["quantity"] . "  Price: " . $b_row['price'] . "<br>";
                echo "<br>";
            }
        } else {
            echo "if you're seeing this you did something wrong";
        }

        ?>
    </div>

<!--    probably need a session for a shopping cart if were not forcing purchases item by item?    -->
    <br>
    <h2>Buy Now!</h2>
    <form method="POST" action="BuildOrder.php">
        <?php
        echo "<input type='hidden' value='" .$book_v."' name='book_val'>";
        echo "<input type='hidden' value='" .$store."' name='sid_val'>";
        echo "<input type='hidden' value='" .$bq_num."' name='q_val'>";
        ?>
        <input type="submit" value="purchase book!">
    </form>
    <br>

    <br>
    <!-- does not do anything yet button goes no-whereee -->
    <h2>View Similar</h2>
    <form method="POST" action="BookView.php">
        <?php
        echo "<input type='hidden' value='" .$book_v."' name='book_val'>";
        echo "<input type='hidden' value='" .$store."' name='sid_val'>";
        ?>
        <input type="submit" value="View other titles!">
    </form>
    <br>

    <?php
    mysqli_close($conn)
    ?>

</div>
</body>

