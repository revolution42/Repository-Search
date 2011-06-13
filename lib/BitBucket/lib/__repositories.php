<?php
 
require_once ('bbApiAbstract.php');

class Repositories extends bbApiAbstract
{

	public function changesets($repository, $username = null, $node = null, $limit = 25, $offsetStart = 0)
	{
		$this->checkUsername( $username );
		
		$response = $this->api->get( "/repositories/$username/$repository/changesets/$node/", array(
				'start' => $offsetStart,
				'limit' => $limit
		) );
		
		return $response;	
	}
	
	public function followers($repository, $username = null)
	{
		$this->checkUsername($username);
		
		$response = $this->api->get( "/repositories/$username/$repository/followers/" );
		
		return $response;		
		
	}
	 
	public function events($repository, $limit = 25, $offsetStart = 0, $username = null)
	{
		$this->checkUsername($username);
		
		$response = $this->api->get( "/repositories/$username/$repository/events/", array(
				'start' => $offsetStart,
				'limit' => $limit
		) );
		
		return $response;
	}
	
	public function search($repository, $term, $limit = 25, $offsetStart = 0)
	{

		$response = $this->api->get( "/repositories/", array(
				'name'=>$term,
				'start' => $offsetStart,
				'limit' => $limit
		) );
		
		return $response;
	}
	
	public function source($repository, $location = null, $revision = 'tip', $username = null)
	{
		$this->checkUsername($username);
		
		$response = $this->api->get( "/repositories/$username/$repository/src/$revision/$location" );
		
		return $response;		
	}
	
}