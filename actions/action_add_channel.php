<?php
	include_once('../database/db_channel.php');

	$name = $_POST['name'];

	if(strlen($name) > 25)
		die(header('Location: ../pages/channels.php?error=lenght'));

	if(!preg_match ("/^[a-zA-Z0-9]+$/", $name))
		die(header('Location: ../pages/channels.php?error=name'));

	try {
		insertChannel($name);
		header('Location: ../pages/stories.php?channel='.urlencode($name));
	} catch (PDOException $e) {
		header('Location: ../pages/channels.php');
	}
?>