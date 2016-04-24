<?php
require_once 'Framework/Controller.php';
require_once 'Controller/ControllerConnexion.php';
require_once 'Model/Story.php';

class ControllerStory extends Controller{

	private $story;

	public function __construct() {
		$this->story = new Story();
	}

	// Affiche une story
	public function index() {
		$idStory = $this->request->getParametre('idStory');
		
		$story = $this->story->getStory($idStory);
		$chapters = $this->story->getChapters($idStory);
		$comments = $this->story->getComments($idStory);
		
		//Recuperation de l'user
		$ctrlConnexion = new ControllerConnexion();
		
		$userInfos = $ctrlConnexion->index();
		
		$this->genererView(array('story' => $story, 'chapters' => $chapters, 'comments' => $comments, 'user' => $userInfos));
	}
	
	public function comment(){
		$commentContent = $this->request->getParametre('content');
		$idStory = $this->request->getParametre('idStory');
		
		//Recuperation de l'user
		$ctrlConnexion = new ControllerConnexion();
		$userInfos = $ctrlConnexion->index();
		
		//Ajout du comment à la BDD
		$this->story->addComment($user, $content, $idStory);
		
		//Affichage de la story
		$this->story($idStory);
	}
}