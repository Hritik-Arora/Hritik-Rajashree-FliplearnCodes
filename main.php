<?php
//main.php performs the required tasks of 1.sending Mathpix requests, 2.storing the Mathpix response in the database and 3. performing delta import by Solr.

require_once "dbConn.php";
require_once "Factory.php";

           

$objFactory = new Factory();

//Manager Object Created
$objManager = $objFactory->getManagerObj();

$database_dir = "doubtForumImages/";    //name of the folder containing the Doubt Forum Images
$files = array_slice(scandir($database_dir), 2);

for($i=0;$i<sizeof($files);$i++)        //Loop to run the program over all the Doubt Forum Images
{
    $doubt_image = $database_dir . $files[$i];      //The image whose API response we want to store

    /*Getting work done from Manager-
    i) Retrieving the Mathpix API response
    ii) Inserting the response into database
    iii) Performing delta import(includes document indexing) by Solr
    */
  
    /* getWorkDone() function prototype
    getWorkDone($doubt_image, $table_name, $call_Mathpix = true, $insert_into_database = true, $do_solr_work = true, $do_delta_import = true, $do_search = true )*/
    
    $objManager->getWorkDone($doubt_image, $table_name,true,true,true,true,false);
    
}

