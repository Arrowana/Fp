<?php
	require_once('Model.php');
	
	$sql = 'SELECT id, username, password FROM user WHERE username=:username';
	
	$res=Model::executeRequest($sql, array('username'=> 'Arnaud'));
	
	var_dump($res->fetch());