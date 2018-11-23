<?php
    include_once('database.php');

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO user VALUES(NULL, ?, ?, ?)');
        $stmt->execute(array($username, $email, password_hash($password,PASSWORD_DEFAULT)));
        header('Location: index.php');
    } catch (PDOException $e) {
        header('Location: signup.php');
    }
?>