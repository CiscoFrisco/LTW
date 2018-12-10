<?php
	$sort = $_POST['sort'];

	if(isset($_POST['channel']))
		header('Location: ../pages/stories.php?channel='.urldecode($_POST['channel']).'&sort_code='.$sort);

	else header('Location: ../pages/stories.php?sort_code='.$sort);
?>