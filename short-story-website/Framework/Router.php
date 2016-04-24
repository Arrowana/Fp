<?php
/*
	Le router permet de creer le controller et l'action correspondante � partir d'un objet Request
*/
	require_once 'Framework/Request.php';
	
	require_once 'Framework/View.php';

class Router {
	
	//Instancie la Request et construit un controller en cons�quence pour executer l'action
	public function routerRequest(){
		try {
			// Fusion des param�tres GET et POST de la requ�te
			$request= new Request(array_merge($_GET, $_POST));

			$controller = $this->creerController($request);
			$action = $this->creerAction($request);

			$controller->executerAction($action);
		}
		catch (Exception $e) {
			$this->gererErreur($e);
		}
	}
	
	private function creerController(Request $request) {
		$controller = "Index"; //Default controller
		
		if ($request->existeParametre('controller')) {
			$controller = $request->getParametre('controller');
			// Met la premi�re lettre en majuscule
			$controller = ucfirst(strtolower($controller));
		}
		
		// Cr�ation du nom du fichier du contr�leur
		$classController = "Controller" . $controller;
		$fileController = "Controller/" . $classController . ".php";
		if (file_exists($fileController)) {
			// Instanciation du contr�leur adapt� � la requ�te
			require($fileController);
			$ctrl = new $classController();
			$ctrl->setRequest($request);
			return $ctrl;
		}
		else
		  throw new Exception("Fichier '$fileController' introuvable");
	}

	// Extrait l'action de l'objet request
	private function creerAction(Request $request) {
		$action = "index";  // Action par d�faut
		if ($request->existeParametre('action')) {
			$action = $request->getParametre('action');
		}
		return $action;
	}
	
	// G�re une erreur d'ex�cution (exception)
	private function gererErreur(Exception $exception) {
		$view = new View('error');
		$view->generate(array('msgErreur' => $exception->getMessage()));
	}
}