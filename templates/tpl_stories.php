<?php 
	include_once('../templates/tpl_comments.php');

	function draw_stories($stories, $not_profile){ 
		global $channel;?>
	<section id="stories">
	<header>
	<div class = "container">
		<?php if($channel) { ?>
			<h2><?='/c/'.$channel?></h2>
			<h3><a href="stories.php?subscribed=true">Subscibed</a></h3>
			<h3><a href="stories.php">Stories</a></h3>
			<h3><a href="channels.php">Channels</a></h3>
		<?php } else {?>
			<h2>Stories</h2>
			<h3><a href="stories.php?subscribed=true">Subscibed</a></h3>
			<h3><a href="channels.php">Channels</a></h3>
		<?php } ?>
			<?php if ($not_profile) { ?>
			<form method="post" action="../actions/action_sort_stories.php">
				<?php if($channel) { ?>
				<input type="hidden" name="channel" value="<?=$channel?>">
				<?php } ?>
				<select name="sort" onchange="this.form.submit();">
					<option value="-1" hidden selected>SORT</option>
					<option value="0">Most Recent</option>
					<option value="1">Most Comments</option>
					<option value="2">Most Upvoted</option>
					<option value="3">Most Downvoted</option>
				</select>
			</form >
			<?php } ?>
		</div>
		</header>
		
		<div class = "container">
			<ol>
			<?php 
				foreach($stories as $story)
					draw_story($story);		
			?> 
			</ol>
		</div> 
		<?php if($not_profile){
			if($channel){?>

			<footer>
				<p>Want to share a story? <a href="add_story.php?channel=<?=urlencode($channel)?>">Add a story!</a></p>
			</footer>

		<?php } else {?>

			<footer>
				<p>Want to share a story? <a href="add_story.php">Add a story!</a></p>
			</footer>

			<?php } ?>
		<?php } ?>
			</section>
<?php } 

		function draw_story($story) { 
		global $now;
		?>
		<li>
				<article class="story" data-id="<?=$story['opinion_id']?>">
					<div class = "votes-container">
							<div class = "votes">
								<div class="upvote" role="button" data-value="<?=$story['vote']?>"><i class="fas fa-arrow-circle-up"></i></div>
								<h5><?=$story['score']?></h5>
								<div class="downvote" role="button" data-value="<?=$story['vote']?>"><i class="fas fa-arrow-circle-down"></i></div>
							</div>
					</div>
					<div class = "storyinfo">
						<h3><a href="story.php?story_id=<?=$story['opinion_id']?>"><?=$story['opinion_title']?></a></h3>
						<h4>Posted by <a href="<?='profile.php?username='.urlencode($story['username'])?>"><?=$story['username']?></a> <?=deltaTime($now, $story['posted'])?></h4>
						<?php if($story['comments'] == 1){ ?>
							<h4><?=$story['comments']?> comment</h4>
						<?php } else { ?>
							<h4><?=$story['comments']?> comments</h4>
						<?php } ?>
					</div>
		   </article>
		</li>
    <?php } ?>