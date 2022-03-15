<?php
include('server.php');
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

            <?php if (isset($_SESSION['username'])) : ?>
            <p>Welcome, <strong>
                    <?php echo $_SESSION['username']; ?>
                </strong></p>

            <?php endif ?>
            <p>What will you write today?</p>
        </div>
        <div class="entry_box entrypage">
            <form method="post" action="entry.php" class="input_form">
                <textarea type="text" name="entry" class="entry_input"></textarea>
                <br>
                <section class="buttons">     
                    <button type="submit" name="save" id="add_btn" class="btn">Save</button>
                    <button type="submit" name="goback" class="btn">Back</button>
                </section>
            </form>
        </div>

        <?php include('errors.php'); ?>
    </div>
    
</body>

</html>