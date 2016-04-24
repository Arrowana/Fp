<?php
/*
	Le router permet de creer le controller et l'action correspondante à partir d'un objet Request
*/
	require_once 'Framework/Request.php';
	
	require_once 'Framework/View.php';

class Router {
	
	//Instancie la Request et construit un controller en conséquence pour executer l'action
	public function routerRequest(){
		try {
			// Fusion des paramètres GET et POST de la requête
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
			// Met la première lettre en majuscule
			$controller = ucfirst(strtolower($controller));
		}
		
		// Création du nom du fichier du contrôleur
		$classController = "Controller" . $controller;
		$fileController = "Controller/" . $classController . ".php";
		if (file_exists($fileController)) {
			// Instanciation du contrôleur adapté à la requête
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
		$action = "index";  // Action par défaut
		if ($request->existeParametre('action')) {
			$action = $request->getParametre('action');
		}
		return $action;
	}
	
	// Gère une erreur d'exécution (exception)
	private function gererErreur(Exception $exception) {
		$view = new View('error');
		$view->generate(array('msgErreur' => $exception->getMessage()));
	}
}