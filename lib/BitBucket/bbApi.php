<?php

class bbApi
{

	/*----- Api Properties ---- */
	
	public $changesets;

	public $emails;

	public $events;

	public $followers;

	public $groups;

	public $invitations;

	public $issues;

	public $privileges;

	public $repositories;

	public $services;

	public $source;

	public $ssh_keys;

	public $users;

	public $wiki;
	
	/*----- /END Api Properties ---- */	
	
	
	protected $request = null;
	
	protected $apis = array();
	
	protected $debug;
	
	public function __construct($debug = false)
	{
		$this->debug = $debug;
		
		$this->assign_apis();
		
	}

	public function assign_apis()
	{
		$refclass = new ReflectionClass( $this );
		foreach( $refclass->getProperties(ReflectionProperty::IS_PUBLIC) as $property )
		{
			$name = $property->name;
			if ( $property->class == $refclass->name )
			{
				$this->{$property->name} = $this->getApi($property->name);
			}
		}
	}
	
	public function get_classProperties( $class )
	{
		$class_properties = (object)array();
		
		$refclass = new ReflectionClass( $class );
		foreach( $refclass->getProperties( ReflectionProperty::IS_PUBLIC ) as $property )
		{
			$name = $property->name;
			if ( ($property->class == $refclass->name) )
			{				
				$class_properties->{$property->name} = $class->{$property->name};
			}
		}	

		return $class_properties;
	}
	
	
	public function authenticate($username, $password)
	{
		$this->getRequest()->setOption( 'username', $username )->setOption( 'password', $password );
		
		return $this;
	}
	
	public function deAuthenticate()
	{
		return $this->authenticate( null, null );
	}
	
	public function get($route, array $parameters = array(), array $requestOptions = array())
	{
		return $this->getRequest()->get( $route, $parameters, $requestOptions );
	}
	
	public function post($route, array $parameters = array(), array $requestOptions = array())
	{
		return $this->getRequest()->post( $route, $parameters, $requestOptions );
	}
	
	public function put($route, array $parameters = array(), array $requestOptions = array())
	{
		return $this->getRequest()->put( $route, $parameters, $requestOptions );
	}
	
	public function delete($route, array $parameters = array(), array $requestOptions = array())
	{
		return $this->getRequest()->delete( $route, $parameters, $requestOptions );
	}
	
	public function getAuthenticatedUser()
	{
		return $this->getRequest()->getAuthenticatedUser();
	}
	
	public function setOption($name, $value)
	{
		$this->getRequest()->setOption($name, $value);
	}
	
	public function getOption($name, $default = null)
	{
		return $this->getRequest()->getOption($name, $default);
	}
		
	
	public function getRequest()
	{
		if ( ! isset( $this->request ) )
		{
			require_once (dirname( __FILE__ ) . '/lib/bbApiRequest.php');
			
			$this->request = new bbApiRequest( array('debug' => $this->debug));
		}
		
		return $this->request;
	}
	
	public function setRequest(bbApiRequest $request)
	{
		$this->request = $request;
		
		return $this;
	}
	
	public function getApi($name)
	{
       
        if ( ! isset( $this->apis[$name] ) )
        {
        	$class_name = implode("", array_map("ucfirst", explode("_", $name)));
        	$api_file = sprintf("/lib/__$name.php"); 

        	if ( ! file_exists(dirname( __FILE__ ) . $api_file)) { return null; }
        	      	
            require_once (dirname( __FILE__ ) . $api_file );
            
            if (!class_exists($class_name)) { return null; }
            
            $this->apis[$name] = new $class_name( $this );
        }
        
		return $this->apis[$name];
	}
	
	public function setApi($name, bbApiAbstract $instance)
	{
		$this->apis[$name] = $instance;
		
		return $this;
	}

}