<?php
/**
 * Response.php
 * Contains/generates the http response headers and a body (to encode and) to send back to the client.
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
 * @author Mohamed Ibrahim <mo3dev@gmail.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mo3dev@gmail.com>
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 * @link http://restagon.minarah.com Restagon - PHP RESTful API Framework
 * @version 0.0.2
 */


/**
 * The Response class is one of the most important classes in the framework. An instance from this
 * class is created using a Request object and used to send back information to the client if all
 * went well. An instance of this class is also used to instanciate a RestagonException exception
 * object to be thrown containing an error description. Using this class you can set response
 * headers, and a body (an associative array) that will be converted into the response format set
 * using the Request object.
 * 
 * @package Restagon.HTTP
 */
class Response
{
	
	/**
     * An array contains all header information (full header string same as the php's header function).
     * 
     * @var array
     */
	private $_headers = array();
	
	/**
     * Associative array (property map) containing all the body data. It will be converted to the 
	 * requested format using the $_responseFormatInstance object.
     * 
     * @var array
     */
	private $_body = array();
	
	/**
     * iResponseFormat object (implementing iResponseFormat interface), will contain a reference to 
	 * the object that will handle the response type as requested by the user (or default json format)
     * 
     * @var object following the iResponseFormat interface to handle encoding (serializing) $_body
     */
	private $_responseFormatInstance;
	
	/**
     * A reference to the (currently-alive) Request object that is being passed around. We need it
	 * to get the latest response format instance and authorization header before we return the API
	 * dispatch() method.
     * 
     * @var object a reference to the Request object used to create $this
     */
	private $_request;
	
	
	/**
	 * Response class constructor
	 * 
	 * @param object $request The Request object (we need to extract a few things from it)
	 */
    public function __construct(&$request)
	{
		### set the request property (a reference only)
		$this->_request = $request;
	}
	
	
	
	############### GETTERS ###############
	
	/**
     * prepareHeaders() method uses header values the $_headers array property and send the response 
	 * headers as text. This method will execute php's header() function on each element in the array
	 * to send the headers to the client.
	 * 
	 * @return void
     */
	public function prepareHeaders()
	{
		// lastminute, get the Authorization header
		$this->addHeader( $this->_request->getAuthorizationHeader() );
		
		// loop through the headers and send them to client
		foreach ($this->_headers as $header_string) {
			header($header_string, TRUE);
		}
	}
	
	/**
     * getEncodedBody() method encodes (serializes) the $_body associative array property into the 
	 * format requested by the client, and then return the serialized (encoded) string. Encoding uses
	 * the $_responseFormatInstance object's getEncodedFormat($this->_body) method.
     * 
     * @return string A serialized (encoded) string of the data (array) in $_body property.
     */
	public function getEncodedBody()
	{
		### lastminute, set the response format _request property
		$this->setResponseFormatInstance( $this->_request->getResponseFormatInstance() );
		
		### incase a developer does't set a response format instance, return json
		if (is_null( $this->_responseFormatInstance )) {
			
			// set the Content-Type header for json
			header( 'Content-type: application/json' );
			return json_encode( $this->_body );
			
		} else {
			// good developer, run the encoding (serialization), and return the result
			return $this->_responseFormatInstance->getEncodedFormat($this->_body);
		}
		
	}
	
	
	
	############### SETTERS ###############
	
	/**
     * setResponseFormatInstance() method is the setter method for the _responseFormatInstance private
	 * property.
     * 
     * @param object $value The iResponseFormat object to handle formatting (serializing) the response
     * @return void
     */
	private function setResponseFormatInstance($value)
	{
		### set the _responseFormatInstance, and set the Content-Type header as well
		if ( !is_null($value) ) {
			$this->_responseFormatInstance = $value;
			$this->addHeader( "Content-type: {$value->contentType()}" );
		}
	}
	
	/**
     * addHeader() method will take a header string (following php's header() function) and save the 
	 * string in the _headers private array to be used in the prepareHeaders() method later on.
     * 
     * @param string $value The full string of the header (following php's header() function)
     * @return void
     */
	public function addHeader($value)
	{
		// append the value string into the $_headers private property
		$this->_headers[] = $value;
	}
	
	/**
     * setBody() method will set the $_body array property as $final_body_array
     * 
     * @param string $final_body_array The body associative array
     * @return void
     */
	public function setBody($final_body_array)
	{
		$this->_body = $final_body_array;
	}
	
}


