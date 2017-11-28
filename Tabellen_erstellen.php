 <?php
 include_once 'connection.php';

 	class TableCreator {

 		private $db;
 		private $connection;

 		function __construct() {
 			$this -> db = new DB_Connection();
 			$this -> connection = $this->db->getConnection();
 		}

 		public function create_tables()
 		{
			$json['success']= 'Alle Tabellen wurden richtig erstellt.';
			$sportartPlatzierung = array("Volleyball_platzierung","Fussball_platzierung","Basketball_platzierung","Badminton_platzierung","Hockey_platzierung","Gesamt_platzierung");//array mit Namen für Tabellen
			for($i=0; $i<count($sportartPlatzierung);$i++){//for-Schleife durchläuft den Array
				$sql = "CREATE TABLE $sportartPlatzierung[$i] (mannschaft VARCHAR(20), punkte int, torverhaeltnis VARCHAR(15),Gruppe CHAR)";
				$result = mysqli_query($this->connection, $sql);
				if ($result != 1){
					$json['error']= 'Platzierungstabelle wurde nicht erstellt';
					break;
				}
			}
			//Platzierungstabellen wurden erstellt
			$sportartSpielplan = array("Volleyball_spielplan", "Fussball_spielplan","Basketball_spielplan","Badminton_spielplan","Hockey_spielplan");
			for($i=0; $i<count($sportartSpielplan);$i++){
				$sql = "CREATE TABLE $sportartSpielplan[$i] (Spiel_ID int Auto_Increment, Uhrzeit VARCHAR(20), Halle int, Mannschaft1 VARCHAR(10), Mannschaft2 VARCHAR(10), Ergebnis VARCHAR(10) DEFAULT'-', 
						Schiedsrichter VARCHAR(10),Gruppe CHAR,Primary Key(Spiel_ID))";
				$result = mysqli_query($this->connection, $sql);
				if ($result != 1){
					$json['error']= 'Spielplantabelle wurde nicht erstellt';
					break;
				}
			}
			$sql= "CREATE TABLE Sportarten (sportartname VARCHAR(20))";
			$result = mysqli_query($this->connection, $sql);
				if ($result != 1){
					$json['error']= 'Sportartentabelle wurde nicht erstellt';
				}
			$sql= "CREATE TABLE Mannschaft (Name VARCHAR(10), Lehrer VARCHAR(10))";	
			$result = mysqli_query($this->connection, $sql);
				if ($result != 1){
					$json['error']= 'Mannschaftentabelle wurde nicht erstellt';
				}
			/*$sql = "CREATE TABLE User (name VARCHAR(20), berechtigung VARCHAR(20), password VARCHAR(15))";
			$result = mysqli_query($this->connection, $sql);
				if ($result == 1){
					$json['success'] = 'Benutzertabelle wurde erstellt';
				} else {
					$json['error']= 'Benutzertabelle wurde nicht erstellt';
				}*/
			echo json_encode($json);
			mysqli_close($this->connection);
		}
}

 	$tableCreator = new TableCreator();
 			$tableCreator-> create_tables();
?>