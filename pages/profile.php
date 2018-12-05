<?php
	include_once('../includes/session.php');
	include_once('../includes/date.php');
	include_once('../database/db_user.php');
	include_once('../database/db_story.php');
	include_once('../database/db_vote.php');
	include_once('../templates/tpl_common.php');
	include_once('../templates/tpl_stories.php');
	include_once('../templates/tpl_comments.php');

	if (!isset($_GET['username']))
		die(header('Location: ../index.php'));

	$username = urldecode($_GET['username']);

	getUserInfo($user_id, $username, $realname, $email, $birthday, $join_date, $bio);

	if($user_id == '')
		header('Location: ../pages/404.html');

	$stories = getStories($user_id);
	$comments = getComments($user_id);
	$now = time();

	$score = 0;

	for($i = 0; $i < count($stories); $i++){
		$stories[$i]['username'] = $username;
		$stories[$i]['score'] = getScore($stories[$i]['opinion_id']);
		$score += $stories[$i]['score'];

		if(isset($_SESSION['user_id']))
			$stories[$i]['vote'] = getVote($stories[$i]['opinion_id'], $_SESSION['user_id']);
	}

	for($i = 0; $i < count($comments); $i++){
		$comments[$i]['username'] = $username;
		$comments[$i]['score'] = getScore($comments[$i]['opinion_id']);
		$score += $comments[$i]['score'];

		if(isset($_SESSION['user_id']))
			$comments[$i]['vote'] = getVote($comments[$i]['opinion_id'], $_SESSION['user_id']);
	}

	$formatted_birthday = formatDate($birthday);
	$formatted_join_date = formatDate($join_date);
	
	$path = "../pictures/".$user_id.".jpeg";
	$alt = $user_id." Profile Pic";
	
	if(!file_exists($path))
		$path = "../pictures/".$user_id.".jpg";
	
	if(!file_exists($path))
		$path = "../pictures/".$user_id.".png";

	if(!file_exists($path)){
		$path = "../pictures/default.jpg";
		$alt ="Default Profile Pic";
	}

	draw_header(true);
?>

	<h2><?=$username?> Profile</h2>
	<h3><img src=<?=$path?> alt=<?=$alt?> width="100" height="100"></h3>
	<h3>Username: <?=$username?></h3>
	<h3>Score: <?=$score?></h3>
	<h3>Name: <?=$realname?></h3>
	<h3>Bio: <?=$bio?></h3>
	<h3>Email: <?=$email?></h3>
	<h3>Birthday: <?=$formatted_birthday?></h3>
	<h3>Join Date: <?=$formatted_join_date?></h3>

<?php
	if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id){?>

<section id="edit">
	<header>
		<h2>Edit</h2>
	</header>
	<form method="post" action="../actions/action_edit_profile.php" enctype="multipart/form-data">
		<label>Profile Picture:
			<input type="file" name="img" value="" accept="image/png, image/jpeg">
		</label>
		<label>Username:
			<input type="text" name="username" value="<?=$username?>" required>
		</label>
		<label>Name:
			<input type="text" name="realname" value="<?=$realname?>">
		</label>
		<label>Email:
			<input type="email" name="email" value="<?=$email?>" required>
		</label>
		<label>Birthday:
			<input type="date" name="birthday" value="<?=$birthday?>">
		</label>
		<label>Bio:
			<textarea name="bio"><?=$bio?></textarea>
		</label>

		<input type="submit" value="Edit Profile">
	</form>
</section>
<?php } ?>
<section id="stories">
	<?php 
	draw_stories($stories, false);
?>
</section>
<section id="comments">
	<?php 
	draw_comments($comments,false);
?>
</section>
<section id="logout">
	<header>
		<h4><a href="../actions/action_logout.php">Logout</a></h4>
	</header>
</section>

<?php draw_footer(); ?>