<?php
	/* FAPPERS API
	Speak with database using HTTP POST from Android
	*/
	define('ERROR_LOG_FILE', 'error.log');
	define("GOOGLE_API_KEY", "AIzaSyBJN6nfeeGXEX7-gjwUrBDhVivAYtt_ywQ");
    define("GOOGLE_GCM_URL", "https://android.googleapis.com/gcm/send");
	
	require_once('Model.php');
	
	if(isset($_POST['action'])){
		$action = $_POST['action'];
		
		if($action == 'signin'){
			$username = getParameter('username');
			$password = getParameter('password');
			$regid = getParameter('registration_id');
			
			
			$sql = 'SELECT id, username, password FROM user WHERE username=:username';
			$login=Model::executeRequest($sql, array('username'=> $username))->fetch(PDO::FETCH_ASSOC);
			
			$id="0";
			
			//Password checking
			if($login['password']==$password){
				$success="1";
				$id=$login['id'];
				//Storing GCM registration_id
				$sql_storeRId='UPDATE user SET registration_id=:regid WHERE user.id=:id';
				Model::executeRequest($sql_storeRId, array('regid' => $regid, 'id' => $id));
			}
			else{
				$success="0";
			}
			
			//Sending data in JSON format
			$data=array('action'=>$action,'success' => $success, 'id' => $id, 'username'=>$login['username']);
			echo json_encode($data);
		}
		elseif($action == 'friends'){
			if(isset($_POST['id'])){
				$id = $_POST['id'];
			}
			else{
				$id = "0";
			}
			
			$sql = 'SELECT user.id, user.username FROM friendship '.
			'INNER JOIN user ON user.id=friendship.idFriend2 WHERE friendship.idFriend1=:id';
			$friends=Model::executeRequest($sql, array('id'=> $id ))->fetchAll(PDO::FETCH_ASSOC);
			
			//Show json
			echo json_encode(array('action'=>$action, 'success'=> '1','friends' => $friends));
		}
		elseif($action == 'search'){
			$username = $_POST['username'];
			
			$sql = 'SELECT id, username FROM user WHERE username=:username';			
			$user=Model::executeRequest($sql, array('username' => $username ))->fetch(PDO::FETCH_ASSOC);
		
			//Verification du resultat de la requête
			$id='0';
			$success='0';
			$username='';
			if($user != null){
				$id=$user['id'];
				$success='1';
				$username=$user['username'];
			}
			
			echo json_encode(array('action'=>$action, 'success'=> $success, 'id' => $id, 'username' => $username));
		}
		elseif($action == 'addFriend'){
			$id = $_POST['id'];
			$idFriend = $_POST['idFriend'];
			
			$sql='INSERT INTO friendship(idFriend1, idFriend2, state) VALUES (:id1, :id2, :state)';
			$reponse=Model::executeRequest($sql, array('id1'=> $id, 'id2' => $idFriend, 'state' => 'pending' ));
			
			$success='1';
			
			echo json_encode(array('action'=>$action,'success'=> $success));
			
		} elseif($action == 'deleteFriend'){
			$id = $_POST['id'];
			$idFriend = $_POST['idFriend'];
			
			$sql='DELETE FROM friendship WHERE idFriend1=:id AND idFriend2=:idFriend';
			Model::executeRequest($sql, array('id' => $id, 'idFriend' => $idFriend));
			
			echo json_encode(array('action'=>$action,'success'=> '1'));
			
		} elseif($action == 'register'){
			$registration_id = $_POST['registration_id'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			//Server test of input lengths
			if(strlen($username)< 4){
				echo json_encode(array('action'=>$action,'success'=> '0', 'error' => 'username too short'));
				return;
			} else{
				if(strlen($password)< 5){
					echo json_encode(array('action'=>$action,'success'=> '0', 'error' => 'password too short'));
					return;
				}
			}
			
			//Check if username exists
			$sql='SELECT * FROM user WHERE username=:username';
			$user=Model::executeRequest($sql, array('username' => $username))->fetchAll(PDO::FETCH_ASSOC);
			
			//If user is not empty => username exists
			if($user == null){
				$sql='INSERT INTO user(registration_id, username, password) VALUES(:registration_id, :username, :password)';
				
				//Surround with begin and commit to do a transaction (so lastInsertId() works)
				$bdd=Model::getBdd();
				$reponse = $bdd->prepare($sql);
				$bdd->beginTransaction();
				$reponse->execute(array('registration_id' => $registration_id, 'username' => $username, 'password' => $password));
				
				$lastId = $bdd->lastInsertId();
				$bdd->commit();
				
				
				
				echo json_encode(array('success'=> '1', 'username'=> $username, 'password' => $password, 'id' => $lastId));
			} else{
				echo json_encode(array('success'=> '0'));
			}
	
		} elseif($action == 'fapped'){
			$id=$_POST['id'];
			
			$sql='SELECT user.id, user.registration_id FROM friendship INNER JOIN user ON user.id=friendship.idFriend2 WHERE friendship.idFriend1=:id';
			$friends=Model::executeRequest($sql, array('id' => $id ))->fetchAll(PDO::FETCH_ASSOC);
			//var_dump($friends);
			
			//Envoyer un message à l'ensemble des amis
			$regIds=array();
			foreach($friends as $friend){
				$regIds = array_merge($regIds, array($friend['registration_id']));
			}
			
			$message = array('data' => array('fapped' => 'yes'), 'registration_ids' => $regIds);
			$json_message=json_encode($message);
			var_dump($json_message);
			sendGCM($json_message);
			
		} elseif($action == 'manual'){
			$username = $_POST['username'];
			
			$sql='SELECT id, registration_id FROM user WHERE username=:username';
			$user=Model::executeRequest($sql, array('username' => $username ))->fetch(PDO::FETCH_ASSOC);
			$regIds=array($user['registration_id']);
			
			$message = array('data' => array('fapped' => 'yes'), 'registration_ids' => $regIds);
			$json_message=json_encode($message);
			var_dump($json_message);
			sendGCM($json_message);
			
		} else{
			echo 'This action does not exist';
		}
	} else{
		//Aucune action dans POST
		echo 'Error no action in POST';
	}
	
	function getParameter($key){
		if(isset($_POST[$key]) && $_POST[$key] != ""){
			return $_POST[$key];
		} else{
			echo 'Error, key '.$key.' does not exist';
		}
	}
	
	function sendGCM($json_message){
		$headers = array(
			'Content-Type:application/json',
			'Authorization:key='.GOOGLE_API_KEY
		);
		
		var_dump($headers);
		
		//Init curl
		$ch = curl_init();
		
		 // Set the URL, number of POST vars, POST data
		curl_setopt( $ch, CURLOPT_URL, GOOGLE_GCM_URL);
		curl_setopt( $ch, CURLOPT_POST, true);
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_message);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		// Execute post
		$result = curl_exec($ch);

		// Close connection
		curl_close($ch);
		var_dump($result);
		echo $result;
	}
	
?>