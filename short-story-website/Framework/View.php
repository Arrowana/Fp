<?php
/*
	La classe vue permet de vérifier l'existence de file et l'appel au gabarit
*/

class View {

	// Nom du file associé à la vue
	private $file;
	// Titre de la vue (défini dans le file vue)
	private $titre;

	public function __construct($action, $controller = ""){
		$file = "View/";
		
		if ($controller != "") {
		  $file = $file . $controller . "/";
		}
		$this->file = $file . $action . ".php";
	}

	// Génère et affiche la vue
	public function generate($data) {
		// Génération de la partie spécifique de la vue
		$page_content = $this->generateFile($this->file, $data);
		
		//Generation du logger
		$logger = $this->generateFile('View/Logger/index.php', $data);
		
		// Génération du gabarit commun utilisant la partie spécifique
		$view = $this->generateFile('View/template.php',
			array('page_content' => $page_content, 'logger' => $logger));
			
		// Renvoie la vue, donc affichage
		echo $view;
	}
	
	// Recuperer la vue
	public function build($data){
		$element = $this->generateFile($this->file, $data);
		
		return $element;
	}

	// Génère un file vue et renvoie le résultat produit
	private function generateFile($file, $donnees) {
		if (file_exists($file)) {
			// Rend les éléments du tableau accessibles dans la vue comme attribut
			extract($donnees);
			
			// Temporisation du tampon
			ob_start();

			//Inclue la vue
			require $file;
			// Envoie du tampon
			return ob_get_clean();
		}
		else {
		  throw new Exception("file '$file' introuvable");
		}
	}
}