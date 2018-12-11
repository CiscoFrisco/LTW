<?php
	include_once('includes/session.php');

	if(isset($_SESSION["user_id"]))
		header('Location: pages/stories.php?subscribed=true');

	else header('Location: pages/stories.php');
?>