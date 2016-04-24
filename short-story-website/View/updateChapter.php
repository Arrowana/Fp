<?php
	require 'model/Model.php';
	
	if(isset($_POST['idChapter']) and isset($_POST['title']) and isset($_POST['content']) and isset($_POST['idStory']) ){
		$idChapter=$_POST['idChapter'];
		$title=$_POST['title'];
		$content=$_POST['content'];
		
		$idStory=$_POST['idStory'];
		
		set_chapter($idChapter, $title, $content);
		
		header('Location: story.php?idStory='.$idStory);
	}
	else{
		//redirecting user
		echo 'error';
	}
?>