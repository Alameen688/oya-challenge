# IPT WEB 

## SETUP


Composer
---------------

You will need to run ``composer install`` in command line to get all packages needed
```bash 
composer install
```

ENV.
---------------
Make a copy of the ``.env.example`` file and rename to ``.env`` . This will contain all your environmental variables 

KEY.
---------------
Finally you need to generate a key for the Laravel project.

```bash
php artisan key:generate
```
This will genrate a key that would be stored in the ``APP_KEY`` var in your ``.env`` file.
<hr>


DB
---------------
### How to setup db
The project uses mysql database.

Create a mysql database and name it oyachallenge

Fill in the  followiing credentials in the .env file
```env 
DB_DATABASE=oyachallenge
DB_USERNAME=root
DB_PASSWORD=
```

Once that is done, run 
```bash 
 php artisan migrate
```
..in your cli with the root folder as the working directory.

The above action will create the necessary tables in the database

Run
---------------
### How to run the app in development

to run the project, type
```bash
php artisan serve
```
The project will be running in ``http://127.0.0.1:8000`` by default, navigate to the address to view the project

API
---------------
### How to access the api
Api endpoints are listed in the swagger documentation which can be found by navigating to `http://127.0.0.1:8000/api/documentation`


