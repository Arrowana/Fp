<?php 
	//Permet d'empêcher l'envoie à la page
	ob_start();
?>
	<div id="info">
			<h1><?= $story['title'] ?> by <?= $story['username'] ?></h1>
			<form action="story.php" method="get">
				<input type="hidden" name="idStory" value="<?= $idStory ?>" />
				<input type="hidden" name="editMode" value="<?= '0' ?>" />
				<input type="submit" value="Leave edit mode" />
			</form>
	</div>
	<div id="story_container">
<?php
	foreach($chapters as $chapter){ 
?>
		<div class="story">
		<form action="updateChapter.php" method="post">
			<input type="hidden" name="idChapter" value="<?= $chapter['idChapter'] ?>" />
			<input type="hidden" name="idStory" value="<?= $idStory ?>" />
			<div class="chapter_head">
				<h2><input type="text" name="title" value="<?= $chapter['title'] ?>" /></h2>
			</div>
			<div class="content">
				<textarea name="content"><?= $chapter['content'] ?></textarea>
			</div>
			<input type="submit" value="Save" />
		</form>
		</div>
	<?php
	}
	?>
	</div>
	<div>
		<form action="addChapter.php" method="post">
			<input type="hidden" name="idStory" value="<?= $idStory ?>" />
			<input type="submit" value="Add chapter" />
		</form>
	</div>

<?php $page_content=ob_get_clean(); ?>
<?php require 'gabarit.php' ?>