<?php
	include_once('../includes/session.php');
	include_once('../templates/tpl_common.php');
	include_once('../templates/tpl_channels.php');
	include_once('../database/db_channel.php');

	$channels = getAllChannels();

	if(isset($_SESSION["user_id"])){

		$subscribed = getAllSubscribedChannel($_SESSION["user_id"]);

		for($i = 0; $i < count($channels); $i++)
		{
			$found = false;
			
			for($j = 0; $j < count($subscribed); $j++)
				if($subscribed[$j]["channel_name"] == $channels[$i]["channel_name"]){
					$found = true;
					break;
				}
			
			if($found)
				$channels[$i]["subscribed"] = true;

			else $channels[$i]["subscribed"] = false;
		}

	}

	$page = 'channels.php';

	draw_header(true);
	draw_channels($channels);
	draw_footer();
?>