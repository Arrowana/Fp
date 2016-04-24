<?php

//require_once 'Framework/Configuration.php';

class Model {

	// Objet PDO d'acc�s � la BD
	private static $bdd;

  // Ex�cute une requ�te SQL �ventuellement param�tr�e
  public static function executeRequest($sql, $params = null){
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
			
			// Cr�ation de la connexion
			self::$bdd = new PDO($dsn,$login,$password,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		
		return self::$bdd;
  }

}