<?php
//Muesste als Cronjob ausgeführt werden.
 include_once 'connection.php';

 	class TotalResultCalc {

 		private $db;
 		private $connection;

 		function __construct() {
 			$this -> db = new DB_Connection();
 			$this -> connection = $this->db->getConnection();
 		}

 		public function get_placement_data()
 		{
			$json = "a";
			$query = "Select * from Mannschaft";
			  $result = mysqli_query($this->connection, $query);
			  $response = array();
			  if($result == ""){
				$json['error'] = 'Cant find database entryyy';
				echo json_encode($json);
			  }else{
				while($row = mysqli_fetch_array($result)){
				  array_push($response, array('Name' =>$row[0],'Lehrer' =>$row[1]));
				}
				$mannschaften = json_decode(json_encode($response),true);//,true);
			  }
			$sportartPlatzierung = array("volleyball_platzierung","fussball_platzierung","basketball_platzierung","badminton_platzierung","hockey_platzierung");
			for($i=0; $i<count($mannschaften);$i++){
				$mannschaft1 = $mannschaften[$i]["Name"];
				echo $mannschaft1;
				//Mannschaften
				$torverhaeltnis = "";
				$torverhaeltnis1 = 0;
				$torverhaeltnis2 = 0;
				$punkte = 0;
				
				for($j=0; $j<count($sportartPlatzierung);$j++){
					
					$query = "Select * from $sportartPlatzierung[$j] where mannschaft = '$mannschaft1'";
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
				$query = "UPDATE gesamt_platzierung SET punkte = '$punkte', torverhaeltnis= '$torverhaeltnis' WHERE mannschaft = '$mannschaft1'";
				$result = mysqli_query($this->connection, $query);
				if($result == ""){
				$json = 'Cant find database entry';
				echo json_encode($json);
				}else{
				$json = 'Punkte eingetragen';
				echo json_encode($json);	
				}
			}
		}
	}
	
	
	$totalResultCalc = new TotalResultCalc();
 	$totalResultCalc-> get_placement_data();
?>