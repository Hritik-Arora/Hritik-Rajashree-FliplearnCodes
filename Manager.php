<?php
    
class Manager
{
    public $objDB,$objAPI;
    
    function __construct($objDB, $objAPI) {
        $this->objDB = $objDB;
        $this->objAPI = $objAPI;
    }
    
    function getWorkDone($doubt_image,$url, $header, $body, $method , $table_name) {
        $API_response = $this->objAPI->sendRequest($doubt_image,$url, $header, $body, $method);
        $this->objDB->insertResponse($doubt_image, $API_response, $table_name);
    }
}
