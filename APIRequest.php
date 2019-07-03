<?php

require_once "config.php";


class APIRequest {

	public function sendRequest( $url, $header = array(), $body = array(), $method='GET') {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        
            
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            
        
        if($method=='POST')
            curl_setopt($ch, CURLOPT_POST, $method);	
			
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        

		$result = curl_exec($ch);

        if(!$result) 
        {
            die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
        }

       curl_close($ch);
       
       return $result;
	}


}
