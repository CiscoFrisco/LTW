<?php
	include_once('../includes/database.php');
	
	function insertUser(&$user_id, $username, $email, $password) {
		$db = Database::instance()->db();
		$join_date = date("Y-m-d");
        $stmt = $db->prepare('INSERT INTO user VALUES(NULL, ?, ?, ?, NULL, NULL, ?, NULL)');
		$stmt->execute(array($username, $email, password_hash($password,PASSWORD_DEFAULT), $join_date));
		$stmt = $db->prepare('SELECT user_id FROM user WHERE username = ?');
		$stmt->execute(array($username));
		$user = $stmt->fetch();
		$user_id = $user['user_id'];
	}

	function checkUserPassword(&$user_id, $username, $password) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM user WHERE username = ?');
		$stmt->execute(array($username));
		$user = $stmt->fetch();
		$user_id = $user['user_id'];
		return password_verify($password, $user['password']);
	}

	function getUserInfo(&$user_id, $username, &$realname, &$email, &$birthday, &$join_date, &$bio) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM user WHERE username = ?');
		$stmt->execute(array($username));
		$user = $stmt->fetch();
		$user_id = $user['user_id'];
		$email = $user['email'];
		$realname = $user['realname'];
		$birthday = $user['birthday'];
		$join_date = $user['join_date'];
		$bio = $user['bio'];
	}

	function editUserInfo($user_id, $username, $realname, $email, $birthday, $bio) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('UPDATE user SET username = ?, realname = ?, email = ?, birthday = ?, bio = ? WHERE user_id = ?');
		$stmt->execute(array($username, $realname, $email, $birthday, $bio, $user_id));
	}

	function getUserName($user_id){
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT username FROM user WHERE user_id = ?');
		$stmt->execute(array($user_id));
		return $stmt->fetch()['username'];
	}
?>