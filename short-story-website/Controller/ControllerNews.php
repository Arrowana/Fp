<?php
require_once 'Framework/View.php';
require_once 'Controller/ControllerConnexion.php';

class ControllerNews extends Controller {

	private $user;

	public function __construct() {
		//Instanciation du model
		$this->user = new User();
	}

	// Affiche les news
	public function index() {
		//Recuperation de l'user
		$ctrlConnexion = new ControllerConnexion();
		$userInfos = $ctrlConnexion->index();
		
		$readStories = $this->user->getFollowedReadStories($userInfos['idUser']);
		
		$this->genererView(array('readStories' => $readStories, 'user' => $userInfos));
	}
}