<?php	

require_once 'Framework/Model.php';
	
class User extends Model{

	public function getUserCheck($username){
		$sql='SELECT idUser, username, password FROM user WHERE username=:username';
		$params=array('username' => $username);
		
		$user = $this->executerRequete($sql, $params)->fetch();
		
		return $user;
	}
	
	public function getUserById($idUser){
		$sql='SELECT username, bio FROM user WHERE idUser=:idUser';
		$params=array('idUser' => $idUser);
		
		$user = $this->executerRequete($sql, $params)->fetch();
		
		return $user;
	}
	
	public function getFollowed($idUser){
		$sql='SELECT user.idUser, user.username FROM follow INNER JOIN user ON follow.idFollowed=user.idUser WHERE follow.idUser=:idUser';
		$params=array('idUser' => $idUser);
		$stories = $this->executerRequete($sql, $params)->fetchAll();
	
		return $stories;
	}

	//Method not finished yet	
	public function getFollowedReadStories($idUser){
		$sql='SELECT u.idUser, u.username, s.idStory, s.title, s.summary' 
								.' FROM follow AS f' 
								.' INNER JOIN user AS u' 
								.' ON f.idFollowed=u.idUser' 
								.' INNER JOIN view AS v' 
								.' ON u.idUser=v.idReader'
								.' INNER JOIN story AS s'
								.' ON v.idStory=s.idStory'
								.' WHERE f.idUser=:idUser';
		$params=array('idUser' => $idUser);
		$stories = $this->executerRequete($sql,$params)->fetchAll();
	
		return $stories;
	}
	
	public function getRead($idUser){
		$sql='SELECT story.title, story.summary, story.idStory FROM view INNER JOIN story ON view.idReader=story.idUser WHERE view.idReader=:idUser';
		
		$params=array('idUser' => $idUser);
		$stories = $this->executerRequete($sql, $params)->fetchAll();
	
		return $stories;
	}
}