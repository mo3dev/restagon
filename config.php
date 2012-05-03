<?php
/**
 * config.php
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
 * @package Restagon
 * @author Mohamed Ibrahim <mo3dev@gmail.com>
 * @copyright Copyright 2012, Mohamed Ibrahim <mo3dev@gmail.com>
 * @licence http://opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License (BSD New)
 * @link http://restagon.minarah.com Restagon - PHP RESTful API Framework
 * @version 0.0.2
 */


######### PLEASE SET THE FOLLOWING TWO PATHS
#############################################

### The base directory path (the path containing the framework folder and everything else)
define( 'BASE_DIRECTORY_PATH' , '/ABSOLUTE/PATH/TO/public_html/api/v1/' ); // <--------- IMPORTANT 1

### The ABSOLUTE path to the (restagon) directory
define( 'RESTAGON_DIRECTORY_PATH' , BASE_DIRECTORY_PATH . 'restagon/' ); // please leave

### The ABSOLUTE path to the (application) directory
define( 'APPLICATION_DIRECTORY_PATH' , BASE_DIRECTORY_PATH . 'application/' ); // please leave



######### YOU CAN SET THE FOLLOWING PATHS, BUT WE RECOMMEND TO LEAVE AS THEY ARE (DEFAULT LOCATIONS)
####################################################################################################

### The ABSOLUTE path to the (modules) directory
define( 'MODULES_DIRECTORY_PATH' , APPLICATION_DIRECTORY_PATH . 'modules/'); // please leave

### The ABSOLUTE path to the (includes) directory
define( 'INCLUDES_DIRECTORY_PATH' , APPLICATION_DIRECTORY_PATH . 'includes/'); // please leave



######### PLEASE SET THE ROOT URLS
##################################

### The URL containing error pages
define( 'ERROR_PAGES_URL' , 'http://api.domain.com/docs/v1/errors/' ); // <------------- IMPORTANT 2


