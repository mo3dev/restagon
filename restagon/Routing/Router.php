<?php
/**
 * Router.php
 * Parses REQUEST_URI and finds a match between the url and a urlMap in each Module controller class.
 * 
 * PHP 5
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 * 
 * @package Restagon.Routing
 * @author Mohamed Ibrahim <mo3dev@gmail.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mo3dev@gmail.com>
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 * @link http://restagon.minarah.com Restagon - PHP RESTful API Framework
 * @version 0.0.2
 */


/**
 * The Router class takes care of registering routes (urlMap regexes) and their corresponding
 * Module controller classes (names only) in a $_routes private array property. It will also parse
 * a passed-in url (REQUEST_URI) and uses preg_match to find a match between the parsed url and
 * one of the registered urlMaps in the array property.
 * 
 * @package Restagon.Routing
 */
class Router
{
	
	/**
     * An array containing instances of RouteMap class which are generated in the addModuleControllerClass
	 * method from the added Module Controller classes.
     * 
     * @var array will hold all registered RouteMaps (created from Module Controllers registered in API)
     */
	private $_routes = array();
	
	/**
     * An instance of the Request class for the current request
     * 
     * @var Request
     */
    private $_request;
	
	
	
	/**
	 * Router class constructor
	 * 
	 * @param object $request The Request object (to create the Response object incase of error)
	 */
    public function __construct($request)
	{
		// import the RouteMap class (only used within Router class)
		require_once( RESTAGON_DIRECTORY_PATH . 'Routing/RouteMap.php' );
		
		// set the _request property (used to create a Response class)
		$this->_request = $request;
	}
	
	
	/**
     * addModuleControllerClass() method will take care of registering our Module Controller classes
	 * in the private _routes property.
	 * 
	 * @param string $module_controller_class the Module Controller class name
	 * @param string $path_to_class the path to the Module Controller class's file ('/application/modules/' is default)
     * @return boolean will only return success (true), throws a RestagonException if failure
	 * @throws RestagonException
     */
	public function addModuleControllerClass($module_controller_class, 
	$path_to_class = MODULES_DIRECTORY_PATH)
	{
		### does the class file ($module_controller_class.controller.php) exist in the path specified?
		$fileName = $path_to_class . $module_controller_class . '.controller.php';
		
		// file exists check
		if (!file_exists($fileName)) {
			// file does not exist in specified path
			// create a Response object and throw it in a RestgonException
			$response = new Response($this->_request);
			$response->addHeader(StatusCodes::HTTP_500);
			$errorBody = array("error" => array (
				"errorCode" => "0051",
				"errorMessage" => "The Module Controller class's file: $module_controller_class.controller.php does not exist",
				"errorURL" => ERROR_PAGES_URL . "0051"
			));
			$response->setBody($errorBody);
			throw new RestagonException($response);
		}
		// include the file
		require_once($fileName);
		
		// class exists check
		if (!class_exists($module_controller_class)) {
			// the class does not exist in the file found above
			// create a Response object and throw it in a RestgonException
			$response = new Response($this->_request);
			$response->addHeader(StatusCodes::HTTP_500);
			$errorBody = array("error" => array (
				"errorCode" => "0052",
				"errorMessage" => "The Module Controller class: $module_controller_class does not exist in file $module_controller_class.controller.php",
				"errorURL" => ERROR_PAGES_URL . "0052"
			));
			$response->setBody($errorBody);
			throw new RestagonException($response);
		}
		
		// class implements the iModule interface check
		if (!in_array('iModule', class_implements($module_controller_class))) {
			// module controller class does not implement the iModule interface
			// create a Response object and throw it in a RestgonException
			$response = new Response($this->_request);
			$response->addHeader(StatusCodes::HTTP_500);
			$errorBody = array("error" => array (
				"errorCode" => "0053",
				"errorMessage" => "The Module Controller class: $module_controller_class does not implement iModule",
				"errorURL" => ERROR_PAGES_URL . "0053"
			));
			$response->setBody($errorBody);
			throw new RestagonException($response);
		}
		
		// all is well (class found and is valid), register the controller in _routes array property
		$map = new RouteMap();
		// get the base dir from the url (it will be a part of the url map)
		// TODO: Figure out another way to automatically get the base directory's path (root)
		$components = pathinfo($_SERVER['SCRIPT_NAME']);
		$baseDir = $components['dirname'];

		// remove the leading '/' because it affects the regular expression
		$baseDir = ltrim($baseDir, '/');
		
		// set the urlMap and moduleControllerClass
		$map->urlMap = $baseDir . call_user_func($module_controller_class . '::urlMap');
		$map->moduleControllerClass = $module_controller_class;
		
		// add the RouteMap object to the _routes private array property
		$this->_routes[] = $map;
		
		// return success
		return TRUE;
	}
	
	
	/**
     * getModuleControllerForURI() method will parse the given URI using Regular Expressions
	 * 
	 * @param string $uri the Module Controller class name
     * @return string|NULL The name of the Module controller, or NULL if no controller is matched
     */
	public function getModuleControllerForURI($uri)
	{
		### figure out which registered module controller is targetted by the url
		// remove trailing slash as it throws off the regular expression
		$uri = rtrim( $uri, '/' );
		
		// loop through all registered routes and try to find a match
		foreach ($this->_routes as $r) {			
			if (preg_match($r->getRegularExpressionFromRouteMap(), $uri) === 1) {
				// the current RouteMap regular expression matches the URL (that was passed in), return the class name
				return $r->moduleControllerClass;
			}
		}
		
		// if nothing was found up to this point, return NULL
		return NULL;
	}
	
}


