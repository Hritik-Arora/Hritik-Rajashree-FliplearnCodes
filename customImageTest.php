<!DOCTYPE html>
<html lang="en">
	<head>
        <?php
            require_once "dbConn.php";
            require_once "Factory.php";
            require_once "config.php";
        ?>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    	<!-- Bootstrap CSS -->
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<title>Fliplearn Similar Doubts- Solr's Results</title>
	</head>
	<body>
        
        <?php
				    
                if($_FILES)
                {
                    $target_dir = "testImages/";
                    $target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
                    $uploadOK = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                            
                    global $mathpix_url, $mathpix_header_array,$mathpix_method;
                            

                    move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$target_file);
                            
                        
                    $doubt_image = $target_file;
                        
                    $objFactory = new Factory();

                    //Manager Object Created
                    $objManager = $objFactory->getManagerObj();
                    
                    // getWorkDone() function prototype
                    //getWorkDone($doubt_image, $table_name, $call_Mathpix = true, $insert_into_database = true, //$do_solr_work = true, $do_delta_import = true )
                    
                    $returnedArray = $objManager->getWorkDone($doubt_image, $table_name, true,false,true,false);
                    
                    
                    $SolrResults = $returnedArray["Solr's Results"];
                    $SolrResults = json_decode($SolrResults);
                    
                    
                }
        
            ?>
        
		<div class="container">
			<div class="row border border-dark overflow-auto p-4 mb-4">
                <div class="col-sm-12 border border-dark overflow-auto p-4 mb-4">
                    <h4>Uploaded Image</h4>
                    <?php echo "<img src=\"$target_file\" class=\"img-fluid\"><br>";
                        
                    ?>
                    
			     </div>
                
                
                
			
                <div class="col-sm-12"><h4>Solr's Results</h4></div>
                
                <?php
                    
                    
                    for($i=0;$i<min(4,$SolrResults->{"response"}->{"numFound"});$i++)
                    {
                        
                        $image_file = $SolrResults->{"response"}->{"docs"}[$i]->{"id"};
                        $score = $SolrResults->{"response"}->{"docs"}[$i]->{"score"};
                        
                        echo <<<END
                        
                        <div class="col-sm-12 border border-success overflow-auto p-4 mb-4">
                            
                            <h5>Image:</h5>
                            <img class="img-fluid" src="$image_file"> <br>
                            <h5>Score: </h5>
                            $score;
                        
                        </div>
                
END;
                        
                    }
                    
                    
                ?>
            
            </div>
		</div>
  























		
		<!--Bootstrap Scripts -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>