<?php
/**
 * index.php
 * kickstarts the API.
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
 
//ini_set('display_errors', 1);
//error_reporting(E_ALL);



### INCLUDES
require_once( dirname(__FILE__) . '/config.php' );
require_once( RESTAGON_DIRECTORY_PATH . '/Restagon.api.php' );

### Initialize (setup) the API
$api = new Restagon();




### Add (Support for) Response Formats (Custom Format classes implementing iResponseFormat interface)
// ADD YOUR OWN CUSTOM Response Formats BELOW:
//$api->addResponseFormat( 'ResponseFormatClassName', 'Content-Type', 'file extension' );
$api->addResponseFormat( 'ResponseFormatXML', 'application/xml', 'xml' );




### Add Module Controller Class Names (Manually)
$api->addModuleController( 'SampleController' ); // url: /sample/a/4




### Set the Default Authentication (optional, can be set in Controllers) for the whole application
$api->setDefaultAuthenticationClass( 'NoAuthentication' ); // public non-restricted access




# Add Global API Response Headers (in one place)
// You may want to send global response headers, this is where you want to add them. They will be
// sent at the end of execution with the response.
// note: takes the same 3 parameters as php's header() function. php.net/manual/en/function.header.php
// note: server signature (HTTP Server header) cannot be altered using php's header() function.
$api->addGlobalResponseHeader( 'X-Powered-By: Your Special API v1', true );




### Dispatch the Request to the responsible Module Controller (automatically found by the Router)
$api->dispatch();




### PROCESS RESPONSE AND SEND IT BACK TO CLIENT
$api->answerThenExit();





