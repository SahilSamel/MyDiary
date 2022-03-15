<?php
include('server.php');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="indexstyles.css">
</head>

<body>
    <div class="container">

        <div class="header">
            <p>MyDiary</p>
            <a href="index.php?logout='1'" style="color: red; text-decoration: none;"><img src="logout.png" width="40px" height="40px"></a>
        </div>
        <div class="welcome">
            <!-- notification message -->
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="error success">
                    <h3>
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    </h3>
                </div>
            <?php endif ?>




        </div>

        <?php
        if (isset($_POST['edit'])) {
            $username = mysqli_real_escape_string($db, $_SESSION['username']);
            $date = date('Y-m-d',strtotime($_POST['datetoedit']));
            $result = mysqli_query($db, "SELECT entry FROM entries where username = '$username' AND date = '$date'");
            if (mysqli_num_rows($result) >= 1) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $savedentry = $row["entry"];
                    echo "<div class='entry_box editpage'>";
                    echo "<form method='post' action='edit.php' class='input_form'>
                    <input type='date' name='datetoedit' value='" . $date . "' hidden>
                    <textarea type='text' name='edit_entry' class='edit_input' >$savedentry</textarea>
                    <section class='buttons'>     
                        <button type='submit' name='save_edit' id='edit_btn' class='btn'>Save edit</button>
                        <button type='submit' name='goback' class='btn'>Back</button>
                    </section>
                    </form>";
                    echo "</div>";
                }
            }
        }


        if (isset($_POST['save_edit'])) {
            $username = mysqli_real_escape_string($db, $_SESSION['username']);
            $entry = mysqli_real_escape_string($db, $_POST['edit_entry']);
            $date = date('Y-m-d',strtotime($_POST['datetoedit']));
            $result = mysqli_query($db, "SELECT * FROM entries where username = '$username' AND date = '$date'");
            while ($row = mysqli_fetch_assoc($result)) {
                $savedentry = $row["entry"];
                if ($entry === "") {
                    array_push($errors, "Please enter something first");
                    echo "<div class='entry_box editpage'>";
                    echo "<form method='post' action='edit.php' class='input_form'>
                            <textarea type='text' name='edit_entry' class='edit_input' >$savedentry</textarea>
                            <section class='buttons'>     
                                <button type='submit' name='save_edit' id='edit_btn' class='btn'>Save edit</button>
                                <button type='submit' name='goback' class='btn'>Back</button>
                            </section>
                        </form>";
                    echo "</div>";
                    include('errors.php');
                } else {
                    mysqli_query($db, "UPDATE entries SET entry = '$entry' where username = '$username' AND date = '$date'");
                    header("Location:index.php");
                    exit();
                }
            }
        }
        ?>
    </div>
</body>
</html>