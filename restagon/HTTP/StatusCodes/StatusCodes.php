<?php
/**
 * StatusCodes.php
 * A class that holds and makes it easy to use HTTP 1.1's status' response headers.
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
 * The StatusCodes class provided HTTP 1.1 status codes and their messages as static constants. They
 * will be used (not exactly, bu only an example) to set response headers such as: 
 * header(StatusCodes::HTTP_200);
 * 
 * @package Restagon.HTTP
 */
class StatusCodes
{
	
	// Informational 1xx
	const HTTP_100 = 'HTTP/1.1 100 Continue';
	const HTTP_101 = 'HTTP/1.1 101 Switching Protocols';
	
	// Success 2xx
	const HTTP_200 = 'HTTP/1.1 200 OK';
	const HTTP_201 = 'HTTP/1.1 201 Created';
	const HTTP_202 = 'HTTP/1.1 202 Accepted';
	const HTTP_203 = 'HTTP/1.1 203 Non-Authoritative Information';
	const HTTP_204 = 'HTTP/1.1 204 No Content';
	const HTTP_205 = 'HTTP/1.1 205 Reset Content';
	const HTTP_206 = 'HTTP/1.1 206 Partial Content';
	
	// Redirection 3xx
	const HTTP_300 = 'HTTP/1.1 300 Multiple Choices';
	const HTTP_301 = 'HTTP/1.1 301 Moved Permanently';
	const HTTP_302 = 'HTTP/1.1 302 Found';  // 1.1
	const HTTP_303 = 'HTTP/1.1 303 See Other';
	const HTTP_304 = 'HTTP/1.1 304 Not Modified';
	const HTTP_305 = 'HTTP/1.1 305 Use Proxy';
	// 306 is deprecated but reserved
	const HTTP_307 = 'HTTP/1.1 307 Temporary Redirect';
	
	// Client Error 4xx
	const HTTP_400 = 'HTTP/1.1 400 Bad Request';
	const HTTP_401 = 'HTTP/1.1 401 Unauthorized';
	const HTTP_402 = 'HTTP/1.1 402 Payment Required';
	const HTTP_403 = 'HTTP/1.1 403 Forbidden';
	const HTTP_404 = 'HTTP/1.1 404 Not Found';
	const HTTP_405 = 'HTTP/1.1 405 Method Not Allowed';
	const HTTP_406 = 'HTTP/1.1 406 Not Acceptable';
	const HTTP_407 = 'HTTP/1.1 407 Proxy Authentication Required';
	const HTTP_408 = 'HTTP/1.1 408 Request Timeout';
	const HTTP_409 = 'HTTP/1.1 409 Conflict';
	const HTTP_410 = 'HTTP/1.1 410 Gone';
	const HTTP_411 = 'HTTP/1.1 411 Length Required';
	const HTTP_412 = 'HTTP/1.1 412 Precondition Failed';
	const HTTP_413 = 'HTTP/1.1 413 Request Entity Too Large';
	const HTTP_414 = 'HTTP/1.1 414 Request-URI Too Long';
	const HTTP_415 = 'HTTP/1.1 415 Unsupported Media Type';
	const HTTP_416 = 'HTTP/1.1 416 Requested Range Not Satisfiable';
	const HTTP_417 = 'HTTP/1.1 417 Expectation Failed';
	
	// Server Error 5xx
	const HTTP_500 = 'HTTP/1.1 500 Internal Server Error';
	const HTTP_501 = 'HTTP/1.1 501 Not Implemented';
	const HTTP_502 = 'HTTP/1.1 502 Bad Gateway';
	const HTTP_503 = 'HTTP/1.1 503 Service Unavailable';
	const HTTP_504 = 'HTTP/1.1 504 Gateway Timeout';
	const HTTP_505 = 'HTTP/1.1 505 HTTP Version Not Supported';
	const HTTP_509 = 'HTTP/1.1 509 Bandwidth Limit Exceeded';

}