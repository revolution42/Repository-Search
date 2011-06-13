<?php

class BitBucket implements RepoSearchInterface
{
	private $baseUrl = 'https://bitbucket.org/';
	
	public function search($term)
	{
		$api = new bbApi();
		$bbRepos = $api->getApi("repositories");
		
		$returnArray = array();

		foreach( $bbRepos->search(null, $term)->repositories as $result )
		{
			$returnResult = new Result();
			$returnResult->name = $result->name;
			$returnResult->type = "bitbucket";
			$returnResult->url = $this->baseUrl . $result->owner . '/' . $result->name;
			$returnArray[] = $returnResult;
		}
		
		return $returnArray;
	}
	
	public function init()
	{
		require_once DIR_BASE.'lib/BitBucket/bbApi.php';
	}
}
