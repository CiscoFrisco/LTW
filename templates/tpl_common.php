<?php 
include_once('../includes/session.php');
include_once('../database/db_user.php');

function draw_header($isnt_login_signup) {
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Tidder</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="../js/main.js" defer></script>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="shortcut icon" type="image/jpg" href="../pictures/default.jpg"/>
</head>

<body>
	<header>	
		<h1><a href="../index.php">Tidder</a></h1>
	<?php if(!isset($_SESSION['user_id'])) { 
			if($isnt_login_signup) { ?>
				<h2><a href='../pages/login.php'>Login</a></h2>
				<h2><a href='../pages/signup.php'>Signup</a></h2>
	<?php }
	} else {
			$username = getUserName($_SESSION['user_id']);
			$profile_link = "../pages/profile.php?username=".urlencode($username); ?>
			<h2><a href=<?=$profile_link?>>Your Profile</a></h2>
			<h2><a href='../actions/action_logout.php'>Logout</a></h2>
	<?php } ?>
	</header>
<?php
}	

function draw_footer() {?>
	</body>
</html>
<?php } ?>