<?php
	include_once('../includes/session.php');
	include_once('../includes/date.php');
	include_once('../database/db_user.php');
	include_once('../database/db_story.php');
	include_once('../database/db_vote.php');
	include_once('../database/db_channel.php');
	include_once('../templates/tpl_common.php');
	include_once('../templates/tpl_stories.php');
	include_once('../templates/tpl_comments.php');

	if (!isset($_GET['username']))
		die(header('Location: ../index.php'));

	$username = urldecode($_GET['username']);

	getUserInfo($user_id, $username, $realname, $email, $birthday, $join_date, $bio);

	if($user_id == '')
		header('Location: ../pages/404.php');

	$stories = array_reverse(getStories($user_id));
	$comments = array_reverse(getComments($user_id));
	$now = time();

	$score = 0;

	for($i = 0; $i < count($stories); $i++){
		$stories[$i]['username'] = $username;
		$stories[$i]['score'] = getScore($stories[$i]['opinion_id']);
		$stories[$i]['comments'] = getNumberComments($stories[$i]['opinion_id']);
		$stories[$i]['channel_name']= getChannelName($stories[$i]['channel_id']);
		$score += $stories[$i]['score'];

		if(isset($_SESSION['user_id']))
			$stories[$i]['vote'] = getVote($stories[$i]['opinion_id'], $_SESSION['user_id']);
	}

	for($i = 0; $i < count($comments); $i++){
		$comments[$i]['username'] = $username;
		$comments[$i]['score'] = getScore($comments[$i]['opinion_id']);
		$comments[$i]['replies'] = getNumberComments($comments[$i]['opinion_id']);
		$score += $comments[$i]['score'];

		if(isset($_SESSION['user_id']))
			$comments[$i]['vote'] = getVote($comments[$i]['opinion_id'], $_SESSION['user_id']);
	}

	$formatted_birthday = formatDate($birthday);
	$formatted_join_date = formatDate($join_date);
	
	getPicture($user_id,$path,$alt);

	$page = 'profile.php?username='.$username;

	draw_header(true);
?>
	<div class = "container profile">
		<div class = "comment-container">
			<h2><?=$username?>'s Profile</h2>
			<div class = "photo-cropper">
				<img class = "profile-pic" src=<?=$path?> alt=<?=$alt?> width="100" height="100">
			</div>
			<h3>Username: <span class = "input"> <?=$username?> </span></h3>
			<h3>Score: <span class = "input"><?=$score?></span></h3>
			<h3>Name: <span class = "input"><?=$realname?></span></h3>
			<h3>Bio: <span class = "input"><?=$bio?></span></h3>
			<h3>Email: <span class = "input"><?=$email?></span></h3>
			<h3>Birthday: <span class = "input"><?=$formatted_birthday?></span></h3>
			<h3>Join Date: <span class = "input"><?=$formatted_join_date?></span></h3>
		</div>
	</div>
<?php
	if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id){?>

<section id="edit">
	<header class = "secondary-header">
		<h2>Edit</h2>
	</header>
	<div class = "container profile">
		<div class = "comment-container">
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
		</div>
	</div>
</section>
<?php } 
	draw_stories($stories, false);
	draw_comments_header($comments,false);
?>

<?php draw_footer(); ?>
