<?php
/**
 * RequestTest.php
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
require_once( RESTAGON_DIRECTORY_PATH . 'HTTP/Request/Request.php' );
require_once( RESTAGON_DIRECTORY_PATH . 'Restagon.api.php' );

class RequestTest extends PHPUnit_Framework_TestCase
{
	
	protected $request;
	
	/**
	 * setUp()
	 */
	protected function setUp()
	{
		new Restagon(); // for the includes in the Restagon class's constructor
		$this->request = new Request();
	}
	
	/**
	 * testAddResponseFormat()
	 * @expectedException RestagonException
	 */
	public function testAddResponseFormat()
	{
		// test the successful addition of a response format class (json)
		$result = $this->request->addResponseFormat( 'ResponseFormatJSON', 'application/json', 'json');
		$this->assertTrue($result);
		
		// test the failure when adding a class that D.N.E
		$result = $this->request->addResponseFormat( 'format-does-not-exist', 'application/json', 'json');
		// a RestagonException is expected from the bove, it is being expected by PHPUnit's @expectedException
	}
	
	/**
	 * testSetAuthenticationInstance()
	 * @expectedException RestagonException
	 */
	public function testSetAuthenticationInstance()
	{
		// test the successful addition of an Authentication class (NoAuthentication)
		$result = $this->request->setAuthenticationInstance( 'NoAuthentication' );
		$this->assertTrue($result);
		
		// test the failure when adding a class that D.N.E
		$result = $this->request->setAuthenticationInstance( 'auth-class-does-not-exist' );
		// a RestagonException is expected from the bove, it is being expected by PHPUnit's @expectedException
		
		// test the failure when adding a class that Exists but with an incorrect path
		$result = $this->request->setAuthenticationInstance( 'NoAuthentication', 'path-does-not-exist' );
		// a RestagonException is expected from the bove, it is being expected by PHPUnit's @expectedException
	}
	
	/**
	 * testParseHTTPAcceptHeader()
	 */
	public function testParseHTTPAcceptHeader()
	{
		// test a header and see if it is parsed correctly
		$result = $this->request->parseHTTPAcceptHeader( 'application/json;q=0.9,application/xhtml+xml' );
		$this->assertEquals( $result, array( 	array('data_format' => 'application/xhtml+xml', 'quality_score' => '1'),
												array('data_format' => 'application/json', 'quality_score' => '0.9') ) );
												
		// test a header and see if it is parsed correctly (a real Accept header from my browser)
		$result = $this->request->parseHTTPAcceptHeader( 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' );
		$this->assertEquals( $result, array( 	array('data_format' => 'text/html', 'quality_score' => '1'),
												array('data_format' => 'application/xhtml+xml', 'quality_score' => '1'),
												array('data_format' => 'application/xml', 'quality_score' => '0.9'),
												array('data_format' => '*/*', 'quality_score' => '0.8') ) );
	}
	
	/**
	 * testIsResponseFormatExtensionSupported()
	 */
	public function testIsResponseFormatExtensionSupported()
	{
		### assert that json is the default format without adding a class while checking for an extension
		$default = $this->request->isResponseFormatExtensionSupported( 'json' );
		$this->assertTrue( $default );
		
		### add a response format then check if it is supported
		$this->request->addResponseFormat( 'ResponseFormatXML', 'application/xml', 'xml');
		$result = $this->request->isResponseFormatExtensionSupported( 'xml' );
		$this->assertTrue( $result );
	}
	
}

