<?php
	include_once('../includes/session.php');
	include_once('../templates/tpl_common.php');

	if (isset($_SESSION['user_id']))
		die(header('Location: profile.php'));

	if (!isset($_GET['redirect']) 
		|| preg_match('@../@', $_GET['redirect']) 
		|| !preg_match('@.php@', $_GET['redirect'])
		|| !is_readable('../pages/' . $_GET['redirect']))
		$_GET['redirect'] = '../index.php';
		
	draw_header(false);
?>

	<section id="login">
		<header>
			<h2>Welcome Back</h2>
		</header>
		<form method="post" action="../actions/action_login.php?redirect=<?=$_GET['redirect']?>">
			<input type="text" name="username" placeholder="username" required>
			<input type="password" name="password" placeholder="password" required>
			<input type="submit" value="Login">
		</form>
		<?php if(isset($_GET['error'])){ ?>
			<h3>Incorrect username or password. Please make sure you're typing them correctly</h3>
		<?php } ?>
		<footer>
			<p>Don't have an account? <a href="signup.php?redirect=<?=$_GET['redirect']?>">Signup!</a></p>
		</footer>
	</section>

<?php draw_footer();?>