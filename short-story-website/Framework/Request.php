<?php

class Request{
	
	private $parametres;
	
	public function __construct($parametres){
		$this->parametres = $parametres;
	}
	
	public function existeParametre($name){
		return (isset($this->parametres[$name]) && $this->parametres[$name] != "");
	}
	
	//Renvoie la valeur du parametres
	public function getParametre($name){
		if($this->existeParametre($name)){
			return $this->parametres[$name];
		}
		else
			throw new Exception("Paramètre '$name' absent de la requête");
	}

}