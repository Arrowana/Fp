<?php

require_once 'Framework/Configuration.php';

abstract class Model {

  // Objet PDO d'acc�s � la BD
  private static $bdd;

  // Ex�cute une requ�te SQL �ventuellement param�tr�e
  protected function executerRequete($sql, $params = null){
    if ($params == null) {
      $resultat = self::getBdd()->query($sql);    // ex�cution directe
    }
    else {
      $resultat = self::getBdd()->prepare($sql);  // requ�te pr�par�e
      $resultat->execute($params);
    }
    return $resultat;
  }

  // Renvoie un objet de connexion � la BD en initialisant la connexion au besoin
	private static function getBdd(){
		if (self::$bdd == null) {
			//Recup des param de config BDD
			$dsn = Configuration::get("dsn");
			$login = Configuration::get("login");
			$password = Configuration::get("mdp");
			
			// Cr�ation de la connexion
			self::$bdd = new PDO($dsn,$login,$password,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		
		return self::$bdd;
  }

}