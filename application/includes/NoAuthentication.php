<?php
/**
 * NoAuthentication.php
 * 
 * 
 * PHP 5
 * 
 * @package Restagon
 * @author Mohamed Ibrahim <mo3dev@gmail.com>
 * @version 0.0.2
 * @copyright 2012, Mohamed Ibrahim
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 */


class NoAuthentication implements iAuthenticate
{
	
	/**
	 * isAuthenticated() method invokes other methods (up to developer) to perform the type of
	 * Authentication that is needed in the custom Authentication class implementing this interface.
	 * 
	 * @return boolean Whether the request is Authenticated or not.
	 */
	public function isAuthenticated()
	{
		return TRUE; // NoAuthentication will always return TRUE for access granted
	}
	
	/**
	 * getAuthorizationHeader() method returns the HTTP Authorization header expected for the
	 * implementing authentication class.
	 * 
	 * @return string Authorization header for this auth type
	 */
	public function getAuthorizationHeader()
	{
		// no authorization is sent if a WWW-Authenticate is sent, browsers will interpret it as 401 response
		return '';
	}
	
}



