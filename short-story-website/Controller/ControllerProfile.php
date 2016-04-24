<?php
require_once 'Framework/View.php';
require_once 'Controller/ControllerConnexion.php';

class ControllerProfile extends Controller {

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
		
		$idUser = $this->request->getParametre('idUser');
		
		$userProfile = $this->user->getUserById($idUser);
		
		$storiesRead = $this->user->getRead($idUser);
		
		$this->genererView(array('userProfile' => $userProfile, 'user'=> $userInfos, 'storiesRead' => $storiesRead));
	}
}