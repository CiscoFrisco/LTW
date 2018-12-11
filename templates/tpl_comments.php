<?php 
	include_once('../includes/session.php');
	include_once('../database/db_comment.php');

	function getNumberComments($story) {
			
		$comments = getAllComments($story);
		
		$count = 0;
		foreach($comments as $comment){
			$count += getNumberComments($comment['opinion_id']);
		}

		return count($comments) + $count;
	}

	function draw_comments_header($comments,$not_profile){ 
		global $story_id;
		if($not_profile){ ?>
			<section id="comments" data-id="<?=$story_id?>">
		<?php } else { ?>
			<section id="comments">
		<?php } ?>

		<div class="container">
			<header>
				<h2>Comments</h2>
			</header>
		<?php if($not_profile){
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
		
		draw_comments($comments,$not_profile);?>
			</div>
		</section>
	<?php }

	function draw_comments($comments, $not_profile){ 
		global $story_id?>
		<ol>
		<?php
		    foreach($comments as $comment)
				draw_comment($comment, $not_profile);
		?>
	    </ol>
        <?php } ?>

    <?php function draw_comment($comment, $not_profile) { 
		global $now;
		
		$regex = '/\[([^\]]+)\]\((http[s]?:[\/]{2})?(www\.)?([-a-zA-Z0-9@:%&_\+~#=]{2,256}\.[a-z]{2,6}\b[-a-zA-Z0-9@:%_\+.~#?&=\/]*)\)/';
		$comment['opinion_text'] = preg_replace($regex,"<a href=\"https://www.$4\"	>$1</a>",$comment['opinion_text']);

		$regex_user = '/\/u\/([-a-zA-Z0-9@:%_\+.~#?&=\/]+)/';
		$comment['opinion_text'] = preg_replace($regex_user, "<a href=\"profile.php?username=$1\">$0</a>",$comment['opinion_text']);

		$regex_channel = '/\/c\/([-a-zA-Z0-9@:%_\+.~#?&=\/]+)/';
		$comment['opinion_text'] = preg_replace($regex_channel, "<a href=\"profile.php?username=$1\">$0</a>",$comment['opinion_text']);
		?>
		<li>
        <article class="comment" data-id="<?=$comment['opinion_id']?>">
			<div class="upvote" role="button" data-value="<?=$comment['vote']?>"><i class="fas fa-arrow-circle-up"></i></div>
			<h5><?=$comment['score']?></h5>
			<div class="downvote" role="button" data-value="<?=$comment['vote']?>"><i class="fas fa-arrow-circle-down"></i></div>
			<h3><?=htmlentities($comment['opinion_text'])?></h3>
			<h4>Posted by <a href="<?='profile.php?username='.urlencode($comment['username'])?>"><?=$comment['username']?></a> <?=deltaTime($now, $comment['posted'])?></h4>
			<?php 
			$replieNum = getNumberComments($comment['opinion_id']);
			if($replieNum == 1){ ?>
				<h4><?=$replieNum?> reply</h4>
			<?php } else { ?>
				<h4><?=$replieNum?> replies</h4>
			<?php }
				
			if(isset($_SESSION['user_id']) && $not_profile) { ?> 
				<div class="comment_comment" role="button">&#128172;</div> 
			<?php }

				$comments = array_reverse(getAllComments($comment['opinion_id']));

				for($i = 0; $i < count($comments); $i++){
					$comments[$i]['username'] = getUserName($comments[$i]['user_id']);
					$comments[$i]['score'] = getScore($comments[$i]['opinion_id']);

					if(isset($_SESSION['user_id']))
						$comments[$i]['vote'] = getVote($comments[$i]['opinion_id'], $_SESSION['user_id']);
				}
				
				draw_comments($comments,$not_profile);
			?>
		</article>
		</li>
    <?php } ?>