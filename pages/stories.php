<?php 
	include_once('../database/db_story.php');
	include_once('../templates/tpl_stories.php');

	$stories = getAllStories();
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Tidder</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
	<header>
		<h1><a href="../index.php">Tidder</a></h1>
	</header>
	<?php
		draw_stories($stories);
	?>
</body>
</html>