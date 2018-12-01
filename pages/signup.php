<?php
	include_once('../includes/session.php');
	include_once('../templates/tpl_common.php');

	if (isset($_SESSION['user_id']))
		die(header('Location: profile.php'));
		
	draw_header();
?>
	<section id="signup">
		<header>
			<h2>New Account</h2>
		</header>
		<form method="post" action="../actions/action_signup.php">
			<input type="text" name="username" placeholder="username" required>
			<input type="email" name="email" placeholder="e-mail" required>
			<input type="password" name="password" placeholder="password" required>
			<input type="submit" value="Signup">
		</form>
		<footer>
			<p>Already have an account? <a href="login.php">Login!</a></p>
		</footer>
	</section>

<?php draw_footer();?>