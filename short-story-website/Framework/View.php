<?php
/*
	La classe vue permet de v�rifier l'existence de file et l'appel au gabarit
*/

class View {

	// Nom du file associ� � la vue
	private $file;
	// Titre de la vue (d�fini dans le file vue)
	private $titre;

	public function __construct($action, $controller = ""){
		$file = "View/";
		
		if ($controller != "") {
		  $file = $file . $controller . "/";
		}
		$this->file = $file . $action . ".php";
	}

	// G�n�re et affiche la vue
	public function generate($data) {
		// G�n�ration de la partie sp�cifique de la vue
		$page_content = $this->generateFile($this->file, $data);
		
		//Generation du logger
		$logger = $this->generateFile('View/Logger/index.php', $data);
		
		// G�n�ration du gabarit commun utilisant la partie sp�cifique
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

	// G�n�re un file vue et renvoie le r�sultat produit
	private function generateFile($file, $donnees) {
		if (file_exists($file)) {
			// Rend les �l�ments du tableau accessibles dans la vue comme attribut
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