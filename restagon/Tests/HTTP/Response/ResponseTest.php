<?php
/**
 * ResponseTest.php
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
 * @package Restagon.Tests
 * @author Mohamed Ibrahim <mohamed@minarah.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mohamed@minarah.com>
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 * @link http://restagon.minarah.com Restagon - PHP RESTful API Framework
 * @version 0.0.2
 */

require_once( dirname(__FILE__) . '/../../../../config.php');
require_once( RESTAGON_DIRECTORY_PATH . 'HTTP/Response/Response.php' );
require_once( RESTAGON_DIRECTORY_PATH . 'Restagon.api.php' );

class ResponseTest extends PHPUnit_Framework_TestCase
{
	
	protected $response;
	
	/**
	 * setUp()
	 */
	protected function setUp()
	{
		new Restagon(); // for the includes in the Restagon class's constructor
		$this->response = new Response( new Request() );
	}
	
	/**
	 * testGetEncodedBody()
	 */
	public function testGetEncodedBody()
	{
		### set the body then see if the returned value from the method is the correct one
		$this->response->setBody( array( "test"=> "yay" ) );
		$result = $this->response->getEncodedBody();
		
		$this->assertEquals( $result, "{\"test\":\"yay\"}" );
	}

}

