<?php

require_once "DBInteractionNew.php";

class TableStore {
    public $objDBConnection;
	public function __construct() {
		$this->objDBConnection = new DBInteractionNew();
	}

	//Function for the 'INSERT' query.
	public function insertResponse($image_Id, $response, $table_name) {
		$conn = $this->objDBConnection->getDBConnection();
		if($conn != NULL) {
			$insertQuery = "INSERT INTO $table_name(Image_Id,Mathpix_API_Response) 
				VALUES(\"$image_Id\",\"$response\")";
			$conn->exec($insertQuery); 
			
			$conn = null;
		}
	}

	public function updateResponse($updates = array(), $table_name) {
		$conn = $this->objDBConnection->getDBConnection();
		if($conn != NULL) {
			$image_Id = $updates["Image_Id"];
			//collecting row
			$record = $conn->prepare("SELECT * FROM $table_name where id= $image_Id");
			if($record->execute()) {
				$row = $record->fetch(PDO::FETCH_OBJ);
			}

			//mathpix_response update
			if($updates["Mathpix_API_Response"]!= null)
				$response1= $updates["Mathpix_API_Response"];
			else
				$response1= $row["Mathpix_API_Response"];

			$updateQuery = "UPDATE $table_name SET Mathpix_API_Response= \"$response1\" where Image_Id = \"$image_Id\"; ";
			$conn->exec($updateQuery);
			$conn = null;
		}
	}
}
