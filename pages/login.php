<?php
	include_once('../includes/session.php');
	include_once('../templates/tpl_common.php');

	if (isset($_SESSION['user_id']))
		die(header('Location: profile.php'));
		
	draw_header();
?>

	<section id="login">
		<header>
			<h2>Welcome Back</h2>
		</header>
		<form method="post" action="../actions/action_login.php">
			<input type="text" name="username" placeholder="username" required>
			<input type="password" name="password" placeholder="password" required>
			<input type="submit" value="Login">
		</form>
		<footer>
			<p>Don't have an account? <a href="signup.php">Signup!</a></p>
		</footer>
	</section>

<?php draw_footer();?>