<?php
/**
 * RouteMapTest.php
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

require_once( dirname(__FILE__) . '/../../../config.php');
require_once( RESTAGON_DIRECTORY_PATH . 'Routing/RouteMap.php' );

class RouteMapTest extends PHPUnit_Framework_TestCase
{
	
	protected $routeMap;
	
	/**
	 * setUp()
	 */
	protected function setUp()
	{
		$this->routeMap = new RouteMap();
	}
	
	/**
	 * testGetRegularExpressionFromRouteMap()
	 */
	public function testGetRegularExpressionFromRouteMap()
	{
		### get the regular expression from the method using a given urlmap param, then compare expected
		$regex = $this->routeMap->getRegularExpressionFromRouteMap( 'api/v1/sample/a/1/b/2' );
		$this->assertEquals( $regex, '/^\/api\/v1\/sample\/a\/1\/b\/2\z/i' );
		
		// another one with an actual regex as part of the urlMap
		$regex2 = $this->routeMap->getRegularExpressionFromRouteMap( '/whatever/count/(\d+)/hello' );
		$this->assertEquals( $regex2, '/^\/\/whatever\/count\/(\d+)\/hello\z/i' );
		
		// test to fail
		$regex3 = $this->routeMap->getRegularExpressionFromRouteMap( '/whatever/count/(\d+)/helloworld' );
		$this->assertNotEquals( $regex3, '/^\/\/whatever\/count\/(\d+)\/hello\z/i' );
	}
	
}



