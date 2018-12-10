<?php 
include_once('../includes/session.php');
include_once('../database/db_user.php');

function draw_header($isnt_login_signup) {
	global $page;
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Tidder</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="../js/main.js" defer></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="shortcut icon" type="image/jpg" href="../pictures/default.jpg"/>
</head>

<body>
	<div class = "wrapper">
	<header>
		<div class = "container">
			<h1>
				<a href="../index.php">
					<img src="../pictures/default.jpg" alt="icon" width = "25" height = "25"> Tidder
				</a>
				<form method="get" action="../actions/action_search.php">
					<input type="text" name="search" placeholder="Search" required>
					<input type="submit" class="fa fa-input" value="&#xf002">
				</form>
			</h1>
		
			<?php if(!isset($_SESSION['user_id'])) {  
					if($isnt_login_signup) { ?>
					<nav>
						<ul>
							<li><a href='../pages/login.php?redirect=<?=urlencode($page)?>''>Login</a></li>
							<li><a href='../pages/signup.php?redirect=<?=urlencode($page)?>'>Signup</a></li>
						</ul>
					</nav>
			<?php }
			} else {
					$username = getUserName($_SESSION['user_id']);
					$profile_link = "../pages/profile.php?username=".urlencode($username); ?>
					<nav>
							<li><a href=<?=$profile_link?>>Profile</a></li>
							<li><a href='../actions/action_logout.php?redirect=<?=urlencode($page)?>'>Logout</a></li>
						</ul>
					</nav>
			<?php } ?>

		</div> <!-- End of container -->
	</header>
<?php
}	

function draw_footer() {?>
		</div> <!-- end of wrapper  -->
		<footer>
			Made by <a href="https://github.com/Rekicho">Bruno Sousa</a>, 
			<a href="https://github.com/CiscoFrisco">Francisco Filipe</a>, 
			<a href="https://github.com/PedroMiguelSilva">Pedro Silva</a> &copy;2018
		</footer>
	</body>
</html>
<?php } ?>