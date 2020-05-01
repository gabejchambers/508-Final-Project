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

    $servername = "localhost";
    $db_username = "project_15";
    $db_password = "V00827834";
    $dbname = "project_15";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
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
            $r_num = mysqli_num_rows($viewDat);
            if ($r_num > 0) {
                $row = mysqli_fetch_assoc($viewDat);
                while ($row) {
                    echo "ISBN: " . $row["ISBN"] . "  Title: " . $row["title"] . "  Genre: " . $row["genre"] . "  Price: " . $row["price"] . "  Publisher: " . $row["publisher"];
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
            $bookID = test_input($_POST["isbn_value"]);

            $sql = "SELECT * FROM Book WHERE ISBN = '".$bookID."'";
            $sDat = mysqli_query($conn,$sql);
            $r_num = mysqli_num_rows($sDat);
            if ($r_num > 0) {
                $row = mysqli_fetch_assoc($sDat);
                while ($row) {
                    echo "ISBN: " . $row["ISBN"] . "  Title: " . $row["title"] . "  Genre: " . $row["genre"] . "  Price: " . $row["price"] . "  Publisher: " . $row["publisher"];
                }
            }
            else {
                echo "ISBN unavailable";
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
