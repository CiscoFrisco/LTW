<?php    
    $search = $_GET['search'];
    
	try {
        header('Location: ../pages/search.php?search='.urlencode($search));
    } catch (PDOException $e) {
		header('Location: ../pages/404.php');
	}
?>

