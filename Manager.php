<?php

require_once "config.php";
    
class Manager
{
    public $objDB,$objAPI;
    
    function __construct($objDB, $objAPI,$objSolr) {
        $this->objDB = $objDB;
        $this->objAPI = $objAPI;
        $this->objSolr = $objSolr;
    }
    
    public function getWorkDone($doubt_image, $table_name)
    {
        global $mathpix_url, $mathpix_header_array,$mathpix_method;
        
        //Request body for the Mathpix API.
        $uploadedFile = file_get_contents($doubt_image);                      
        $data = array(
			 "src" => "data:image/jpeg;base64,".base64_encode($uploadedFile),
			 "ocr" => ['math','text']);
        
        //Calling the Mathpix API
        $Mathpix_API_response = $this->objAPI->sendRequest($mathpix_url, $mathpix_header_array, $data, $mathpix_method);
        
        //Cleaning the Mathpix_API_response, for making it fit for entering it into the database
        
        $Mathpix_API_response = str_replace( '\\', '', $Mathpix_API_response );  /*Removing '//', as it creates                                                                            trouble in json_decode*/ 
        
        $Mathpix_API_response = str_replace('"','\"',$Mathpix_API_response);     /*Escaping " present inside the         string, as that creates trouble when we put this string into the database */                             
        
        $this->getDBWorkDone($doubt_image,$Mathpix_API_response,$table_name);
        $this->getSolrWorkDone($Mathpix_API_response);
    }
    
    private function getDBWorkDone($doubt_image,$API_response,$table_name) {
        
        $this->objDB->insertResponse($doubt_image, $API_response, $table_name);
        
        
    }
    
    private function getSolrWorkDone ($Mathpix_API_response){
        global $search_field, $import_type;
        
        //Searching for similar documents through Solr
        $SOLR_search_url = $this->objSolr->getSOLR_search_URL($Mathpix_API_response, $search_field);
        $matchedDocuments = $this->objAPI->sendRequest($SOLR_search_url);
        print_r($matchedDocuments);
        
        //Sending request to Solr for indexing the newly added document.
         
        $SOLR_index_url = $this->objSolr->getSOLR_index_URL($import_type);
        $import_response = $this->objAPI->sendRequest($SOLR_index_url);
        print_r($import_response);
        
    }
        
}
