Restagon - Another PHP RESTful API Framework
============================================

Another PHP RESTful API Framework


Installation Instructions
=========================
1- Download and Extract the contents of the zip file
2- Rename the extracted directory to the root of your API (ie. api, or v1/api with the appropriate versioning)
3- Edit the ERROR_PAGES_URL define in the config.php file with the url to your error pages
4- Create a Controller of your choice in 'applicaton/modules' (see SampleController.php file)
5- Add your newly created controller to the index.php (see addModuleController( 'SampleController' ); )
6- Test