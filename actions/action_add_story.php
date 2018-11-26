<?php
	include_once('../includes/session.php');
    include_once('../database/db_story.php');
    
	$user_id = $_SESSION['user_id'];
	$title = $_POST['title'];
	$story = $_POST['story'];

	try {
		insertStory($user_id, $title, $story);
        header('Location: ../index.php');
    } catch (PDOException $e) {
        header('Location: ../pages/add_story.php');
    }
?>