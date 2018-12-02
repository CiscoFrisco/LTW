<?php 
include_once('../includes/session.php');
include_once('../database/db_user.php');

function draw_header($is_login_signup) {
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Tidder</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="../js/main.js" defer></script>
</head>

<body>
	<header>	
		<h1><a href="../index.php">Tidder</a></h1>
	<?php if(!isset($_SESSION['user_id'])) { 
			if($is_login_signup) { ?>
				<h1><a href='../pages/login.php'>Login</a></h1>
				<h1><a href='../pages/signup.php'>Signup</a></h1>
	<?php }
	} else {
			$username = getUserName($_SESSION['user_id']);
			$profile_link = "../pages/profile.php?username=".urlencode($username); ?>
			<h1><a href=<?=$profile_link?>>Your Profile</a></h1>
			<h1><a href='../actions/action_logout.php'>Logout</a></h1>
	<?php } ?>
	</header>
<?php
}	

function draw_footer() {?>
	</body>
</html>
<?php } ?>