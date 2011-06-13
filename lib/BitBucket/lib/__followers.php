<?php

require_once ( 'bbApiAbstract.php' );

//TODO: Add documentation

class Followers extends bbApiAbstract
{

	public function mine()
	{	
		return $this->user(null);
	}
	
	
	public function user($username = null)
	{
		$this->api->setApi("users", $this);
		
		$this->checkUsername( $username );
		
		$response = $this->api->users->followers( $username );
		
		return $response;
	}
	
	public function repository($repository, $username = null)
	{
		$this->api->setApi("repositories", $this);
		
		$this->checkUsername( $username );
		
		$response = $this->api->repositories->followers( $repository, $username );
		
		return $response;
	}	
	
	
	public function issue($repository, $id, $username = null)
	{
	
		$this->api->setApi("issues", $this);
		
		$this->checkUsername( $username );
		
		$response = $this->api->issues->followers( $repository, $id, $username );
		
		return $response;		
	}
	

}
