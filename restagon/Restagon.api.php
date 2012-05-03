<?php
/**
 * Restagon.api.php
 * 
 * Restagon is an easy to use framework for creating RESTful Web Services. It registeres Module
 * Controller Classes, that are listening to a specific resource url each, and routes requests
 * to the registered controllers based on the URL. You can make a Module Controller listen for
 * any URL you would like it to (it is not limited to the controller name). Module Controller
 * classes must implement the iModule interface.
 * 
 * The framework also handles response formats (encoding/serialization). You can register response
 * format classes (that implement the iResponseFormat interface) to the framework and they will be
 * used automatically by the framework based on your specifying what extension (ie 'json' or 'xml')
 * you want the data to be sent to the client. Take a look at the Sample.controller.php file in the
 * 'application/modules/' directory. JSON format is supplied by the framework as a default (failsafe)
 * response format.
 * 
 * The framework also handle Authentication. You can set an Authentication class (that implements
 * the iAuthenticate interface) and use it (via the Request object that is passed around throughout
 * the application) to check whether the Request is authenticated/authorized or not. You decide the
 * functionality (how you want authentication done) in the class.
 * 
 * If you dont set a response format, the framework will try to find the best supported format using
 * the clients HTTP ACCEPT header. It'll parse it according to the RFC 2616 standards, and check
 * each mime type found against our registered response format classes for a match, if it still
 * didn't find a match, it'll return json as default.
 * 
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
 * @package Restagon
 * @author Mohamed Ibrahim <mo3dev@gmail.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mo3dev@gmail.com>
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 * @link http://restagon.minarah.com Restagon - PHP RESTful API Framework
 * @version 0.0.2
 */


/**
 * This is the dispatching class (single point of entry into API). It kick starts everything in the
 * framework. It starts Routing, Authentication, and Module Controller for URL. It receives all the
 * data the user requested and sends it back and exits.
 * 
 * @package Restagon
 */
class Restagon
{
	
	/**
	 * An instance of Router class that will take care of registering our Module Controller classes
	 * with the framework (along with their url routing maps) and finding the one that matches the
	 * current REQUEST_URI.
	 * 
	 * @var Router controls Routing the Request to the right Controller class
	 */
	private $_router;
	
	
	/**
	 * An instance of Request class containing headers, supported response formats, and url to send
	 * to the Modules for processing.
	 * 
	 * @var Response object containing all headers and message body to send to client.
	 */
	private $_request;
	
	
	/**
	 * An instance of Response class containing headers and body to send back to the client.
	 * 
	 * @var Response object containing all headers and message body to send to client.
	 */
	private $_response;
	
	
	/**
	 * Restagon class constructor. It will load include some required class files. It will also
	 * create an instance of the Router class to be used by the addModuleController() method and
	 * the findController() method to match the REQUEST_URI to a Module Controller class.
	 */
	public function __construct()
	{
		### load the interfaces and helper classes
		require_once( RESTAGON_DIRECTORY_PATH . 'HTTP/ResponseFormat/iResponseFormat.interface.php' );
		require_once( RESTAGON_DIRECTORY_PATH . 'Module/iModule.interface.php' );
		require_once( RESTAGON_DIRECTORY_PATH . 'Authentication/iAuthenticate.interface.php' );
		
		require_once( RESTAGON_DIRECTORY_PATH . 'Routing/Router.php' );
		require_once( RESTAGON_DIRECTORY_PATH . 'HTTP/Request/Request.php' );
		require_once( RESTAGON_DIRECTORY_PATH . 'HTTP/Response/Response.php' );
		require_once( RESTAGON_DIRECTORY_PATH . 'HTTP/StatusCodes/StatusCodes.php' );
		require_once( RESTAGON_DIRECTORY_PATH . 'Exceptions/RestagonException.php' );
		
		try {
			
			### Instantiate the Request object
			$this->_request = new Request();
			
			// get the headers into the request object
			$this->_request->headers = getallheaders();
			
			// get the body into the request object
			$this->_request->body = file_get_contents( 'php://input', 'r' );
			
			### Instantiate the Router object
			$this->_router = new Router($this->_request);
			
		} catch (RestagonException $re) {
			// a Response object (containing an error) was created, call answerThenExit() method
			$this->_response = $re->getResponse();
			$this->answerThenExit();
		}
	}
	
	
	/**
	 * addResponseFormat() method will take care of registering our custom (and default-framework-
	 * provided ResponseFormat classes - implementing the iFormatResponse interface). The method will
	 * add each passed-in class combo to the Request class's $formats array. The object will be passed
	 * throughout the execution path until a Response object is created from it.
	 * 
	 * @param string $format_class the custom Response Format class name
	 * @param string $format_content_type the HTTP Content-Type value associated with this format
	 * @param string $format_extension the file extension associated with this format (ie. '.xml')
	 * @param string $path_to_class the path to the format class's file (defaults to 'application/includes')
	 * @return boolean whether the format class got added to the Response class
	 */
	public function addResponseFormat($format_class, $format_content_type, $format_extension, 
	$path_to_class = INCLUDES_DIRECTORY_PATH)
	{
		### add the format class's information to the $_request private property object.
		try {
			// $result will either return TRUE, or throw a RestagonException
			$result = $this->_request->addResponseFormat( 	$format_class, $format_content_type, 
														$format_extension, $path_to_class   );
			return TRUE;
			
		} catch (RestagonException $re) {
			// a Response object was created, call answerThenExit() method
			$this->_response = $re->getResponse();
			$this->answerThenExit();
			return FALSE; // execution won't get here because the application is terminated in method above
		}
	}
	
	
	/**
	 * addModuleController() method Manages the Router class enabling it to register available Module
	 * Controllers, and find the one listening for the current URL.
	 * 
	 * @param string $module_controller_class the Module Controller's Class name
	 * @param string $path_to_class the directory containing the module controller class file
	 * @return boolean whether the module controller class got added to the Router object
	 */
	public function addModuleController($module_controller_class, $path_to_class = MODULES_DIRECTORY_PATH)
	{
		### add the controller to the router object
		try {
			// $result will either return TRUE, or throw a RestagonException
			$result = $this->_router->addModuleControllerClass($module_controller_class, $path_to_class);
			return TRUE;
			
		} catch (RestagonException $re) {
			// a Response object was created, call answerThenExit() method
			$this->_response = $re->getResponse();
			$this->answerThenExit();
			return FALSE; // execution won't get here because the application is terminated in method above
		}
	}
	
	
	/**
	 * setDefaultAuthenticationClass() method sets the Authentication class in the Request object
	 * for the API as a whole (initially). Authentication class can later be changed (reset) anywhere 
	 * throughout the application from within the Request object passed around. The class needs to
	 * implement the iAuthenticate interface.
	 * 
	 * @param string $authentication_class the name of the Authentication class
	 * @param string $path_to_class the path to the class, defaults to the 'application/includes' dir
	 * @return void
	 */
	public function setDefaultAuthenticationClass($authentication_class, $path_to_class = INCLUDES_DIRECTORY_PATH)
	{
        ### set the Authentication class instance in the Request object
		try {
			// $result will either return TRUE, or throw a RestagonException
			$result = $this->_request->setAuthenticationInstance($authentication_class, $path_to_class);
			return TRUE;
			
		} catch (RestagonException $re) {
			// a Response object was created, call answerThenExit() method
			$this->_response = $re->getResponse();
			$this->answerThenExit();
			return FALSE; // execution won't get here because the application is terminated in method above
		}
	}
	
	
	/**
	 * dispatch() method will kick start the Routing mechanism (finding the available Modules, and 
	 * matching the current URL to one of the Module Controllers found. It will then invoke the
	 * matched Module Controller which will return a Response object.
	 * 
	 * @return void
	 */
	public function dispatch()
	{
		### use the result of findController() to invoke the (found) controller and get a response
		try {
			
			### Find (match) a Module Controller for the current URL
			$controllerClass = $this->findController( $_SERVER['REQUEST_URI'] );
			
			// was a controller found? check for NULL
			if (is_null($controllerClass)) {
				// controller not found, send appropriate error
				// create a Response object and throw it in a RestagonException
				$response = new Response($this->_request);
				
				$response->addHeader(StatusCodes::HTTP_404); ////////////////////////////////////
				$errorBody = array("error" => array (
					"errorCode" => "1001",
					"errorMessage" => "The requested resource was not found",
					"errorURL" => ERROR_PAGES_URL . "1001"
				));
				$response->setBody($errorBody);
				throw new RestagonException($response);
					
			} else {
				// url is matched with a controller, check the request method
				// check if the method exists, if not, throw an exception with appropriate error
				if (method_exists($controllerClass, $_SERVER['REQUEST_METHOD'])) {
					// module (and http method) found, turn the control over to the matched module
					$controller = new $controllerClass($this->_request);
					$this->_response = $controller->{$_SERVER['REQUEST_METHOD']}();
				} else {
					// HTTP Method is not supported
					// create a Response object and throw it in a RestagonException
					$response = new Response($this->_request);
					
					$response->addHeader(StatusCodes::HTTP_405); ////////////////////////////////////
					$errorBody = array("error" => array (
						"errorCode" => "1002",
						"errorMessage" => "The requested HTTP method is not supported",
						"errorURL" => ERROR_PAGES_URL . "1002"
					));
					$response->setBody($errorBody);
					throw new RestagonException($response);
				}
			}
			
			
		} catch (RestagonException $re) {
			
			### Catch RestagonExceptions (contains a Response object going into _response prop)
			$this->_response = $re->getResponse();
			
		} catch (Exception $e) {
			
			### Catch all exceptions, generate a Response and assign it to _response property
			$response = new Response($this->_request);
			
			// this is an unknown Exception, set the headers, and body approprietly.
			$response->addHeader(StatusCodes::HTTP_500);
			$errorBody = array("error" => array (
				"errorCode" => "0000",
				"errorMessage" => $e->getMessage(),
				"errorURL" => ERROR_PAGES_URL . "0000"
			));
			$response->setBody($errorBody);
			
			// set the _response private property to the Response object just created
			$this->_response = $response;
			
		}
		
	}
	
	
	/**
	 * findController() method searches for a module controller class matching the $request_uri 
	 * parameter.
	 * 
	 * @param string $request_uri the URL to be matched
	 * @return string|NULL Module Controller class name matching the path in $request_uri parameter
	 */
	private function findController($request_uri)
	{
		### match and return matched controller class name (based on $request_uri)
		return $this->_router->getModuleControllerForURI($request_uri);
	}
	
	
	/**
	 * answerThenExit() method will use the $_response private property to return the headers 
	 * and data over to the requesting client.
	 * 
	 * @return void
	 */
	public function answerThenExit()
	{
		ob_start();
		######################################################################
		// firstly, get the response data
		$response_data = $this->_response->getEncodedBody();
		
		// send the headers
		$this->_response->prepareHeaders(); // headers are in the output buffer
		
		// die() will close the connection to client after all headers and data is sent
		die( $response_data );
		######################################################################
		ob_end_flush();
	}
	
}



