<?php

/**
 * An interface to search repositories.
 */
interface RepoSearchInterface
{
	/**
	*  Search the repository.
	 * @param string $term The term to search for
	 * @return Array An array of Results.
	*/
	function search($term);
	
	/**
	 * Initialise the repo search. 
	 */
	function init();
}
