<?php

class RepoSearch
{
    private static $instance;
	
	private $searchClasses = array();
    
	/**
	 * Get an instance of the RepoSearch
	 * @return RepoSearch
	 */
 	public static function instance() 
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }
	
	/**
	 * Register a new search class
	 * @param string $className A string with the class name of a RepoSearchInterface type.
	 */
	public function register( $className)
	{
		$class = new $className();
		
		if( $class instanceof RepoSearchInterface)
		{
			$class->init();		
			$this->searchClasses[$className] = $class;
		}
		else
		{
			throw new Exception("Trying to register a search that does not have the correct interface");
		}	
	}
	
	/**
	 * Search all registered classes.
	 * @param string $term The search term
	 */
	public function search($term)
	{
		$returnArray = array();

		foreach( $this->searchClasses as $search )
		{
			$returnArray = array_merge($returnArray, $search->search($term));
		}
		
		usort($returnArray, array("RepoSearch", "sortAlpha"));
		
		return $returnArray;
	}
	
	/**
	 * Sort search results alphabetically.
	 * @param Result $a
	 * @param Result $b
	 */
	static function sortAlpha($a, $b)
	{
	    if ($a == $b) {
	        return 0;
	    }
	    return strcasecmp($a->name, $b->name);
	}

}
