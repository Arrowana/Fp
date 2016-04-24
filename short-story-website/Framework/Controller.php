<?php

require_once 'Request.php';
require_once 'Framework/View.php';

abstract class Controller {

	// Action � r�aliser
	private $action;

	// Requ�te entrante
	protected $request;

	// D�finit la requ�te entrante
	public function setRequest(Request $request) {
		$this->request = $request;
	}

	// Ex�cute l'action � r�aliser
	public function executerAction($action){
		if (method_exists($this, $action)) {
			$this->action = $action;
			$this->{$this->action}();
		}
		else {
			$classController = get_class($this);
			throw new Exception("Action '$action' non d�finie dans la classe $classController");
		}
	}
	
	// Abstract method � implementer dans les classes d�riv�es
	public abstract function index();

	// G�n�re la View associ�e au contr�leur courant
	protected function genererView($donneesView = array()){
		// D�termination du nom du fichier View � partir du nom du contr�leur actuel
		$classController = get_class($this);
		$controller = str_replace("Controller", "", $classController);
		// Instanciation et g�n�ration de la View
		$view = new View($this->action, $controller);
		$view->generate($donneesView);
	}
}