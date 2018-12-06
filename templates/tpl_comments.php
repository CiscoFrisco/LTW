<?php 
	include_once('../includes/session.php');

	function draw_comments($comments, $not_profile){ 
		global $story_id?>

        <section id="comments">
		<header>
			<h2>Comments</h2>
		</header>

		<?php 
		if($not_profile){
			if((isset($_SESSION['user_id']))) { ?>
				<form>
					<input type="hidden" name="opinion_id" value="<?=$story_id?>">
					<textarea name="comment" placeholder="Have something to say about this story?" required></textarea>
					<input type="submit" value="Add Comment">
				</form>
			
		<?php } else { ?>
			<p>Have something to say about this story? <a href="login.php">Login!</a> or <a href="signup.php">Sign Up!</a></p>
		<?php }
		} 
		
		?><ol><?php

		    foreach($comments as $comment)
				draw_comment($comment);
		?>
	    </ol>
		</section>

        <?php } ?>

    <?php function draw_comment($comment) { 
		global $now;?>
		<li>
        <article class="comment" data-id="<?=$comment['opinion_id']?>">
			<div class="upvote" role="button" data-value="<?=$comment['vote']?>">&#8593;</div>
			<h5>Score: <?=$comment['score']?></h5>
			<div class="downvote" role="button" data-value="<?=$comment['vote']?>">&#8595;</div>
			<h3><?=$comment['opinion_text']?></a></h3>
			<h4>Posted by <a href="<?='profile.php?username='.urlencode($comment['username'])?>"><?=$comment['username']?></a> <?=deltaTime($now, $comment['posted'])?></h4>
			
			<?php if((isset($_SESSION['user_id']))) { ?> <div class="comment_comment" role="button">&#128172;</div> <?php } ?>
		
		</article>
		</li>
    <?php } ?>