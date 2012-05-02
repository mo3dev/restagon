<?php
/**
 * iAuthenticate.interface.php
 * Enforces an isAuthenticated method and a method that returns the WWW-Authenticate header.
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
 * @package Restagon.Authentication
 * @author Mohamed Ibrahim <mo3dev@gmail.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mo3dev@gmail.com>
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 * @link http://restagon.minarah.com Restagon - PHP RESTful API Framework
 * @version 0.0.2
 */


/**
 * The iAuthenticate interface governs implementing custom auth classes to provide a header
 * (WWW-Authenticate) and a method to check whether or not the request is authenticated/authorized.
 * The business logic is up to the developer to include in other methods in the auth class.
 * 
 * @package Restagon.Authentication
 */ 
interface iAuthenticate
{
	
	/**
	 * isAuthenticated() method invokes other methods (up to developer) to perform the type of
	 * Authentication that is needed in the custom Authentication class implementing this interface.
	 * 
	 * @return boolean Whether the request is Authenticated or not.
	 */
	public function isAuthenticated();
	
	/**
	 * getAuthorizationHeader() method returns the HTTP Authorization header expected for the
	 * implementing authentication class.
	 * 
	 * @return string Authorization header for this auth type
	 */
	public function getAuthorizationHeader();
	
}


