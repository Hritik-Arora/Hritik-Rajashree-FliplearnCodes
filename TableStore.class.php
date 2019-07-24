<?php


class TableStore {
    public $objDBConnection;
	public function __construct($objDBConnection) {
		$this->objDBConnection = $objDBConnection;
	}

	//Function for the 'INSERT' query.
	public function insertResponse($insertArray, $table_name,$fields) {
		$conn = $this->objDBConnection->getDBConnection();
		if($conn != NULL) {
            
            $sql = "SELECT count(*) FROM $table_name WHERE Image_Id =";
            $sql.=$insertArray['Image_Id'];
            $result = $conn->prepare($sql);
            $result->execute();
            $number_of_rows = $result->fetchColumn();
			print_r($number_of_rows);
            if($number_of_rows==0){
                $field_string = implode(",", $fields);
            
                $valueStr="";
            
                foreach($insertArray as $field=>$response)
                {
            
                    $valueStr .= $response;
                    $valueStr.=",";
                }
                $valueStr = rtrim($valueStr,",");
            
                $insertQuery = "INSERT INTO $table_name($field_string) 
				VALUES($valueStr)";
            
            
			    $conn->exec($insertQuery);
            }
			
			$conn = null;
		}
	}

	public function updateResponse($image_Id,$updates = array(), $table_name) {
		$conn = $this->objDBConnection->getDBConnection();
		if($conn != NULL) {
			

			foreach($updates as $field=>$new_response)
            {
               $updateQuery = "UPDATE $table_name SET $field = $new_response where Image_Id = \"$image_Id\"";
			   $conn->exec($updateQuery); 
            }
			

			
			$conn = null;
		}
	}
}
