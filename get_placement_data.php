 <?php
 include_once 'connection.php';

 	class PlacementData {

 		private $db;
 		private $connection;

 		function __construct() {
 			$this -> db = new DB_Connection();
 			$this -> connection = $this->db->getConnection();
 		}

 		public function get_placement_data($sportart,$sportart1)
 		{
			$sql = "SELECT * FROM $sportart1 Order BY Punkte DESC";//Abfrage der Tabelle und Sortierung nach Punkte 
			$result = mysqli_query($this->connection, $sql);
			if($result == ""){
				$json['error'] = 'Cant find database entry';
				echo json_encode($json);
			}
			else{	
				$response = array();
				while($row = mysqli_fetch_array($result)){
				array_push($response, array('Mannschaft' =>$row[0],'Punkte' =>$row[1],'Torverhaeltnis' =>$row[2],));
				}
				echo json_encode($response);
			}
			mysqli_close($this->connection);
		}
	}
	
	
	if(isset($_POST['sportname'])){
	$placementData = new PlacementData();
	$sportart = $_POST['sportname'];
	$sportart1 = $sportart."_platzierung";
 	$placementData-> get_placement_data($sportart,$sportart1);
	}
?>