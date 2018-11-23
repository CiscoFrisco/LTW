<?php
	include_once('session.php');

	if (isset($_SESSION['username']))
    	die(header('Location: profile.php'));
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Tidder</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
	<header>
		<h1><a href="index.php">Tidder</a></h1>
	</header>
	<section id="login">
		<header>
			<h2>Welcome Back</h2>
		</header>
		<form method="post" action="action_login.php">
			<input type="text" name="username" placeholder="username" required>
			<input type="password" name="password" placeholder="password" required>
			<input type="submit" value="Login">
		</form>
		<footer>
			<p>Don't have an account? <a href="signup.php">Signup!</a></p>
		</footer>
	</section>
</body>

</html>