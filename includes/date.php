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

		if(!floor($delta/60)){
			$time_word = ($delta == 1 ? ' second ' : ' seconds ');
			return $delta.$time_word.'ago';
		}	
		if(!floor($delta/3600)){
			$time_word = (floor($delta/60) == 1 ? ' minute ' : ' minutes ');
			return floor($delta/60).$time_word.'ago';
		}
		if(!floor($delta/86400)){
			$time_word = (floor($delta/3600) == 1 ? ' hour ' : ' hours ');
			return floor($delta/3600).$time_word.'ago';
		}
		if(!floor($delta/2592000)){
			$time_word = (floor($delta/86400) == 1 ? ' day ' : ' days ');
			return floor($delta/86400).$time_word.'ago';
		}	
		if(!floor($delta/31104000)){
			$time_word = (floor($delta/2592000) == 1 ? ' month ' : ' months ');
			return floor($delta/2592000).$time_word.'ago';
		}
			
		$time_word = (floor($delta/31104000) == 1 ? ' year ' : ' years ');
		return floor($delta/31104000).$time_word.'ago';
	}
?>