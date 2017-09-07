<?php
	require_once 'config.php';
	include_once 'connection.php';


	class User {

		private $db;
		private $connection;

		function __construct() {
			$this -> db = new DB_Connection();
			$this -> connection = $this->db->getConnection();
		}

		public function does_user_exist($username)
		{
			$query = "Select * from users where Username='$username'";
			$result = mysqli_query($this->connection, $query);
			if(mysqli_num_rows($result)>0){
				return true;
			}else{
				return false;
			}
		}
		public function register($username,$password){
			$obj = new \stdClass();
			if(registration_active){
				if($this -> does_user_exist($username)){
				  $obj->status = "error";
				  $obj->message = "Benutzer existiert bereits";
				}else {
				  $query = "Insert into users (Username,password, permissions) VALUES ('$username','$password',2)";
				  $inserted = mysqli_query($this->connection, $query);
				  if($inserted == 1){
					  $obj->status = "registered";
					  $obj->message = "success";
					}else{
						$obj->status = "error";
						$obj->message = "Benutzer wurde nicht erstellt";
					}
				}
			}else{
				$obj->status = "error";
				$obj->message = "Registrierung ist deaktiviert";
			}
			echo json_encode($obj);
			mysqli_close($this->connection);
		}

		public function login($username,$password)
		{
			$obj = new \stdClass();
			$query = "Select * from users where Username='$username'AND password='$password'";
			$result = mysqli_query($this->connection, $query);
			  
			if(mysqli_num_rows($result)>0){
				$permission = mysqli_fetch_array($result);
				$permission = $permission[2];
				if(!empty($permission)){
					$obj->status = "logged_in";
					$obj->permission = $permission;  
				}else{
					$obj->status = "error";
					$obj->message = "Keine Rechte festgelegt";  
				}
			}else{
				$query = "Select * from users where Username='$username'";
				$result = mysqli_query($this->connection, $query);
				if(mysqli_num_rows($result)>0){
					$obj->status = "error";
					$obj->message = "Falsches Passwort";  
				}else{
					$obj->status = "error";
					$obj->message = "Benutzer existiert nicht";  	
				}
			}
			echo json_encode($obj); 
			mysqli_close($this->connection);
		}
  }
  //CLASS USER END

	$user = new User();
	if(isset($_POST['type'])) {
    if($_POST['type'] == "login"){
      $username = $_POST['username'];
  		$password = $_POST['password'];
      if(!empty($username) && !empty($password)){
        $encrypted_password = md5($password);
        $user-> login($username,$encrypted_password);
      }else{
        $json["error"] = "Benutzername oder Passwortfeld sind leer";
        echo json_encode($json);
      }
    }elseif ($_POST['type'] == "register") {
      $username = $_POST['username'];
  		$password = $_POST['password'];
      if(!empty($username) && !empty($password)){
        $encrypted_password = md5($password);
        $user-> register($username,$encrypted_password);
      }else{
        $json["error"] = "Benutzername oder Passwortfeld ist leer";
        echo json_encode($json);
      }
    }else{
			$json['error'] = 'Type not found';
			echo json_encode($json);
		}
	}else {
	  $json['error'] = 'No type found';
    echo json_encode($json);
	}
?>
