<div id="info">
		<h1>Wall</h1>
</div>
<div id="story_container">
<?php
	if($readStories=="vide"):
	echo 'Vous ne suivez personne pour le moment';
	endif;

	foreach($readStories as $story):
?>
	<div class="story">
		<div class="story_head">
			<h2><?= $story['username'] ?> a lu <?= $story['title'] ?></h2>
		</div>
		<div class="overview">
			<p>By <a href="#"><?= 1 ?></a></p>
		</div>
		<a href="index.php?controller=story&idStory=<?= $story['idStory'] ?>" ><p>Read it</p></a>
	</div>
	<?php
	endforeach;
	//$story['author']
	?>
</div>