 <?php
 include_once 'connection.php';

 	class TournamentCreator {

 		private $db;
 		private $connection;

 		function __construct() {
 			$this -> db = new DB_Connection();
 			$this -> connection = $this->db->getConnection();
 		}

 		public function create_tournament($jsonArray)
 		{
			$jsonArray = json_decode($jsonArray,true);
			$json1['success'] = "Mannschaften wurden eingetragen";
			$json['success'] = "Mannschaften wurden eingetragen";
			for( $j=0;$j<count($jsonArray);$j++){
				$Mannschaft= $jsonArray[$j]["name"];
				$Lehrer = $jsonArray[$j]["lehrer"];
				echo $Mannschaft;
				
				$sql = "Insert Into mannschaft Values ('$Mannschaft', '$Lehrer')";//SQL-Befehl um die Daten in die Tabelle einzugeben
				$result = mysqli_query($this->connection, $sql);
				if ($result == ""){
					$json['error'] = "Mannschaft wurde nicht eingetragen";
				}
				$sportartPlatzierung = array("volleyball_platzierung","fussball_platzierung","basketball_platzierung","badminton_platzierung","hockey_platzierung","gesamt_platzierung");
				for($i=0; $i<count($sportartPlatzierung);$i++){//for-Schleife durchläuft den Array
					$sql = "Insert Into $sportartPlatzierung[$i] (Mannschaft) Values ('$Mannschaft')";//Mannschaften werden auch in die Platzierungstabellen eingegeben
					$result = mysqli_query($this->connection, $sql);
					if ($result == ""){
						$json1['error'] = "Mannschaft wurde nicht eingegeben";//Fehlermeldung
					}
				}
			}
			echo json_encode ($json1);
			echo json_encode ($json);
		mysqli_close($this->connection);
		}
	}
	if(isset($_POST['teams'])){
	$jsonArray = $_POST['teams'];
	$tournamentCreator = new TournamentCreator();
 	$tournamentCreator-> create_tournament($jsonArray);
	}
?>