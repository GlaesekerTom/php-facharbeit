<?php
 include_once 'connection.php';

 	class Updater {

 		private $db;
 		private $connection;

 		function __construct() {
 			$this -> db = new DB_Connection();
 			$this -> connection = $this->db->getConnection();
 		}

 		public function choose_sport($Sportart1,$SportartPlatzierung,$Tore,$Spiel_ID)
 		{
			$sql = "UPDATE $Sportart1 SET Ergebnis = '$Tore' WHERE Spiel_ID = '$Spiel_ID'";
			$result = mysqli_query($this->connection, $sql);
			if($result == ""){
				echo "Fehler";
			}
			
			/*$query = "Select * from $SportartPlatzierung where mannschaft = '$mannschaft1'";
					echo $sportartPlatzierung[$j];
					echo $mannschaft1;
					$result = mysqli_query($this->connection, $query);
					$response2 = array();
					if($result == ""){
						$json = "Cant find database entry sportPlat";
						echo json_encode($json);
					}else{
						while($row = mysqli_fetch_array($result)){
							array_push($response2, array('punkte' =>$row[1],'torverhaeltnis' =>$row[2]));
						}
						  $arrayBla = json_decode(json_encode($response2),true);
						  
						  if(strcmp(json_encode($response2),"[]")!==0){
							  $torverhaeltnis= $arrayBla[0]["torverhaeltnis"];
							  $tor = explode(":",$torverhaeltnis);
							  $torverhaeltnis1 += $tor[0];
							  $torverhaeltnis2 += $tor[1];
							  $torverhaeltnis = $torverhaeltnis1.":".$torverhaeltnis2;
							  echo $torverhaeltnis;
							  $punkte+= $arrayBla[0]["punkte"];
						  }
					}
				}
			
			$sql = "UPDATE $SportartPlatzierung SET punkte = '$Tore' WHERE Spiel_ID = '$Spiel_ID'";*/
		}
}
 	$updater = new Updater();
	if(isset($_POST['sport'],$_POST['spielId'],$_POST['t1'],$_POST['t2'])){
	$Sportart = $_POST['sport'];
	$Sportart1 = $Sportart."_spielplan";
	$SportartPlatzierung = $Sportart."_platzierung";
	$Spiel_ID = $_POST['spielId'];
    $ToreTeam1 = $_POST['t1'];
	$ToreTeam2 = $_POST['t2'];
	$Tore = $ToreTeam1.":".$ToreTeam2;
	$updater -> choose_sport($Sportart1,$SportartPlatzierung,$Tore,$Spiel_ID);
	}
 ?>
