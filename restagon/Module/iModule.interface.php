<?php
/**
 * iModule.interface.php
 * Enforces the existence of a urlMap method that returns a regular expression of the URL to match.
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
 * @package Restagon.Module
 * @author Mohamed Ibrahim <mohamed@minarah.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mohamed@minarah.com>
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 * @link http://restagon.minarah.com Restagon - PHP RESTful API Framework
 * @version 0.0.2
 */


/**
 * The iModule interface governs implementing Module Controller classes to contain methods for the
 * urlMap which is the resource url's path (or parts of it) as a regular expression. When the 
 * Router class finds a match between the urlMap() and the REQUEST_URI, it'll send the execution
 * to the matched Module controller class.
 * 
 * @package Restagon.Module
 */
interface iModule
{
	
	/**
	 * Class Constructor, will set the resquest property
	 * 
	 * @param Request The current request
	 */
	public function __construct($request);
	
	/**
	 * urlMap() method to return the UNIQUE Module's Regular Expression URL string
	 * Each implementing class must have this method, and return the unique url path info
	 * It may contain a regex.
	 * ( example: map for 'hotmail.com/insignificant/subdir/whatever/count/1' is '/whatever/count/(\d+)'
	 * 
	 * @return the url path map minus the host name (sddf.com) and the query string (?sdfd=sdfdf....)
	 */
    public static function urlMap();
	
	/**
	 * HTTP REQUEST METHODS
	 * the method name must be the same as each of the supprted request methods
	 * 
	 * @return Response a Response object containing all data (and headers?) to send back
	 */
	# I will not enforce the creation of an unused http request method through this interface,
	# that will be up to the developer to include. But if a method is requested and is not implemented
	# in the Module controller (implementing this interface) an error will be sent back to client.
	
}


