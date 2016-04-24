<?php
require_once 'Framework/Controller.php';
require_once 'Controller/ControllerConnexion.php';

class ControllerIndex extends Controller {

	private $ctrlConnexion;

	public function __construct(){
	//Nothing
	}

	// Affiche la liste de tous les stories
	public function index(){
		//Recuperation de l'user
		$ctrlConnexion = new ControllerConnexion();
		$userInfos = $ctrlConnexion->index();

		$this->genererView(array('user' => $userInfos));
	}
}