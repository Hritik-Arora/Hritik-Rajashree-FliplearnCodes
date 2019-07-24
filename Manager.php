<?php

require_once "config.php";
    
class Manager
{
    public $objDB,$objAPI,$objSolr;
    
    function __construct($objDB, $objAPI,$objSolr) {
        $this->objDB = $objDB;
        $this->objAPI = $objAPI;
        $this->objSolr = $objSolr;
    }
    
    public function getWorkDone($doubt_image, $table_name, $call_Mathpix = true, $insert_into_database = true, $do_solr_work = true, $do_delta_import = true, $do_search = true )
    {
        global $updates,$fields;
        
        $returnArray = array(); 
        /* $returnArray is an associative array which the Manager will return. The structure of $returnArray is as follows:
            ("Latex" => the full response returned by the Mathpix API,
             "Solr's Results" => The search results returned by Solr,
             "Delta Import" => The delta import status returned by Solr) */
    
        unset($returnArray);
        
        $returnArray["Latex"] = '';
        $returnArray["Solr's Results"] = '';
        $returnArray["Delta Import"] = '';
        
        if($call_Mathpix)
        {
            $Mathpix_API_response = $this->getLatexWorkDone($doubt_image);
        
            //Cleaning the Mathpix_API_response, for making it fit for entering it into the database
        
            $Mathpix_API_response = str_replace( '\\', '', $Mathpix_API_response );  /*Removing '//', as it creates trouble in json_decode*/ 
        
            $Mathpix_API_response = str_replace('"','\"',$Mathpix_API_response);     /*Escaping " present inside the string, as that creates trouble when we put this string into the database */                              
        }
        
        $returnArray["Latex"] = $Mathpix_API_response;
        
        if($insert_into_database)
        {
            $insertArray = array(
                "Image_Id" => "\"$doubt_image\"",
                "Mathpix_API_Response" => "\"$Mathpix_API_response\"",
                "Vision_API_Response" => "\"No Response Yet\"",
                "created_at" => "CURRENT_TIMESTAMP",
                "updated_at" => "CURRENT_TIMESTAMP"
            );
        
            $this->getDBWorkDone($insertArray,$table_name,$fields); 
        }
        
        if($do_solr_work)
        {
            $solrArray = $this->getSolrWorkDone($Mathpix_API_response,$do_delta_import,$do_search);
        }
        
        $returnArray["Solr's Results"] = $solrArray["Solr's Results"];
        $returnArray["Delta Import"] = $solrArray["Delta Import"];
        
        return $returnArray;
        
    }
    
    public function getLatexWorkDone($doubt_image)
    {
        global $mathpix_url, $mathpix_header_array,$mathpix_method;
        
        //Request body for the Mathpix API.
        $uploadedFile = file_get_contents($doubt_image);
        
        $data = array(
			 "src" => "data:image/jpeg;base64,".base64_encode($uploadedFile),
			 "ocr" => ['math','text']);
        
        //Calling the Mathpix API
        $Mathpix_API_response = $this->objAPI->sendRequest($mathpix_url, $mathpix_header_array, $data, $mathpix_method);
        
        return $Mathpix_API_response;
    }
    
    private function getDBWorkDone($insertArray,$table_name,$fields) {
        
        $this->objDB->insertResponse($insertArray, $table_name,$fields);
        //$this->objDB->updateResponse($doubt_image,$updates, $table_name);
        
        
    }
    
    public function getSolrWorkDone ($Mathpix_API_response,$do_delta_import = true, $do_search = true){
        global $search_field, $import_type;
        $SolrResultsArray = array();
        unset($SolrResultsArray);
        $SolrResultsArray["Solr's Results"] = '';
        $SolrResultsArray["Delta Import"] = '';
        
        //Searching for similar documents through Solr
        $SOLR_search_url = $this->objSolr->getSOLR_search_URL($Mathpix_API_response, $search_field);
        $matchedDocuments = $this->objAPI->sendRequest($SOLR_search_url);
        $SolrResultsArray["Solr's Results"] = $matchedDocuments;
        
        //Sending request to Solr for indexing the newly added document.
        if($do_delta_import) 
        {
            $SOLR_index_url = $this->objSolr->getSOLR_index_URL($import_type);
            $import_response = $this->objAPI->sendRequest($SOLR_index_url);
            $SolrResultsArray["Delta Import"] = $import_response; 
        }
        
        
        return $SolrResultsArray;
        
    }
        
}
