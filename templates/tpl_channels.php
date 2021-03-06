<?php
	include_once('../includes/session.php');

	function draw_channels($channels){ 
		global $page;
		?>
		<section id="stories" class = "secondary">
			<header class = "secondary-header">
				<div class = "container"> 
					<h2>Channels</h2>
					<h3><a href="stories.php?subscribed=true">Subscribed</a></h3>
					<h3><a href="stories.php">Stories</a></h3>
				</div>
			</header>
			<div class = "container">
				<ol>
				<?php 
					foreach($channels as $channel)
						draw_channel($channel);		
				?> 
				</ol>
			</div>

		<?php if((isset($_SESSION['user_id']))) { ?>
			<footer class = "secondary-footer">
				<div class = "container addChannel">
					<p>Want to add a channel?</p>
					<form method="post" action="../actions/action_add_channel.php">
						<input type="text" name="name" placeholder="Channel Name" required>
						<input type="submit" value="Add Channel">
					</form>
					<?php if(isset($_GET['error'])){ 
						if($_GET['error'] == 'lenght'){?>
						<h3>Channel name too long!</h3>
					<?php } else if($_GET['error'] == 'name') { ?>
						<h3>Channel name can only contain letters and numbers!</h3>
					<?php } } ?>
				</div>
			</footer>
			
		<?php } else { ?>
			<footer class = "secondary-footer">
				<div class = "container">
					<p>Want to add a channel? <a href='../pages/login.php?redirect=<?=urlencode($page)?>'>Login</a> or <a href='../pages/signup.php?redirect=<?=urlencode($page)?>'>Signup</a></p>
				</div>
			</footer>
		<?php }		
	}

	function draw_channel($channel){ ?>
		<li>
			<div class="channel">
			<h3><a href="stories.php?channel=<?=$channel['channel_name']?>"><?=htmlentities($channel['channel_name'])?></a></h3>
			<?php if(isset($_SESSION['user_id'])) {
					if($channel["subscribed"]) { ?>
						<div class="unsubscribe" role="button" data-id="<?=$channel['channel_id']?>"><i class="fas fa-bell-slash"></i></div>
					<?php } else { ?>
						<div class="subscribe" role="button" data-id="<?=$channel['channel_id']?>"><i class="fas fa-bell"></i></div>
					<?php } 
				} ?>
			</div>
		</li>


	<?php }

	function draw_channel_options($channels){ 
		global $channel_name;?>
		<label> Channel:
			<select name="channel" required>
			
			<?php foreach($channels as $channel) { 
					if($channel_name == $channel["channel_name"]) { ?>
						<option value="<?=$channel["channel_id"]?>" selected><?='/c/'.htmlentities($channel_name)?></option>
			<?php } else { ?>
				<option value="<?=$channel["channel_id"]?>"><?='/c/'.htmlentities($channel["channel_name"])?></option>
			<?php } } ?>

			</select>
		</label>
	<?php }
?>