<div id="info">
		<h1>Result :</h1>
</div>
	<div id="story_container">
<?php
	foreach($overviews as $overview):
?>
		<div class="story">
			<div class="story_head">
				<h2><?= $overview['title'] ?></h2>
			</div>
			<div class="overview">
				<p><?= $overview['summary'] ?></p>
				<p>By <a href="index.php?controller=profile&idUser=<?= $overview['idUser'] ?>"><?= $overview['username'] ?></a></p>
			</div>
			<a href="index.php?controller=story&action=index&idStory=<?= $overview['idStory'] ?>" ><p>Read it</p></a>
		</div>
	<?php
	endforeach;
	?>
</div>