<?php
	include_once('../includes/session.php');
	include_once('../database/db_story.php');
	include_once('../database/db_vote.php');
    
	$user_id = $_SESSION['user_id'];
	$title = $_POST['title'];
	$story = $_POST['story'];

	if(strlen($title) > 50)
		die(header('Location: ../pages/add_story.php?error=title'));

	if(strlen($story) > 50000)
		die(header('Location: ../pages/add_story.php?error=text'));

	try {
		insertStory($user_id, $title, $story, $story_id);
		addVote($story_id, $user_id, 1);
        header('Location: ../pages/story.php?story_id='.$story_id);
    } catch (PDOException $e) {
		header('Location: ../pages/add_story.php');
    }
?>