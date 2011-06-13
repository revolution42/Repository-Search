<?php

require_once ('bbApiAbstract.php');


/**
 * Encapsulates the accessors and methods of the Issues class
 * @author Anthony Steiner <asteiner@steinerd.com> 
 */
class Issues extends bbApiAbstract
{
	

	/**
	 * Searches repositories for items that match the search criterea 
	 * @param	string		$search 		search criterea
	 * @param	string		$repository		repository to search
	 * @param	string		$username		username of said repository
	 * @param	int			$limit			limit of records to display
	 * @param	int			$offsetStart	offset of records to start the object
	 * @return	object						JSON object containing the results of the bbApiRequest
	 */
	public function search($search, $repository, $username = null, $limit = 25, $offsetStart = 0)
	{		
		$options = array();
		
		$this->checkUsername( $username );
		
		$options = array(
				'search' => strtolower( urlencode( $search ) ),
				'start' => $offsetStart,
				'limit' => $limit
		);
		
		$response = $this->api->get( "/repositories/$username/$repository/issues/", $options );
		
		return $response;
	}
	
	
	/**
	 * Searches your own repository (uses configuration settings to assume username)
	 * @param	string			$repository		repository to search	
	 * @param	array|string	$filter
	 * @param	int				$limit
	 * @param	int				$offsetStart
	 */
	public function mine($repository, $filter = null, $limit = 25, $offsetStart = 0)
	{
		$responsible = array(
				'responsible' => $this->api->getAuthenticatedUser()
		);
		
		if ( is_array( $filter ) )
		{		
			$filter = array_merge( $responsible, array_map ('urlencode', $filter ) );
		}
		elseif ( is_string( $filter ) )
		{
			parse_str( $filter, $filter_array );
			$filter = array_merge( $filter_array, $responsible );
		}
		else
		{
			$filter = $responsible;
		}
		
		return $this->show( $repository, null, $filter, 0, $limit, $offsetStart );
	}
	
	
	
	/**
	 * Enter description here ...
	 * @param unknown_type $repository
	 * @param unknown_type $username
	 * @param unknown_type $filter
	 * @param unknown_type $id
	 * @param unknown_type $limit
	 * @param unknown_type $offsetStart
	 * @return Ambiguous
	 * @TODO correct documentation
	 */
	public function show($repository, $username = null, $filter = null, $id = 0, $limit = 25, $offsetStart = 0)
	{
		$options = array();
		
		$this->checkUsername( $username );
		
		if ( ! is_numeric( $id ) || $id == 0 )
		{
			$options = array(
					'start' => $offsetStart,
					'limit' => $limit
			);
		}
		
		if ( is_array( $filter ) )
		{
			$options = array_merge( $options, array_map ('urlencode', $filter ) );
		}
		elseif ( is_string( $filter ) )
		{
			parse_str( $filter, $filter_array );
			$options = array_merge( $filter_array, $options );
		}
		
		$response = $this->api->get( "/repositories/$username/$repository/issues/$id/", $options );
		
		return $response;
	}
	
	
	/**
	 * Enter description here ...
	 * @param unknown_type $repository
	 * @param unknown_type $id
	 * @param unknown_type $username
	 * @TODO correct documentation 
	 */
	public function followers($repository, $id = 0, $username = null)
	{
		$this->checkUsername( $username );
		
		$response = $this->api->get( "/repositories/$username/$repository/issues/$id/followers/" );
		
		return $response->followers;
	}
	

	/**
	 * Enter description here ...
	 * @param unknown_type $count
	 * @param unknown_type $username
	 * @param unknown_type $limit
	 * @param unknown_type $offsetStart
	 * @TODO correct documentation 
	 */
	public function events(&$count = 0, $username = null, $limit = 25, $offsetStart = 0)
	{
		$this->checkUsername( $username );
		
		$response = $this->api->get( "/users/$username/events/", array(
				'start' => $offsetStart,
				'limit' => $limit
		) );
		
		$count = ( int ) $response->count;
		
		return $response->events;
	}
	
 

}