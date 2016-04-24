<?php

require_once 'Request.php';
require_once 'Framework/View.php';

abstract class Controller {

	// Action à réaliser
	private $action;

	// Requête entrante
	protected $request;

	// Définit la requête entrante
	public function setRequest(Request $request) {
		$this->request = $request;
	}

	// Exécute l'action à réaliser
	public function executerAction($action){
		if (method_exists($this, $action)) {
			$this->action = $action;
			$this->{$this->action}();
		}
		else {
			$classController = get_class($this);
			throw new Exception("Action '$action' non définie dans la classe $classController");
		}
	}
	
	// Abstract method à implementer dans les classes dérivées
	public abstract function index();

	// Génère la View associée au contrôleur courant
	protected function genererView($donneesView = array()){
		// Détermination du nom du fichier View à partir du nom du contrôleur actuel
		$classController = get_class($this);
		$controller = str_replace("Controller", "", $classController);
		// Instanciation et génération de la View
		$view = new View($this->action, $controller);
		$view->generate($donneesView);
	}
}