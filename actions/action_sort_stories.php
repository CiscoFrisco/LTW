<?php
	$sort = $_POST['sort'];

	if(isset($_POST['subscribed']) && $_POST['subscribed'] == 'true')
	header('Location: ../pages/stories.php?subscribed=true&sort_code='.$sort);

	else if(isset($_POST['channel']))
		header('Location: ../pages/stories.php?channel='.urldecode($_POST['channel']).'&sort_code='.$sort);

	else header('Location: ../pages/stories.php?sort_code='.$sort);
?>