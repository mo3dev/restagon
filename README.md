Restagon
========
Another PHP RESTful API Framework.


Features
--------
* Uses regular expressions on the URL to route requests to a specific controller
* The Controllers can listen to any custom URL format the developer wants (not restricted to the controller name)
* It is easy to add Controllers to the API
* You can implement any HTTP METHODS you need, and not worry about implementing the rest


Installation Instructions
-------------------------
* Download and Extract the contents of the zip file.
* Rename the extracted directory to the root of your API (ie. api, or v1/api with the appropriate versioning).
* Edit the ERROR_PAGES_URL define in the config.php file with the url to your error pages.
* Create a Controller of your choice in 'applicaton/modules' (see SampleController.php file).
* Add your newly created controller to the index.php (see addModuleController( 'SampleController' ); ).
* Test.


Notes
-----
* The framework needs mod_rewrite enabled in your host, and to be able to use .htaccess files (they are blocked in some hosts)