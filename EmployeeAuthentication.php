<!DOCTYPE html>
<html>
<head>
    <title>Employee Authentication</title>
</head>
<body>
<br>
<form method="POST" action="index.php">
    <input type="submit" value="Index">
</form>
<br>
<div>
    <?php
    session_start();
    $servername = "localhost";
    $db_username = "project_15";
    $db_password = "V00827834";
    $dbname = "project_15";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    #if a eid and password were sent:
    if ( isset($_POST['EID'], $_POST['e_pw']) ) {
        $EID = trim($_POST['EID']);
        $e_pw = trim($_POST['e_pw']);


        $m_sql = "select e.pwhash from Store s, Employee e where e.EID = '" . $EID . "' and e.EID = s.manager";
        $m_rs = mysqli_query($conn, $m_sql);
        $m_numRows = mysqli_num_rows($m_rs);

        $e_sql = "select * from Employee where EID = '" . $EID . "'";
        $e_rs = mysqli_query($conn, $e_sql);
        $e_numRows = mysqli_num_rows($e_rs);

        if ($m_numRows == 1) {
            if ($e_numRows == 1) {
                $row = mysqli_fetch_assoc($e_rs);
                if (password_verify($e_pw, $row['pwhash'])) {
                    session_regenerate_id();
                    $_SESSION['ismanager'] = TRUE;
                    $_SESSION['e_loggedin'] = TRUE;
                    $_SESSION['e_name'] = $row['name'];
                    $_SESSION['e_id'] = $EID;
                    header('Location: ManagerHome.php');
                } else {
                    echo "Wrong Password.";
                }
            } else {
                echo "No User found.";
            }

        } else {

            if ($e_numRows == 1) {
                $row = mysqli_fetch_assoc($e_rs);
                if (password_verify($e_pw, $row['pwhash'])) {
                    session_regenerate_id();
                    $_SESSION['ismanager'] = FALSE;
                    $_SESSION['e_loggedin'] = TRUE;
                    $_SESSION['e_name'] = $row['name'];
                    $_SESSION['e_id'] = $EID;
                    header('Location: EmployeeHome.php');
                } else {
                    echo "Wrong Password.";
                }
            } else {
                echo "No User found.";
            }
        }
    }

    mysqli_close($conn);
    ?>
</div>
</body>
</html>
