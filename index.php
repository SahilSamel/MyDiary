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
				<p>Welcome, <strong><?php echo $_SESSION['username']; ?></strong></p>

			<?php endif ?>
		</div>

		<div class="content">
			<a href="entry.php" id='newentry_btn' class="entry_blocks">+</a>
			<?php include('errors.php'); ?>
			<div class="display_entry">
				<?php
				$username = $_SESSION['username'];
				$results = mysqli_query($db, "SELECT date, entry FROM entries WHERE username = '$username' ORDER BY date DESC");
				if (mysqli_num_rows($results) >= 1) {
					while ($row = $results->fetch_assoc()) {
						$retrievedDate = $row["date"];
						$retrievedEntry = $row["entry"];
						$betterdate = date("F j, Y", strtotime($retrievedDate));
						echo "<div class='entry_blocks ' >";
						echo "<form method='post' action='edit.php' class='input_form'>";
						echo "<section id='diplay_date' class='display'>";
						echo $betterdate . "<br>";
						echo "</section>";
						echo "<hr>";
						echo "<section id='diplay_entry' class='display'>";
						echo $retrievedEntry . "<br>";
						echo "</section>";
						echo "<input type='date' name='datetoedit' value='" . $retrievedDate . "' hidden>
						<button type='submit' name='edit' id='edit_btn' class='btn' value='submit'>Edit</button>
						</form>";
						echo "<form method='post' action='index.php' class='input_form'>";
						echo "<input type='date' name='datetoedit' value='" . $retrievedDate . "' hidden>
						<button type='submit' name='delete' id='delete_btn' class='btn' value='submit'>Delete</button>";
						echo "</form>";
						echo "</div>";
					}
				}
				?>
			</div>
		</div>

	</div>

</body>

</html>