<!DOCTYPE html>
<html>
<head>
    <title>Book Info</title>
</head>
<body>

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
    <form method="POST" action="Index.php">
        <input type="submit" value="Index">
    </form>
    <br>
    <p>Testing</p>
<?php } ?>

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
                while ($row = mysqli_fetch_array($viewDat)) {
                    echo "<form method='POST' action='SpecifyStore.php'>";
                    echo "<input type='hidden' value='" .$row['ISBN']."' name='book_val'>";
                    echo "<button type='submit' style='border:0; background-color: transparent; color: royalblue; text-decoration: underline;'> 
                            ISBN: " . $row["ISBN"] . "  Title: " . $row["title"] . "</button>";
                    echo "</form>";
                    echo "  Genre: " . $row["genre"] . "<br>" . "  Price: " . $row["price"] . "  Publisher: " . $row["publisher"] . "<br>";
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
                    echo "<form method='POST' action='SpecifyStore.php'>";
                    echo "<input type='hidden' value='" .$row['ISBN']."' name='book_val'>";
                    echo "<button type='submit' style='border:0; background-color: transparent; color: royalblue; text-decoration: underline;'> 
                            ISBN: " . $row["ISBN"] . "  Title: " . $row["title"] . "</button>";
                    echo "</form>";
                    echo "  Genre: " . $row["genre"] . "  Price: " . $row["price"] . "  Publisher: " . $row["publisher"] . "<br>";

                } else {
                    echo "book unavailable";
                }
        }

        ?>
    </div>
    <br>
    <br>
<!--$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$-->
    <form method="post" action="BookMain.php">
        <input type="text" placeholder="Enter title" name="title_val">
        <button type="submit" name="title_search_button">Search</button>
    </form>
    <br>
    <div>
        <?php
        if (isset($_POST["title_search_button"])) {
            $bookTitle = test_input($_POST["title_val"]);

            $title_s = "SELECT * FROM Book WHERE title LIKE '".$bookTitle."'";
            $title_result = mysqli_query($conn, $title_s);
            if(mysqli_num_rows($title_result) > 0){
                while ($row = mysqli_fetch_array($title_result)) {
                    echo "<form method='POST' action='SpecifyStore.php'>";
                    echo "<input type='hidden' value='" .$row['ISBN']."' name='book_val'>";
                    echo "<button type='submit' style='border:0; background-color: transparent; color: royalblue; text-decoration: underline;'> 
                            ISBN: " . $row["ISBN"] . "  Title: " . $row["title"] . "</button>";
                    echo "</form>";
                    echo "  Genre: " . $row["genre"] . "<br>" . "  Price: " . $row["price"] . "  Publisher: " . $row["publisher"] . "<br>";
                }
            } else {
                echo "No books available";
            }
        }

        ?>
    </div>
    <br>
    
    <?php
    mysqli_close($conn);
    ?>

</div>
</body>
</html>
