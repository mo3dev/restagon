<?php
/**
 * ResponseFormatJSON.php
 * Default JSON response format class conforming to the iResponseFormat interface.
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
 * This JSON response format class is the default response format used by the framework to send a
 * response back to the client. It will be used if the developer didnt register custom response
 * format classes in the framework.
 * 
 * @package Restagon.HTTP
 */
class ResponseFormatJSON implements iResponseFormat
{
	
	/**
	 * extension() method returns the extension for the response format (ie 'json' for JSON format)
	 * 
	 * @return string extension for response format
	 */ 
	public function extension()
	{
		return 'json';
	}
	
	
	/**
	 * contentType() method returns the HTTP Content-Type associated with the response format
	 * 
	 * @return string the HTTP Content-Type for response format
	 */ 
	public function contentType()
	{
		return 'application/json';
	}
	
	
	/**
	 * getEncodedFormat() method returns encoded (serialized) response data using given raw data (ie. array)
	 * 
	 * @param mixed $data the data to be encoded into the response format (ie. array, etc...)
	 * @return string serialized (encoded) data to be sent back to client in the current response format
	 */ 
	public function getEncodedFormat($data)
	{
		return json_encode($data);
	}
	
}



