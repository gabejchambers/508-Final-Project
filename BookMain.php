<!DOCTYPE html>
<html>
<head>
    <title>Book Info</title>
</head>
<body>

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
    <form method="post" action="BookMain.php">
        <input type="submit" value="all the books!">
    </form>
    <br>
    <div>
        <?php
        if (isset($_POST["submit"])) {
            $sql = "SELECT * FROM Books";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
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
    <form method="post" action="BookMain.php">
        <input type="text" placeholder="Enter ISBN" name="isbn_val">
        <input type="submit" value="Search">
    </form>
    <br>
    <div>
        <?php
        if (isset($_POST["isbn_value"])) {
            $bookID = test_input($_POST["isbn_value"]);

            $sql = "SELECT * FROM Book WHERE ISBN = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $bookID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "ISBN: " . $row["ISBN"] . "  Title: " . $row["title"] . "  Genre: " . $row["genre"] . "  Price: " . $row["price"] . "  Publisher: " . $row["publisher"];
                }
            } else {
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
