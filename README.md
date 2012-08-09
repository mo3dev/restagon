Restagon
========
Another PHP RESTful API Framework.


Installation Instructions
-------------------------
* Download and Extract the contents of the zip file.
* Rename the extracted directory to the root of your API (ie. api, or v1/api with the appropriate versioning).
* Edit the ERROR_PAGES_URL define in the config.php file with the url to your error pages.
* Create a Controller of your choice in 'applicaton/modules' (see SampleController.php file).
* Add your newly created controller to the index.php (see addModuleController( 'SampleController' ); ).
* Test.