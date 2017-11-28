 <?php
 include_once 'connection.php';

 	class Sport {

 		private $db;
 		private $connection;

 		function __construct() {
 			$this -> db = new DB_Connection();
 			$this -> connection = $this->db->getConnection();
 		}

 		public function choose_sport($name,$sporttablename)
 		{
			  $query = "Select * from $sporttablename";
			  $result = mysqli_query($this->connection, $query);
			  $response = array();
			  if($result == ""){
				$json['error'] = 'Cant find database entry';
				echo json_encode($json);
			  }else{
				while($row = mysqli_fetch_array($result)){
				  array_push($response, array('Spiel_ID' =>$row[0],'Uhrzeit' =>$row[1], "Halle"=>$row[2],"Mannschaft1"=>$row[3],"Mannschaft2"=>$row[4],"Ergebnis"=>$row[5],"Schiedsrichter"=>$row[6],"Gruppe"=>$row[7]));
				}
				echo json_encode(array($name=> $response));
			  }
			  mysqli_close($this->connection);
		}
}

 	$sport = new Sport();
	if(isset($_POST['sportname'])) {
 		$sportname = $_POST['sportname'];
		$sporttablename = $sportname."_spielplan";

 		if(!empty($sportname)){
 			$sport-> choose_sport($sportname,$sporttablename);

 		}else{
 			$json['error'] = 'Ein Fehler ist auf getreten.';
 			echo json_encode($json);
 		}

 	}
 ?>
