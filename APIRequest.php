<?php

require_once "config.php";

class APIRequest {

	public function sendRequest($img, $url, $header, $body, $method='GET') {
		$uploadedFile = file_get_contents($img);
        $data = array(
			"src" => "data:image/jpeg;base64,".base64_encode($uploadedFile),
			"ocr" => ['math','text']);
        
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, $method);	
			
		}
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        /*
        $uploadedFile = file_get_contents($img);

		$data = array(
			"src" => "data:image/jpeg;base64,".base64_encode($uploadedFile),
			"ocr" => ['math','text']);

		//$ch = curl_init();

		curl_setopt_array($ch, array(
			CURLOPT_URL => $this->url,
			CURLOPT_RETURNTRANSFER => true, // receive server response
			CURLOPT_POST => $this->post, // for post
			CURLOPT_HTTPGET=>$this->get, // for get 
			CURLOPT_HTTPHEADER => $this->head,  // head contains the array of headers
			CURLOPT_POSTFIELDS => json_encode($data),	
		));
        
        
        */

		$result = curl_exec($ch);

		if(!$result) {
                        die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
                }

                curl_close($ch);
                $result2 =   str_replace( '\\', '', $result );  //Removing '//', as ot creates trouble in json_decode 
                $result2 = str_replace('"','\"',$result2);     //Escaping " present inside the string, as that creates                                                  // trouble when we put this string into the database 
                return $result2;
	}


/*	public $url,$method,$head,$post,$get,$body;

	function __construct($url, $method = "GET", $header = array(), $body=array())
	{
		$this->url = $url;
		$this->method = $method;
		$this->head = $header;
		if($method=="GET")
		{
			$this->post=0;
			$this->get=1;
		}

		else
		{
			$this->post=1;
			$this->get=0;
		}
	}

	function sendRequest($img)
	{
		$uploadedFile = file_get_contents($img);

		$data = array(
			"src" => "data:image/jpeg;base64,".base64_encode($uploadedFile),
			"ocr" => ['math','text']);

		$ch = curl_init();

		curl_setopt_array($ch, array(
			CURLOPT_URL => $this->url,
			CURLOPT_RETURNTRANSFER => true, // receive server response
			CURLOPT_POST => $this->post, // for post
			CURLOPT_HTTPGET=>$this->get, // for get 
			CURLOPT_HTTPHEADER => $this->head,  // head contains the array of headers
			CURLOPT_POSTFIELDS => json_encode($data),	
		));

		$result = curl_exec($ch);

		if(!$result)
		{
			die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
		}

		curl_close($ch);
		$result2 =   str_replace( '\\', '', $result );  //Removing '//', as ot creates trouble in json_decode 
		// further processing
		//echo $result2;
		//$obj = json_decode($result2);
		//return array("latex" => $obj->latex,
		//"latex_confidence" =>$obj->latex_confidence);
		$result2 = str_replace('"','\"',$result2);     //Escaping " present inside the string, as that creates                                                  // trouble when we put this string into the database 
		return $result2;
	}
 */
}
