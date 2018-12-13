<?php
	//session_set_cookie_params and session_regenerate_id are not working at the same time
	//so one needs to be commented

	//session_set_cookie_params(0, '/', 'www.fe.up.pt', true, true);
	session_start();
	session_regenerate_id(true);

	if (!isset($_SESSION['tries']))
		$_SESSION['tries'] = 0;

	if (!isset($_SESSION['timeout']))
		$_SESSION['timeout'] = time();

	if (!isset($_SESSION['csrf']))
		$_SESSION['csrf'] = generate_random_token();

	function generate_random_token() {
		return bin2hex(openssl_random_pseudo_bytes(32));
	}
?>