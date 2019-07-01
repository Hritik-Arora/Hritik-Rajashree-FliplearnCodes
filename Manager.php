<?php

    
class Manager
{
    public $objDB,$objAPI;
    
    function __construct($objDB, $objAPI,$objSolr) {
        $this->objDB = $objDB;
        $this->objAPI = $objAPI;
        $this->objSolr = $objSolr;
    }
    
    function getWorkDone($doubt_image,$url, $header, $body, $method , $table_name)
    {
        $API_response = $this->objAPI->sendRequest($doubt_image,$url, $header, $body, $method);
        $this->getDBWorkDone($doubt_image,$API_response,$table_name);
        $this->getSolrWorkDone($API_response);
    }
    
    function getDBWorkDone($doubt_image,$API_response,$table_name) {
        //$API_response = $this->objAPI->sendRequest($doubt_image,$url, $header, $body, $method);
        $this->objDB->insertResponse($doubt_image, $API_response, $table_name);
        
        
    }
    
    function getSolrWorkDone ($API_response){
        
        $this->objSolr->search($API_response);
        
    }
        
}
