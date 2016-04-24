<div id="info">
		<h1><?= $story['title'] ?> by <a href="index.php?controller=profile&idUser=<?= $story['idUser'] ?>"><?= $story['username'] ?></a></h1>
</div>
<div id="story_container">
<?php
	foreach($chapters as $chapter): 
?>
	<div class="story">
		<div class="chapter_head">
			<h2><?= $chapter['title'] ?></h2>
		</div>
		<div class="content">
			<p><?= $chapter['content'] ?></p>
		</div>
	</div>
<?php
endforeach;
?>
</div>
<form method="post" action="index.php?action=comment">
	<p>Commentez :</p>
    <textarea id="txtCommentaire" name="contenu" rows="4" 
              placeholder="Votre commentaire" required></textarea><br />
    <input type="hidden" name="id" value="<?= $story['idStory'] ?>" />
    <input type="submit" value="Commenter" />
</form>