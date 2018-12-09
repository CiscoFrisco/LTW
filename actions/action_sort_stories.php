<?php
	include_once('../includes/session.php');
	include_once('../database/db_story.php');

	$sort = $_POST['sort'];
	header('Location: ../pages/stories.php?sort_code='.$sort);
?>