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
$store = $_POST['sid_val'];
$book_v = $_POST['book_val']

?>

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
                echo "Title: " . $b_row["title"] . "  Genre: " . $b_row["genre"] . "<br>";
                echo "       # in Stock: " . $row["quantity"] . "  Price: " . $b_row['price'] . "<br>";
                echo "<br>";
            }
        } else {
            echo "if you're seeing this you did something wrong";
        }

        ?>
    </div>


    <?php
    mysqli_close($conn)
    ?>

</div>
</body>

