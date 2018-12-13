<?php
	include_once('../includes/session.php');
	include_once('../includes/date.php');
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
<div class="container">
	<section id="login">
		<header>
			<h2>Welcome Back</h2>
		</header>
		<form method="post" action="../actions/action_login.php?redirect=<?=urlencode($_GET['redirect'])?>">
			<input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
			<input type="text" name="username" placeholder="username" required>
			<input type="password" name="password" placeholder="password" required>
			<input type="submit" value="Login">
		</form>
		<?php if(isset($_GET['error'])){ 
				if($_GET['error'] == 'bad_login'){?>
				<h3>Incorrect username or password. Please make sure you're typing them correctly</h3>
			<?php } else if($_GET['error'] == 'wait') { ?>
				<h3>You failed log in too many times! Wait <?=epochDifference($_SESSION['timeout'], time());?> to try again.</h3>
			<?php } } ?>
		<footer>
			<p>Don't have an account? <a href="signup.php?redirect=<?=urlencode($_GET['redirect'])?>">Signup!</a></p>
		</footer>
	</section>
</div> <!-- end of container -->
<?php draw_footer();?>