<?php

require_once "login.php";



class DBInteraction
{
    public $conn;
    function DBConnection($servername,$username,$password,$db)  //Function for making PDO Connection to database
    {
        try 
        {
            $this->conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return TRUE; 
        }
        catch(PDOException $e)
        {
            return FALSE;  
            //$e->getMessage();
        }
    }
    
    function DBClose()          //Function for closing the database connection
    {
        $this->conn = null;
    }
    
    //Function for the 'INSERT' query.
    function insertResponse($servername,$username,$password,$image_Id, $response,$db,$table_name)
    {
        $status = $this->DBConnection($servername,$username,$password,$db);
        if($status==TRUE)
        {
            //$insertString = " latex: " . " $response1[latex] " . "\n latex_confidence: ";  
            //$insertString.=    " $response1[latex_confidence] " ;
            //print_r($temp);
            
            $insertQuery = "INSERT INTO $table_name(Image_Id,Mathpix_API_Response) 
                        VALUES(\"$image_Id\",\"$response\")";
        
            $this->conn->exec($insertQuery); 
            
            $this->DBClose();
        }
        
        
    }
    
    function updateResponse($servername,$username,$password,$updates = array(),$db,$table_name)
    {
        $status = $this->DBConnection($servername,$username,$password,$db);
        if($status == TRUE)
        {
            $row;
            $image_Id = $updates["Image_Id"];
            //collecting row
          
            $record=$conn->prepare("SELECT * FROM $table_name where id= $image_Id");
            if($record->execute())
            {
                $row = $record->fetch(PDO::FETCH_OBJ);
            }
          
            //mathpix_response update
          
            if($updates["Mathpix_API_Response"]!= null)
                $response1= $updates["Mathpix_API_Response"];
            else
                $response1= $row["Mathpix_API_Response"];
          
        
            $updateQuery = "UPDATE $table_name SET Mathpix_API_Response= \"$response1\" where Image_Id = \"$image_Id\"; ";
            $conn -> exec($updateQuery);
              
              
        
            $this->DBClose();
        }
        
    }
        
}
