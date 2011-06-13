<?php


/** 
 * Ecapsulates the accessors and methods of the Invitations class
 * @author Anthony Steiner <asteiner@steinerd.com>
 *
 */
class Invitations extends bbApiAbstract
{

	public function send($email_address, $repository, $permission = Permission::read, $username = null )
	{
		$this->checkUsername($username);
		
		$this->checkPermission($permission);

		$response = $this->api->post( "/invitations/$username/$repository/$email_address", array('permission' => $permission) );
		
		return $response;
	}	

}
