<?php
require_once 'Framework/Controller.php';	
require 'Model/User.php';

class ControllerConnexion extends Controller{

	private $user;
	
	public function __construct() {
		$this->user = new User();
		session_start();
	}
	
	public function index(){
		$user_array['logged'] = false;
		$user_array['username'] = "";
		$user_array['idUser'] = 0;
	
		if(isset($_SESSION['logged'])){
			if($_SESSION['logged']){
				$user_array['logged'] = true;
				$user_array['username'] = $_SESSION['username'];
				$user_array['idUser'] = $_SESSION['idUser'];
			}
		}
		
		return $user_array;
	}
	
	public function connect(){
		if($this->request->existeParametre('username') and $this->request->existeParametre('password')){
			$username = $this->request->getParametre('username');
			$password = $this->request->getParametre('password');
			
			$realLog = $this->user->getUserCheck($username);
		
			//Si le password est correct
			if($password==$realLog['password']){
				$_SESSION['logged'] = true;
				$_SESSION['username'] = $realLog['username'];
				$_SESSION['idUser'] = $realLog['idUser'];
			}
		}
		
		header("Location:index.php");
	}
	
	public function disconnect(){
		session_destroy();
		//Redirect to home
		header("Location:index.php");
	}
}