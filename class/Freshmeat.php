<?php

class Freshmeat implements RepoSearchInterface
{
	private $url = "http://freshmeat.net/search.json";
	private $baseUrl = "http://freshmeat.net/projects/";
	private $auth_code = "wOXdWk3TBD6INZbykL7u";
	
	function search($term)
	{
	    $options = array( 
	        CURLOPT_HEADER => 0, 
	        CURLOPT_URL => $this->url, 
	        CURLOPT_FRESH_CONNECT => 1, 
	        CURLOPT_RETURNTRANSFER => 1, 
	        CURLOPT_FORBID_REUSE => 1, 
	        CURLOPT_TIMEOUT => 4, 
	        CURLOPT_POSTFIELDS => http_build_query(
				array(
					'q'=>$term,
					'auth_code'=>$this->auth_code
				)				
			) 
	    ); 
	
	    $session = curl_init(); 
	    curl_setopt_array($session, $options); 
	    if( ! $rawResult = curl_exec($session)) 
	    { 
	        trigger_error(curl_error($session)); 
	    } 
	    curl_close($session);
		
		$returnArray = array();
		
		foreach( json_decode($rawResult)->projects as $key => $result )
		{
			$returnResult = new Result();
			$returnResult->name = $result->project->name;
			$returnResult->type = "freshmeat";
			$returnResult->url = $this->baseUrl . $result->project->permalink;
			$returnArray[] = $returnResult;
		}
		
	    return $returnArray; 
	}
	
	
	public function init()
	{
		// Override the autocode with something set in the settings
	}
}