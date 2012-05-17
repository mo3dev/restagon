<?php
/**
 * RestagonException.php
 * Exception class acting as a container for a Response object that holds an error description.
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
 * @package Restagon.Exceptions
 * @author Mohamed Ibrahim <mohamed@minarah.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mohamed@minarah.com>
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 * @link http://restagon.minarah.com Restagon - PHP RESTful API Framework
 * @version 0.0.2
 */


/**
 * The RestagonException class is a custom exception class that is used when framework (and other)
 * errors arise. It is instantiated with only a Response object that will travel down until caught
 * and the response object taken to send back to client. The Response object will most likely hold
 * an error description as this exception class is only a container for Response objects.
 * 
 * @package Restagon.Exceptions
 */
class RestagonException extends Exception
{
	
	/**
	 * An instance of the Response class containing response headers, body, etc to send back to 
	 * client.
	 * 
	 * @var Response object containing the full response (headers, body, etc) to send to client as an error
	 */
	private $_response;
	
	
	/**
	 * RestagonException class constructor. The parameter Response object should ideally contain an 
	 * error body as this RestagonException class should only be used to return errors and not successful
	 * responses.
	 * 
	 * @param Response $response the Response object to send back
	 */
	public function __construct($response)
	{
		// set the Response property
		$this->_response = $response;
		
		// set the parent's constructor
		parent::__construct( 'Restagon Framework Error', 0, NULL );
	}
	
	
	/**
	 * getResponse() method is the getter method for _response property.
	 * 
	 * @return Response object set in _response property
	 */
	public function getResponse()
	{
		return $this->_response;
	}
	
}



