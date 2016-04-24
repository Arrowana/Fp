<?php
	if($user['logged']):
?>
	<div id="logger">
		<p>Connected <?= $user['username'] ?></p>
		<form action="index.php?controller=Connexion&action=disconnect" method="post">
		<input type="submit" value="Logout"/>
		</form>
	</div>
<?php
	else:
?>
<div id="logger">
	<form action="index.php?controller=Connexion&action=connect" method="post">
		<p>Login :<input type="text" name="username"></p> 
		<p>Password :<input type="password" name="password"></p>
		<input type="submit" value="Send"/>
		
	</form>
</div>
<?php
	endif;
	/*
	<?php if($logEchec): ?>
		<p>Wrong username or password</p>
		<?php endif; ?>
	*/
?>