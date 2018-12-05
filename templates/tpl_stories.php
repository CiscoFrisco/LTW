<?php function draw_stories($stories, $not_profile){ ?>
        <section id="stories">
		<header>
			<h2>Stories</h2>
		</header>

        <?php 
            foreach($stories as $story)
				draw_story($story);
				
		
		if($not_profile){
        ?>

		<footer>
			<p>Want to share a story? <a href="add_story.php">Add a story!</a></p>
		</footer>
	    </section>

		<?php 
			}
		} ?>

    <?php function draw_story($story) { 
		global $now;?>
        <article class="story" data-id="<?=$story['opinion_id']?>">
				<h5>Score: <?=$story['score']?></h5>
				<div class="upvote" role="button" data-value="<?=$story['vote']?>">&#8593;</div>
				<div class="downvote" role="button" data-value="<?=$story['vote']?>">&#8595;</div>
				<h3><a href="story.php?story_id=<?=$story['opinion_id']?>"><?=$story['opinion_title']?></a></h3>
				<h4>Posted by <a href="<?='profile.php?username='.urlencode($story['username'])?>"><?=$story['username']?></a> <?=deltaTime($now, $story['posted'])?></h4>
        </article>
    <?php } ?>