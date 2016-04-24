<div id="info">
		<h1><?= $userProfile['username'] ?>'s Profile</h1>
</div>
<div id="story_container">
	<div class="story">
		<div class="story_head">
			<h2>Bio</h2>
		</div>
		<div class="content">
			<p><?= $userProfile['bio'] ?></p>
		</div>
	</div>
	
	<div class="story">
		<div class="story_head">
			<h2><?= $userProfile['username'] ?> a lu :</h2>
		</div>
		<div class="content">
			<?php
			foreach($storiesRead as $story):
			?>
			<a href="index.php?controller=story&idStory=<?= $story['idStory'] ?>"><p><?= $story['title'] ?></p></a>
			<?php
			endforeach;
			?>
		</div>
	</div>
</div>
<form method="post" action="index.php?action=comment">
    <input id="auteur" name="auteur" type="text" placeholder="Votre pseudo" 
           required /><br />
    <textarea id="txtCommentaire" name="contenu" rows="4" 
              placeholder="Votre commentaire" required></textarea><br />
    <input type="hidden" name="id" value="" />
    <input type="submit" value="Commenter" />
</form>