<?php
    include_once('db_user.php');

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
		insertUser($username, $email, $password);
		//$_SESSION['username'] = $username;
        header('Location: index.php');
    } catch (PDOException $e) {
        header('Location: signup.php');
    }
?>