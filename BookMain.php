<!DOCTYPE html>
<html>
<head>
    <title>Book Info</title>
</head>
<body>
<form method="POST" action="index.php">
    <input type="submit" value="Index">
</form>
<div>
    <?php
    include_once 'dbconnect.php';
    session_start()

    ?>

    <div>View all</div>
    <br>
    <form method="post" action="BookMain.php">
        <button type="submit" name="view">All Books!</button>
    </form>
    <br>
    <div>
        <?php
        if (isset($_POST["view"])) {
            $sql = "SELECT * FROM Book";
            $viewDat = mysqli_query($conn,$sql);

            if(mysqli_num_rows($viewDat) > 0){
                echo "<table>";
                while ($row = mysqli_fetch_array($viewDat)) {
                    echo "<tr><td>" . "ISBN: " . $row["ISBN"] . "  Title: " . $row["title"] . "  Genre: " . $row["genre"] . "  Price: " . $row["price"] . "  Publisher: " . $row["publisher"] . "</td></tr>" . "<br>";
                echo "</table>";
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
    <div>Search book!</div>
    <br>
    <form method="post" action="BookMain.php">
        <input type="text" placeholder="Enter ISBN" name="isbn_val">
        <button type="submit" name="s_book">Search</button>
    </form>
    <br>
    <div>
        <?php
        if (isset($_POST["s_book"])) {
                $bookID = test_input($_POST["isbn_val"]);

                $sql = "SELECT * FROM Book WHERE ISBN = '".$bookID."'";
                $sDat = mysqli_query($conn, $sql);
                $r_num = mysqli_num_rows($sDat);
                if ($r_num == 1) {
                    $row = mysqli_fetch_assoc($sDat);
                    echo "<table>";
                    echo "<tr><td>" . "ISBN: " . $row["ISBN"] . "  Title: " . $row["title"] . "  Genre: " . $row["genre"] . "  Price: " . $row["price"] . "  Publisher: " . $row["publisher"] . "</td></tr>" . "<br>";
                    echo "</table>";

                } else {
                    echo "book unavailable";
                }
        }

        ?>
    </div>
    <br>
    <br>

    <?php
    mysqli_close($conn);
    ?>

</div>
</body>
</html>
