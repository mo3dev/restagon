<?php
/**
 * SampleController.php
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
 * @author Mohamed Ibrahim <mohamed@minarah.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mohamed@minarah.com>
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 * @link http://restagon.minarah.com Restagon - PHP RESTful API Framework
 * @version 0.0.2
 */



class SampleController implements iModule
{
	
	/**
	 * An instance of the Request class for the current request
	 * 
	 * @var Request
	 */
	private $_request;
	
	
	/**
	 * Class Constructor, will set the resquest property
	 * 
	 * @param Request The current request
	 */
	public function __construct($request)
	{
		$this->_request = $request;
	}
	
	
	/**
	 * urlMap() method returns the UNIQUE Module's Regular Expression URL string
	 * 
	 * @return string URL path (may contain a regex) ie. '/whatever/count/(\d+)/hello'
	 */
	public static function urlMap()
	{
		return '/sample/a/(\d+)';
	}
	
	
	########### SUPPORTED HTTP REQUEST METHODS ############
	
	
	/**
	 * HTTP GET method 
	 * 
	 * @return Response a Response object containing all data (and headers?) to send back
	 */
	public function get()
	{
		### GET something
		// I don't want to check for Authentication as this request method is open for all public
		
		// return a success message (OK response)
		$response = new Response($this->_request);
		$response->addHeader(StatusCodes::HTTP_200);
		$body = array("success" => array (
			"message" => "Hello World!! from GET",
		));
		$response->setBody($body);
		
		// prioritize return response formats (from low priority to high)
		// the method will set the format to the extension provided if it is supported
		$this->_request->isResponseFormatExtensionSupported('json'); // default, minimum
		$this->_request->isResponseFormatExtensionSupported('rss'); // rss is not available, json is returned
		
		// return the best format selected above
		return $response;
	}
	
	
	/**
	 * HTTP POST method
	 * 
	 * @return Response a Response object containing all data (and headers?) to send back
	 */
	public function post()
	{
		### POST something
		// check for authentication (boolean value is expected)
		$authResult = $this->_request->isAuthenticated();
		
		// check Authentication
		if ($authResult) {
			// authenticated (success)
			### perform POST'ed action
			
			// return a success message (OK response)
			$response = new Response($this->_request);
			$response->addHeader(StatusCodes::HTTP_200);
			$body = array("success" => array (
				"message" => "Your data was POST'ed",
			));
			$response->setBody($body);
			
			// return without setting a ResponseFormat, it will json as default
			return $response;
			
		} else {
			// NOT authenticated, throw a RestagonException with a Response object (and 401 response)
			$response = new Response($this->_request);
			$response->addHeader(StatusCodes::HTTP_401);
			$errorBody = array("error" => array (
				"errorCode" => "1003",
				"errorMessage" => "The request is not Authenticated",
				"errorURL" => ERROR_PAGES_URL . "1003"
			));
			$response->setBody($errorBody);
			throw new RestagonException($response);
		}
	}
	
}


