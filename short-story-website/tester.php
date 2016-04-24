<?php
	require 'Model/Story.php';
	
	$story = new Story();
	
	$an = $story->findStoryOverviews('u');
	
	var_dump($an);
?>