<?php
	require 'model/Model.php';
	
	if(isset($_POST['idStory'])){
		$idStory=$_POST['idStory'];
		
		add_chapter($idStory);
		
		header('Location: story.php?idStory='.$idStory);
	}
	else{
		//redirecting user
		echo 'error';
	}
?>