<?php

require_once "SolrConfig.php";

class SolrInteraction
{
    
    
    public function search($query)
    {
        global $url, $escapeCharacters, $replacedCharacters, $additionalParams;
        $query = str_replace('\\','',$query);       //Necessary for json_decode() to work properly
        $query = json_decode($query);               //json_decode() returns the object out of the string.
        
        $searchString = $query->{"latex"};          //"latex" extracted 
        
        
        
        
        
        
        $searchString = str_replace($escapeCharacters,$replacedCharacters,$searchString);
    
        $searchString = str_replace(' ', '+',$searchString);    //In curl, space is represented by '+'
    
        $url = $url . $searchString . $additionalParams;
        //Making curl request now
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        
        print_r($result);
        
    }
}


