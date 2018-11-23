<?php
	include_once('database.php');
	
	function insertUser($username, $email, $password) {
		$db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO user VALUES(NULL, ?, ?, ?, ?, ?)');
        $stmt->execute(array($username, $email, password_hash($password,PASSWORD_DEFAULT)));
	}

	function checkUserPassword($username, $password) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM user WHERE username = ?');
		$stmt->execute(array($username));
		$user = $stmt->fetch();
		return password_verify($password, $user['password']);
	}

	function getUserInfo($username, &$realname, &$bio) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM user WHERE username = ?');
		$stmt->execute(array($username));
		$user = $stmt->fetch();
		$realname = $user['realname'];
		$bio = $user['bio'];
	}

	function editUserInfo($username, $realname, $bio) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('UPDATE user SET realname = ?, bio = ? WHERE username = ?');
		$stmt->execute(array($realname, $bio, $username));
	}
?>