<?php
/**
 * RouteMap.php
 * Holds a urlMap (url path/regular expression) and it's corresponding Module Controller class.
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
 * @package Restagon.Routing
 * @author Mohamed Ibrahim <mo3dev@gmail.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mo3dev@gmail.com>
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 * @link http://restagon.minarah.com Restagon - PHP RESTful API Framework
 * @version 0.0.2
 */


/**
 * The RouteMap class is used only in the Router class to save routes (or urlMaps/url path regex)
 * and their corresponding Module controller class names. This class is also able to calculate or
 * generate a full regular expression using the urlMap to be used by the Router directly to match
 * a Module controller to the REQUEST_URI (or any other url path).
 * 
 * @package Restagon.Routing
 */
class RouteMap
{
	
	/**
     * URL Map for the Module Controller. This is NOT a full regular expression, even though it can contain
	 * (in some parts) regular expressions. This hold the components (paths) of url (REQUEST_URI)
	 * ie. /whatever/count/(\d+)/hello
     * 
     * @var mixed url map (path components for url to match)
     */
	public $urlMap;
	
	/**
     * Module Controller Class for the RouteMap
     * 
     * @var string module controller class name
     */
	public $moduleControllerClass;
	
	
	/**
     * getRegularExpressionFromRouteMap() method generates and returns an ACTUAL regular expression 
	 * using the $urlMap property.
     * 
	 * @param mixed $urlMap is the url map (optionally) passed in (cool trick that helps with testing)
     * @return mixed regular expression of url from url map
     */
	public function getRegularExpressionFromRouteMap($urlMap = false)
	{
		// check the $urlMap as it is an optional parameter
		$urlMap = $urlMap ? $urlMap : $this->urlMap;
		
		### from the components of $urlMap, generate and return a regular expression.
		$regex = '/^';
		$urlMapComponents = preg_split("/\//", $urlMap);
		foreach ($urlMapComponents as $component) {
			$regex .= "\/" . $component;
		}
		$regex .= '\z/i';
		
		return $regex;
	}
}


