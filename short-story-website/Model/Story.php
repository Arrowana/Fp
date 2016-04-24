<?php

require_once 'Framework/Model.php';

class Story extends Model{
	/* 
		GETTERS 
	*/
	
	public function getStoryOverviews($offset, $limit){
		$sql = 'SELECT idStory, title, summary, genre, username, story.idUser'
		.' FROM story INNER JOIN user ON user.idUser = story.idUser';
		
		$storyOverviews = $this->executerRequete($sql);
	
		return $storyOverviews;
	}
	
	public function findStoryOverviews($keyword){
		$sql = 'SELECT idStory, title, summary, genre, username, story.idUser'
		.' FROM story INNER JOIN user ON story.idUser=user.idUser WHERE story.title LIKE ?';
		
		$params=array('%'.$keyword.'%');
		
		$storyOverviews = $this->executerRequete($sql, $params)->fetchAll();
	
		return $storyOverviews;
	}
	
	function getChapters($idStory){
		$sql = 'SELECT idChapter, title, content FROM chapter WHERE idStory= :idStory';
			
		$params=array('idStory' => $idStory);
		
		$chapters = $this->executerRequete($sql, $params)->fetchAll();

		return $chapters;
	}
	
	public function getStory($idStory){
		$sql = 'SELECT idStory, title, summary, genre, username, story.idUser'
		.' FROM story INNER JOIN user ON user.idUser = story.idUser WHERE idStory= :idStory';
		
		$params=array('idStory' => $idStory);

		$story=$this->executerRequete($sql, $params)->fetch();

		return $story;
	}
	
	public function getComments($idStory){
		$sql = 'SELECT u.idUser, u.username, c.text FROM comment AS c INNER JOIN user AS u ON c.idUser = u.idUser WHERE c.idStory= :idStory';
			
		$params=array('idStory' => $idStory);
		
		$comments = $this->executerRequete($sql, $params)->fetchAll();

		return $comments;
	}
	
	/*
		SETTERS
	*/
	
	function setChapter($idChapter, $title, $content){
		$sql = 'UPDATE chapter SET title= :title, content= :content WHERE idChapter= :idChapter';
		$params=array(
			'idChapter' => $idChapter,
			'title' => $title,
			'content' => $content
			);
		$this->executerRequete($sql, $params);
	}
	
	function addComment($idUser, $content, $idStory){
		$sql='INSERT INTO comment(idUser, text, idStory) VALUES(:idUser, :text, :idStory)';
		
		$params = array(
			'idUser'=> $idUser,
			'text'=> $content,
			'idStory'=> $idStory);

		$this->executerRequete($sql, $params);
	}
}