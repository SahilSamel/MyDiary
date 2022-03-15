<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>MyDiary</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="container">

		<section class="text">
			<section class="descriptionheading">
				MyDiary
			</section>
			<p class="descriptiontext">
				“Your lyrics are your diary,
				you’re hearing every detail of your life.”
			</p>
		</section>
	
		<section class="form">
			<div class="header">
				<h2>Login</h2>
			</div>
				
			<form method="post" action="login.php">
				<?php include('errors.php'); ?>
				<div class="input-group">
					<input type="text" name="username">
					<span></span>
					<label>Username</label>
				</div>
				<div class="input-group">
					<input type="password" name="password">
					<span></span>
					<label>Password</label>
				</div>
				
				<div class="button">
					<button type="submit" class="btn" name="login_user">Login</button>
				</div>
				<!-- <hr color="#bdbdbd"> -->
				<div class="switch">
					<p>
						Not yet a member? <a href="register.php">Sign up</a>
					</p>
				</div>
			</form>
		</section>

	</div>
</body>
</html>