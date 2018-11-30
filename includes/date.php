<?php
	function formatDate($date){
		if($date == '')
			return '';
		
		else {
			$time = strtotime($date);
			return date("d/m/Y",$time);
		}
	}
	function deltaTime($now, $date){
		$time = strtotime($date);
		$delta = $now - $time;

		if(!floor($delta/60))
			return $delta.' seconds ago';

		if(!floor($delta/3600))
			return floor($delta/60).' minutes ago';

		if(!floor($delta/86400))
			return floor($delta/3600).' hours ago';

		if(!floor($delta/2592000))
			return floor($delta/86400).' days ago';

		if(!floor($delta/31104000))
			return floor($delta/2592000).' months ago';

		return floor($delta/31104000).' years ago';
	}
?>