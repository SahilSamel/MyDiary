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
				<h2>Register</h2>
			</div>
			
			<form method="post" action="register.php">
				<?php include('errors.php'); ?>
				
				<div class="input-group">
					<input type="text" name="username" value="<?php echo $username; ?>">
					<span></span>
					<label>Username</label>
				</div>

				<div class="input-group">
					<input type="email" name="email" value="<?php echo $email; ?>">
					<span></span>
					<label>Email</label>
				</div>

				<div class="input-group">
					<input type="password" name="password_1">
					<span></span>
					<label>Password</label>
				</div>

				<div class="input-group please">
					<input type="password" name="password_2">
					<span></span>
					<label>Confirm password</label>
				</div>

				<div class="button">
					<button type="submit" class="btn" name="reg_user">Register</button>
				</div>
				<p>
					Already a member? <a href="login.php">Sign in</a>
				</p>
			</form>
		</section>

	</div>
	
</body>

</html>