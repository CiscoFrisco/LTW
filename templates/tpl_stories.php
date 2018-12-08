<?php function draw_stories($stories, $not_profile){ ?>
        <section id="stories">
		<header>
			<h2>Stories</h2>
		</header>
		<div class = "container">
			<ol>
					<?php 
							foreach($stories as $story)
					draw_story($story);		
			?> 
			</ol>
		</div> 
		<?php if($not_profile){?>

		<footer>
			<p>Want to share a story? <a href="add_story.php">Add a story!</a></p>
		</footer>
		<?php } ?>
		 </section>
		<?php } ?>

    <?php function draw_story($story) { 
		global $now;?>
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
					</div>
		   </article>
		</li>
    <?php } ?>