<?php

require_once "config.php";

class SolrInteraction
{
    
    
    public function getSOLR_search_URL($query, $search_field)
    {
        global $search_url, $escapeCharacters, $replacedCharacters, $additionalParams;
        $query = str_replace('\\','',$query);       //Necessary for json_decode() to work properly
        $query = json_decode($query);               //json_decode() returns the object out of the string.
        
        $searchString = $query->{"latex"};          //"latex" extracted 
        
        $searchString = str_replace($escapeCharacters,$replacedCharacters,$searchString);
    
        $searchString = str_replace(' ', '+',$searchString);    //In curl, space is represented by '+'
    
        $solr_search_url = $search_url . $searchString . $additionalParams . "&df=" . $search_field;
            
    
        return $solr_search_url;
        
        
    }
    
    public function getSOLR_index_URL($import_type)
    {
        global $index_url;
        return ($index_url . $import_type);
    }
}


