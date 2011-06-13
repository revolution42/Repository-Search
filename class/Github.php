<?php

class Github implements RepoSearchInterface
{
	public function search($term)
	{		
		$github = new Github_Client();

		$returnArray = array();
		
		foreach( $github->getRepoApi()->search($term) as $result )
		{
			$returnResult = new Result();
			
			$returnResult->name = $result['name'];
			$returnResult->type = "github";
			$returnResult->url = $result['url'];
			
			$returnArray[] = $returnResult;
		}
		
		return $returnArray;
	}
	
	public function init()
	{
		require_once DIR_BASE . 'lib/Github/Autoloader.php';
		Github_Autoloader::register();
	}
}
