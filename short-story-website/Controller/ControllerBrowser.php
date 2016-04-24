<?php
require_once 'Framework/Controller.php';
require_once 'Controller/ControllerConnexion.php';
require_once 'Model/Story.php';

class ControllerBrowser extends Controller {

	private $story;
	private $ctrlConnexion;

	public function __construct(){
		$this->story = new Story();
	}

	// Affiche la liste de tous les stories
	public function index(){
		//Recuperation de l'user
		$ctrlConnexion = new ControllerConnexion();
		
		$userInfos = $ctrlConnexion->index();
	
		//Recuperation des overviews
		$overviews = $this->story->getStoryOverviews(0,0);

		$this->genererView(array('overviews' => $overviews, 'user' => $userInfos));
	}
	
	public function search(){
		$keyword = $this->request->getParametre('keyword');
		
		//Recuperation de l'user
		$ctrlConnexion = new ControllerConnexion();
		
		$userInfos = $ctrlConnexion->index();
	
		//Recuperation des story ayant un titre contenant le keyword
		$overviews = $this->story->findStoryOverviews($keyword);

		$this->genererView(array('overviews' => $overviews, 'user' => $userInfos));
	}
}