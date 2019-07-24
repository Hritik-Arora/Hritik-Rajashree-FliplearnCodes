<!DOCTYPE html>
<html lang="en">
	<head>
        <?php
            require_once "dbConn.php";
            require_once "Factory.php";
        ?>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    	<!-- Bootstrap CSS -->
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<title>Run on All Images</title>
	</head>
	<body>

		
            <div class="container">
			
                    <?php
				    
                            
                            $database_dir = "doubtForumImages/";
            
                            
                            $objFactory = new Factory();

                            //Manager Object Created
                            $objManager = $objFactory->getManagerObj();
            
                            //Creating a Database connection for extracting the Mathpix API Latex 
                            
        
                            
                            $files = array_slice(scandir($database_dir), 2);
                            
                            for($i=0;$i<sizeof($files);$i++)
                            {
                                $doubt_image = $database_dir . $files[$i];
                                
                                $conn = $objManager->objDB->objDBConnection->getDBConnection();
                                $Mathpix_API_response = $conn->query("SELECT Mathpix_API_Response FROM $table_name WHERE Image_Id = \"$doubt_image\" LIMIT 1")->fetch()["Mathpix_API_Response"]; 
                                $conn = null;
                                
                                $responseArray = array();
                                
                                //getSolrWorkDone() function prototype
                                //getSolrWorkDone($Mathpix_API_response,$do_delta_import)
                                $responseArray = $objManager->getSolrWorkDone($Mathpix_API_response,false);
                                
                                $SolrResults = json_decode($responseArray["Solr's Results"]);
                                
                                
                                echo <<<END
                                <div class="row border border-dark m-4 p-4 overflow-auto">
                                
                                    <div class="col-sm-12">
                                        <h3>Database Image $i </h3>
                                        <img class="img-fluid" src = "$doubt_image"><br><br>
                                    </div>
                                
                                
                                    <div class="col-sm-12">
                                        <h4>Solr's Responses</h4>
                                        
                                    </div>
END;
                                
                                
                                for($j=0;$j<min(3,$SolrResults->{"response"}->{"numFound"});$j++)
                                {
                                    
                                    
                                    $image_file = $SolrResults->{"response"}->{"docs"}[$j]->{"id"};
                                    $score = $SolrResults->{"response"}->{"docs"}[$j]->{"score"};
                                    echo <<<END
                                    <div class="col-sm-12 border border-success overflow-auto p-4 mb-4">

                                        
                                    
                                    
                                        <h5>Image:</h5>
                                        <img class="img-fluid" src="$image_file"> <br>

                                        <h5>Score: </h5>
                                        $score
                                      
                                    
                                    </div>
END;
                        

                                
                                }
                                
                                echo "</div>";
                                    
                            }
                         
                     ?>
			 
            
        </div>

  
        
		<!--Bootstrap Scripts -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>