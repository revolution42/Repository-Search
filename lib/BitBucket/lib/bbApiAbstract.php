<?php

/**
 * Abstract class for bbApi classes
 *
 * @author Anthony Steiner <asteiner@steinerd.com>
 * @abstract
 */
abstract class bbApiAbstract
{
    /**
     * The core API
     * @var bbApi
     */
    protected $api;
       
    /**
     * BitBucket API Abstract constructor
     * @param	bbApi	$api		Api object to load
     */
    public function __construct (bbApi $api)
    {
        $this->api = $api;
    }
        
    /**
     * Descendant-usable username check.
     * If the username parameter is null it will return the authenticated user to the referenced parameter, 
     * otherwise it uses the existing user
     * @param	string 	&$username	BitBucket user name
     */
    public function checkUsername(&$username = null)
    {
    	$username = $this->api->getAuthenticatedUser();
    }
    	
	/**
	 * Checks the permission string for valid input
	 * @param	string	$permission	The permission string from the invoking method
	 * @final
	 */
	public final function checkPermission( $permission )
	{	
		$refclass = new ReflectionClass( 'Permission' );
		$valid_permissions = $refclass->getConstants();

		
		if (!in_array($permission, $valid_permissions))
		{
			echo sprintf('Permission is not valid (%s)', implode(", ", $valid_permissions));
			exit();			
		}
	}
}

/**
 * Use of this is optional, I'm using it as an ad-hoc enum (since PHP doesn't natively support Enumerations) 
 * and I would like certain constants available from both Intellisense-enabled IDEs as well as being able to 
 * edit their values from one place. 
 * 
 * Any where you see this class being used, the equivilent string may be used. Like I said; it's fully optional. 
 *
 */

class Permission
{
	const none 	= 'none';
	
	const read 	= 'read';
	
	const write = 'write';
	
	const admin = 'admin';
} 

