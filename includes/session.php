<?php
	session_set_cookie_params(0, '/', 'www.fe.up.pt', true, true);
	session_start();
	//session_regenerate_id(true); //not working

	if (!isset($_SESSION['csrf'])) {
		$_SESSION['csrf'] = generate_random_token();
	}

	function generate_random_token() {
		return bin2hex(openssl_random_pseudo_bytes(32));
	}
?>