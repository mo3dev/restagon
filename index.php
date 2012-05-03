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
 * @author Mohamed Ibrahim <mo3dev@gmail.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mo3dev@gmail.com>
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
$api->addModuleController( 'Sample' ); // url: /sample/a/1/b/




### Set the Default Authentication (optional, can be set in Controllers) for the whole application
$api->setDefaultAuthenticationClass( 'NoAuthentication' ); // public non-restricted access




### Dispatch the Request to the responsible Module Controller (automatically found by the Router)
$api->dispatch();




### PROCESS RESPONSE AND SEND IT BACK TO CLIENT
$api->answerThenExit();





