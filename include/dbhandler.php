<?php
 
/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Ravi Tamada
 */
class DbHandler {
 
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . './DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
	
	public function getHotPlacesAt($city_id) {
        $stmt = $this->conn->prepare("CALL get_hot_places_from(?);");
        $stmt->bind_param("i", $city_id);
        $stmt->execute();
        $places = $stmt->get_result();
        $stmt->close();		
        return $places;
    }
	
	public function getSpecialsOf($place_id, $datetime) {
		$stmt = $this->conn->prepare("CALL get_specials_of(?,?);");
        $stmt->bind_param("is", $place_id, $datetime);
        $stmt->execute();
        $places = $stmt->get_result();
        $stmt->close();		
        return $places;
	}
	
}
 
?>