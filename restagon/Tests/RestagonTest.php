<?php
/**
 * RestagonTest.php
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
 * @author Mohamed Ibrahim <mo3dev@gmail.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mo3dev@gmail.com>
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 * @link http://restagon.minarah.com Restagon - PHP RESTful API Framework
 * @version 0.0.2
 */

require_once( dirname(__FILE__) . '/../../config.php');
require_once( RESTAGON_DIRECTORY_PATH . 'Restagon.api.php' );

class RestagonTest extends PHPUnit_Framework_TestCase
{
	
	protected $api;
	
	/**
	 * setUp()
	 */
	protected function setUp()
	{
		$this->api = new Restagon();
	}
	
	/**
	 * testAddResponseFormat()
	 */
	public function testAddResponseFormat()
	{
		// add a value then check to see if it was added (using the return boolean)
		$result = $this->api->addResponseFormat( 'ResponseFormatJSON', 'application/json', 'json');
		$this->assertEquals($result, TRUE);
		
		$result = $this->api->addResponseFormat( 'ResponseFormatXML', 'application/xml', 'xml');
		$this->assertEquals($result, TRUE);
		
		// test to fail - will execute code that has die(), until php-test-helpers ext is installed only test passes
		//$result = $this->api->addResponseFormat( 'invalid', 'application/test', 'test');
		//$this->assertEquals($result, FALSE);
	}
	
	/**
	 * testAddModuleController()
	 */
	public function testAddModuleController()
	{
		// add a controller class and check the return value (true = success, ErrorResponse object = fail)
		$result = $this->api->addModuleController('SampleController');
		$this->assertEquals($result, TRUE);
		
		// test to fail - will execute code that has die(), until php-test-helpers ext is installed only test passes
		//$result = $this->api->addModuleController('non-existent-controller-class');
		//$this->assertEquals($result, FALSE);
	}
	
	/**
	 * testSetDefaultAuthenticationClass()
	 */ 
	public function testSetDefaultAuthenticationClass()
	{
		// set an authentication class and check the return value (true = success, ErrorResponse object = fail)
		$result = $this->api->setDefaultAuthenticationClass( 'NoAuthentication' );
		$this->assertEquals($result, TRUE);
		
		// test to fail - will execute code that has die(), until php-test-helpers ext is installed only test passes
		//$result = $this->api->setDefaultAuthenticationClass('non-existent-authentication-class');
		//$this->assertEquals($result, FALSE);
	}
	
}


