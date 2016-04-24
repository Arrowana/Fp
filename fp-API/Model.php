<?php

//require_once 'Framework/Configuration.php';

class Model {

	// Objet PDO d'accès à la BD
	private static $bdd;

  // Exécute une requête SQL éventuellement paramétrée
  public static function executeRequest($sql, $params = null){
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
	public static function getBdd(){
		if (self::$bdd == null) {
			//Recup des param de config BDD
			//$dsn = Configuration::get("dsn");
			$dsn='mysql:host=sql2.olympe.in;dbname=el86loue;charset=utf8';
			// dsn local 'mysql:host=localhost;dbname=fp;charset=utf8'
			// dsn olympe 'mysql:host=sql2.olympe.in;dbname=el86loue;charset=utf8';
			//$login = Configuration::get("login");
			$login="el86loue";
			//$login="el86loue";
			//$password = Configuration::get("mdp");
			$password = "123456";
			//$password="123456";
			
			// Création de la connexion
			self::$bdd = new PDO($dsn,$login,$password,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		
		return self::$bdd;
  }

}