<?php
	include_once('../includes/session.php');
	include_once('../templates/tpl_common.php');

	if (isset($_SESSION['user_id']))
		die(header('Location: profile.php'));

	if (!isset($_GET['redirect'])){
		$_GET['redirect'] = '../index.php';
	}

	else $_GET['redirect'] = urldecode($_GET['redirect']);

	$redirect_options = explode("?",$_GET['redirect']);

	if(preg_match('@../@', $_GET['redirect']) 
		|| !preg_match('@.php@', $_GET['redirect'])
		|| !is_readable('../pages/' . $redirect_options[0]))
			$_GET['redirect'] = '../index.php';

	draw_header(false);
?>
<section id="signup">
	<header>
		<h2>New Account</h2>
	</header>
	<form method="post" action="../actions/action_signup.php?redirect=<?=urlencode($_GET['redirect'])?>">
		<input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
		<input type="text" name="username" placeholder="username" required>
		<input type="email" name="email" placeholder="e-mail" required>
		<input type="password" name="password" placeholder="password" required>
		<input type="submit" value="Signup">
	</form>
	<?php if(isset($_GET['error'])){ 
				if($_GET['error'] == 'taken'){?>
		<h3>Username or email already taken!</h3>
	<?php } else if($_GET['error'] == 'username') { ?>
		<h3>Username can only contain letters and numbers!</h3>
	<?php } } ?>
	<footer>
		<p>Already have an account? <a href="login.php?redirect=<?=urlencode($_GET['redirect'])?>">Login!</a></p>
	</footer>
</section>

<?php draw_footer();?>