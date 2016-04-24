<?php

require_once 'Framework/Configuration.php';

abstract class Model {

  // Objet PDO d'accès à la BD
  private static $bdd;

  // Exécute une requête SQL éventuellement paramétrée
  protected function executerRequete($sql, $params = null){
    if ($params == null) {
      $resultat = self::getBdd()->query($sql);    // exécution directe
    }
    else {
      $resultat = self::getBdd()->prepare($sql);  // requête préparée
      $resultat->execute($params);
    }
    return $resultat;
  }

  // Renvoie un objet de connexion à la BD en initialisant la connexion au besoin
	private static function getBdd(){
		if (self::$bdd == null) {
			//Recup des param de config BDD
			$dsn = Configuration::get("dsn");
			$login = Configuration::get("login");
			$password = Configuration::get("mdp");
			
			// Création de la connexion
			self::$bdd = new PDO($dsn,$login,$password,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		
		return self::$bdd;
  }

}