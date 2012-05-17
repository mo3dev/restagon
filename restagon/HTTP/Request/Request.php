<?php
/**
 * Request.php
 * Contains request information such as headers, body, response format, authentication. Passed around!
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
 * @package Restagon.HTTP
 * @author Mohamed Ibrahim <mohamed@minarah.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mohamed@minarah.com>
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 * @link http://restagon.minarah.com Restagon - PHP RESTful API Framework
 * @version 0.0.2
 */


/**
 * The Request class is one of the most important classes in the framework. An instance from this
 * class is created very early on and assigned request information such as headers, body, response
 * formats, response format object, and authentication object. This class is the solution to the
 * avoidance of static classes. That is why this object must be passed around because it is used
 * to instanciate a Response object (to be returned or thrown into a RestagonException exception).
 * 
 * @package Restagon.HTTP
 */
class Request
{
	
	/**
	 * This array contains the response format class combinations (class name, content-type, extension)
	 * 
	 * @var array response formats (valid)
	 */
	private $_responseFormats = array();
	
	
	/**
	 * This is an instance of the authentication class the user wants to handle Authentication
	 * 
	 * @var object an authentication class instance
	 */
	private $_authenticationInstance = NULL;
	
	
	/**
	 * This is an instance of the response format class used for the response body sent back to client
	 * 
	 * @var object instance of a response format class set by developer
	 */
	private $_responseFormatInstance = NULL;
	
	
	/**
	 * Request class constructor.
	 */
	public function __construct()
	{
		### add the ResponseFormatJSON as a default response format class (that come with the framework)
		### please don't remove this format class as it is needed incase no format class is set or
		### incase of a error before the Restagon->dispatch() method. JSON is the bare-minimum format (fail-safe)
		### json support is a must, let the client and framework decide the format, the following code
		### will throw a RestagonException if somethine went wrong with json support.
		$this->addResponseFormat( 'ResponseFormatJSON', 'application/json', 'json');
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
	 * @return boolean will only return success (true), throws a RestagonException if failure
	 * @throws RestagonException
	 */
	public function addResponseFormat($format_class, $format_content_type, $format_extension, 
	$path_to_class = INCLUDES_DIRECTORY_PATH)
	{
		### does the class file ($format_class.php) exist in the path specified?
		$fileName = $path_to_class . $format_class . '.php';
		
		// file exists check
		if (!file_exists($fileName)) {
			// file does not exist in specified path
			// is it a framework provided class?
			if (file_exists( RESTAGON_DIRECTORY_PATH . 'HTTP/ResponseFormat/' . $format_class . '.php' )) {
				$fileName = RESTAGON_DIRECTORY_PATH . 'HTTP/ResponseFormat/' . $format_class . '.php';
			} else {
				// file not found
				// create a Response object and throw it in a RestgonException
				$response = new Response($this);
				$response->addHeader(StatusCodes::HTTP_500);
				$errorBody = array("error" => array (
					"errorCode" => "0001",
					"errorMessage" => "The response format class's file: $format_class.php does not exist",
					"errorURL" => ERROR_PAGES_URL . "0001"
				));
				$response->setBody($errorBody);
				throw new RestagonException($response);
			}
		}
		// include the file
		require_once($fileName);
		
		// class exists check
		if (!class_exists($format_class)) {
			// the class does not exist in the file found above
			// create a Response object and throw it in a RestgonException
			$response = new Response($this);
			$response->addHeader(StatusCodes::HTTP_500);
			$errorBody = array("error" => array (
				"errorCode" => "0002",
				"errorMessage" => "The response format class: $format_class does not exist in file $format_class.php",
				"errorURL" => ERROR_PAGES_URL . "0002"
			));
			$response->setBody($errorBody);
			throw new RestagonException($response);
		}
		
		// class implements the iResponseFormat interface check
		if (!in_array('iResponseFormat', class_implements($format_class))) {
			// format class does not implement the iResponseFormat interface
			// create a Response object and throw it in a RestgonException
			$response = new Response($this);
			$response->addHeader(StatusCodes::HTTP_500);
			$errorBody = array("error" => array (
				"errorCode" => "0003",
				"errorMessage" => "The response format class: $format_class does not implement iResponseFormat",
				"errorURL" => ERROR_PAGES_URL . "0003"
			));
			$response->setBody($errorBody);
			throw new RestagonException($response);
		}
		
		// all is well (class found and is valid), add the format to the response_formats array property
		$this->_responseFormats[] = array(
			'format_class' => $format_class,
			'format_content_type' => $format_content_type,
			'format_extension' => $format_extension
		);
		
		// return success
		return TRUE;
	}
	
	
	/**
	 * setAuthenticationInstance() method will set the Authentication instance that the user wants to handle
	 * Authentication. Once an instance is set (it can be used right away in the method 
	 * $this->_authenticationInstance->isAuthenticated().
	 * 
	 * @param string $authentication_class the custom Response Format class name
	 * @param string $path_to_class the path to the authentication class's file (defaults to 'application/includes')
	 * @return boolean will only return success (true), throws a RestagonException if failure
	 * @throws RestagonException
	 */
	public function setAuthenticationInstance($authentication_class, $path_to_class = INCLUDES_DIRECTORY_PATH)
	{
		### does the class file ($authentication_class.php) exist in the path specified?
		$fileName = $path_to_class . $authentication_class . '.php';
		
		// file exists check
		if (!file_exists($fileName)) {
			// file does not exist in specified path
			// create a Response object and throw it in a RestgonException
			$response = new Response($this);
			$response->addHeader(StatusCodes::HTTP_500);
			$errorBody = array("error" => array (
				"errorCode" => "0101",
				"errorMessage" => "The authentication class's file: $authentication_class.php does not exist",
				"errorURL" => ERROR_PAGES_URL . "0101"
			));
			$response->setBody($errorBody);
			throw new RestagonException($response);
		}
		// include the file
		require_once($fileName);
		
		// class exists check
		if (!class_exists($authentication_class)) {
			// the class does not exist in the file found above
			// create a Response object and throw it in a RestgonException
			$response = new Response($this);
			$response->addHeader(StatusCodes::HTTP_500);
			$errorBody = array("error" => array (
				"errorCode" => "0102",
				"errorMessage" => "The authentication class: $authentication_class does not exist in file $authentication_class.php",
				"errorURL" => ERROR_PAGES_URL . "0102"
			));
			$response->setBody($errorBody);
			throw new RestagonException($response);
		}
		
		// class implements the iAuthenticate interface check
		if (!in_array('iAuthenticate', class_implements($authentication_class))) {
			// authentication class does not implement the iAuthenticate interface
			// create a Response object and throw it in a RestgonException
			$response = new Response($this);
			$response->addHeader(StatusCodes::HTTP_500);
			$errorBody = array("error" => array (
				"errorCode" => "0103",
				"errorMessage" => "The authentication class: $authentication_class does not implement iAuthenticate",
				"errorURL" => ERROR_PAGES_URL . "0103"
			));
			$response->setBody($errorBody);
			throw new RestagonException($response);
		}
		
		// all is well (class found and is valid) set the _authenticationInstance property
		$this->_authenticationInstance = new $authentication_class();
		
		// return success
		return TRUE;
	}
	
	
	/**
	 * getResponseFormatInstance() will return the instance in _responseFormatInstance property if
	 * it is set, if not, it'll parse the HTTP Accept header and find the best supported format, if
	 * not format class was found, then it'll send an object of 'ResponseFormatJSON' as a default (failsafe)
	 * response format (it is provided by the framework)
	 * 
	 * @return object instance of response format class, if not found, 'ResponseFormatJSON' is failsafe class
	 */
	public function getResponseFormatInstance()
	{
		### check the _responseFormatInstance property
		if (is_null($this->_responseFormatInstance)) {
			// the format class instance is not set, find it
			$requestedMimeTypes = $this->parseHTTPAcceptHeader();
			
			// loop through them, if a supported mime is found, return it
			foreach ($requestedMimeTypes as $requestedFormat) {
				foreach ($this->_responseFormats as $supportedFormat) {
					if ($requestedFormat['data_format'] === $supportedFormat['format_content_type']) {
						// match found, create instance, and set the property
						$this->_responseFormatInstance =  new $supportedFormat['format_class']();
						break 2; // dont need to loop any further
					} // end if match found
				} // end inner loop (supported)
			} // end outer loop (requested)
			
			### if the format class was not set (and json class exists as it MUST), set it as json
			if ( is_null($this->_responseFormatInstance) && class_exists('ResponseFormatJSON') ) {
				// set the property as an instance of ResponseFormatJSON (a default response format/ failsafe)
				$this->_responseFormatInstance = new ResponseFormatJSON(); // included in addResponseFormat()
			}
			# if the instance is null and the json class D.N.E, normal json_encode will be used on 
			# the response (which is definitely an error) because the json class d.n.e - automatically added by framework
			
		} // end if instance is set
		
		// the format class instance is not null (set in _responseFormatInstance property) return it
		return $this->_responseFormatInstance;
	}
	
	
	/**
	 * isResponseFormatExtensionSupported() will return TRUE if the extension is supported by a 
	 * *registered* response format class (will set the instance autmatically as well), and FALSE 
	 * if it is not supported.
	 * 
	 * @param string $extension a response format extension
	 * @return boolean whether the $extension parameter is found in the registered format classes
	 */
	public function isResponseFormatExtensionSupported($extension)
	{
		### loop through the supported formats array and check for a match
		$result = FALSE;
		foreach ($this->_responseFormats as $supportedFormat) {
			if ($extension === $supportedFormat['format_extension']) {
				// set the _responseFormatInstance automatically
				$this->_responseFormatInstance =  new $supportedFormat['format_class']();
				$result = TRUE;
				break; // dont need to loop any further
			}
		}
		return $result;
	}
	
	
	/**
	 * isAuthenticated() method forwards the invocation to the _authenticationInstance->isAuthenticated()
	 * method. So that other classes can get authentication information through the Request object, 
	 * and not having them get direct access to the Authentication class.
	 * 
	 * @return boolean Whether the request is Authenticated or not.
	 */
	public function isAuthenticated()
	{
		return $this->_authenticationInstance->isAuthenticated();
	}
	
	
	/**
	 * getAuthorizationHeader() forwards the invocation to the 
	 * _authenticationInstance->getAuthorizationHeader() method.
	 * 
	 * @return string HTTP authorization header string to be processed later using php's header function
	 */
	public function getAuthorizationHeader()
	{
		if ( is_null($this->_authenticationInstance) ) {
			return '';
		}
		return $this->_authenticationInstance->getAuthorizationHeader();
	}
	
	
	############## PARSING RESPONSE FORMATS #################
	
	
	/**
	 * parseHTTPAcceptHeader() method will parse a given (or HTTP Accept header if not given) into an
	 * array sorted by the quality score of each format in the Accept header as per RFC 2616 spec.
	 * based on http://jrgns.net/content/parse_http_accept_header
	 * 
	 * @param string $header HTTP Accept header string
	 * @return array response formats sorted by their quality score
	 */
	public function parseHTTPAcceptHeader($header = false)
	{
		// initial value is NULL. If it is returned, we will use a default format
		$mimeTypes = NULL;
		
		// get the header from $_SERVER global
		$header = $header ? $header : (array_key_exists('HTTP_ACCEPT', $_SERVER) ? $_SERVER['HTTP_ACCEPT']: false);
		
		// normally it is set, but just an extra check if the Accept HTTP header is actually set
		if (!is_null($header)) {
			// get the data formats (including quality scores)
			$mimes = explode(',', $header);
			$mimes = array_map('trim', $mimes);
			
			// go through the mimes populating the $mimeTypes[] array
			foreach ($mimes as $mime) {
				// separate the data format from the quality score
				$mime = explode(';', $mime);
				$data_format = array_shift($mime);
				if ($data_format) {
					// get the quality score (double value)
					$quality_score = $this->getQualityScoreForMimeArray($mime);
					$data_format = trim($data_format);
					$mimeTypes[] = array('data_format' => $data_format, 'quality_score' => $quality_score);
				}
			}
			usort($mimeTypes, array ( $this, 'sortMimeTypesByQualityScore' ));
		}
		return $mimeTypes;
	}
	

	/**
	 * getQualityScoreForMimeArray() method will return the quality score from a mime type
	 * ie. 'application/json;q=0.9' the method will retrun 0.9
	 * 
	 * @param string $mime an HTTP mime type following the RFC 2616 specification
	 * @return float quality score for given mime type
	 */
	private function getQualityScoreForMimeArray($mime)
	{
		$quality_score = 1;
		if (is_string($mime)) {
			$mime = explode(';', $mime);
		}
		$mime = array_map('trim', $mime);
		foreach ($mime as $score) {
			$score = explode('=', $score);
			$score = array_map('trim', $score);
			if ($score[0] == 'q') {
				$quality_score = $score[1];
			}
		}
		return (float)$quality_score;
	}
	
	
	/**
	 * sortMimeTypesByQualityScore() method is the sort method for the mime types parsed in 
	 * parseHTTPAcceptHeader().
	 * 
	 * @param array $mimeA an associative array of HTTP mime type and its corresponding quality score
	 * @param array $mimeB an associative array of HTTP mime type and its corresponding quality score
	 * @return integer 1 (if qs of A < than B), 0 (if they their qs is equal), or -1 (if qs of B < A). qs=quality_score
	 */
	private function sortMimeTypesByQualityScore($mimeA, $mimeB)
	{
		if ($mimeA['quality_score'] == $mimeB['quality_score']) return 0;
		return ($mimeA['quality_score'] < $mimeB['quality_score']) ? 1 : -1;
	}
	
}

