#Search offices from existing database

##Installation
run ```composer install```
run ```npm install```
copy the config/parameters.yml.dist to config/parameters.yml and fill in the correct parameters
the database can be found in the database-folder

##Tests
run ```phpunit``` in de repository-folder

##Explanations

###API
Api documentation can be seen by using the route: ```api/doc```

###Changing javascript
The javascript files can be found in the src/AppBundle/Resources/public folder
Here you can change the javascript. To use the new javascript, run the ```gulp``` command.

### concatenate/uglify for production
run ```gulp production``` to concatenate/uglify files for production
