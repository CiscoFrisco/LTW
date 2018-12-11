<?php 
    include_once('../includes/session.php');
    include_once('../includes/date.php');
    include_once('../database/db_search.php');
    include_once('../database/db_user.php');
    include_once('../database/db_vote.php');
    include_once('../templates/tpl_comments.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_stories.php');

	$search = $_GET['search'];
    $now = time();
    $stories = array_reverse(getStoriesSearch($search));
    $comments = array_reverse(getCommentsSearch($search));
    $users = getUsersSearch($search);

	for($i = 0; $i < count($stories); $i++){
		$stories[$i]['username'] = getUserName($stories[$i]['user_id']);
		$stories[$i]['score'] = getScore($stories[$i]['opinion_id']);
		$stories[$i]['comments']= getNumberComments($stories[$i]['opinion_id']);

		if(isset($_SESSION['user_id']))
			$stories[$i]['vote'] = getVote($stories[$i]['opinion_id'], $_SESSION['user_id']);
    }

    for($i = 0; $i < count($comments); $i++){   
		$comments[$i]['username'] = getUserName($comments[$i]['user_id']);
		$comments[$i]['score'] = getScore($comments[$i]['opinion_id']);

		if(isset($_SESSION['user_id']))
			$comments[$i]['vote'] = getVote($comments[$i]['opinion_id'], $_SESSION['user_id']);
    }

    function draw_users($users){ ?>
        <div class="container">
            <header>
                <h2>Users</h2>
            </header>
            <ol>
        <?php foreach($users as $user) { 
            getPicture($user['user_id'],$path,$alt);
            $page = 'profile.php?username='.$user['username']; ?>
                <li>
                    <h3><a href="<?=$page?>"><?=$user['username']?></a></h2>
                    <h3><img src=<?=$path?> alt=<?=$alt?> width="50" height="50"></h3>
                </li>
            <?php } ?>
            </ol>
        </div>
    <?php }

    draw_header(true);
    
    if(count($stories) > 0)
        draw_stories($stories,false);

    if(count($comments) > 0)
        draw_comments_header($comments,false);
    
    if(count($users) > 0)
        draw_users($users);

    if(count($stories) == 0 && count($comments) == 0 && count($users) == 0) {?>
        <h3>Couldn't find what you're looking for!</h3>
        <h3><img src="../pictures/sad.png" alt="Not Found" width="200" height="200"></h3>
    <?php }
    draw_footer();
?>