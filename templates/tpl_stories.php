<?php function draw_stories($stories){ ?>
        <section id="stories">
		<header>
			<h2>Stories</h2>
		</header>

        <?php 
            foreach($stories as $story)
                draw_story($story);
        ?>

		<footer>
			<p>Want to share a story? <a href="add_story.php">Add a story!</a></p>
		</footer>
	    </section>

        <?php } ?>

    <?php function draw_story($story) { ?>
        <article class="story">
            <header><h3><a href="story.php?story_id=<?=$story['story_id']?>"><?=$story['story_title']?></a></h3></header>
        </article>
    <?php } ?>