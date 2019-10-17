## Laravel 5.8 API task-management project
This is a simple task management Laravel 5.8 project that was created to test populating a database with API endpoints.  This application makes use of a custom artisan command that can be called at the root of the project to populate the appropriate database tables with the data from API endpoints.  This project utilizes Docker Compose to build its web, app, database, and optional (unused in this project) Redis container.  Please follow the steps below to get this project up and running in your local development environment!

## Examples of the Endpoints JSON data structures...

### Users:
```
[
  {
    "id": 1,
    "name": "Matilde Hagenes",
    "email": "wilson41@hotmail.com"
  }
]
```

### Timelogs:
```
[
  {
    "id": 1,
    "issue_id": 1,
    "user_id": 3,
    "seconds_logged": 24573
  }
]
```
### Issues:
```
[

  {
    "id": 1,
    "code": "repudiandae-rerum-vero-est-explicabo-fugit-eum-tenetur-aut",
    "components": [
      2,
      3
    ]
  }

]
```
### Components:
```
[

  {
    "id": 1,
    "name": "DEVOPS"
  }

]

```

### Step 1.  Clone the repository
Clone this repository to your local development environment.

### Step 2. Laravel ENV and project configuration
Once cloned, at the project root, change the name of your .env.example to  .env and add the following database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=33061
DB_DATABASE=timeKeeper
DB_USERNAME=root
DB_PASSWORD=secret
```
**(After the containers are buillt (Step 3), then you should be able to connect to the database with MySQLWorkbench or a similar MySQL GUI).

To finish off your .env file run the following CLI command at the root of your project to set your APP_KEY environmental variable:

```php artisan key:generate```

As a final step before building your docker containers run the following CLI command from the project’s root to ensure that all of the project dependencies are installed:

```composer install```

### Step 3.  Docker Compose
There are currently 5 files that control what containers to build and what dependencies to bring in when building the containers.  These files are located at the root of the project and are:

#### app.docker
This docker file builds the app container installing PHP 7 FPM (from image), MySQL, copies a php.ini in the Laravel config folder to the appropriate folder in the container, and sets the web application’s working directory (/var/www).

#### web.docker 
This docker file installs nginx 1.10 (from image), and adds the vhost.conf and uploadsize.conf files at the projects root to the appropriate folder in the container that is being built.  These files are nginx configuration files.  It also sets the server’s working directory (/var/www).

#### docker-compose.yml
This is the docker-compose YAML file for the project and includes the build information for the web, app, database, and optional (not use for this project) Redis containers.  Please note that the database credentials for this project are also stored in this file.  I chose to use MySQL 5.7.9 for this project.
 
#### vhost.conf
This file contains nginx configuration settings.  Some of these settings were pulled from another project but I choose to keep them intact because they allow you to upload files to the server more easily with less config headaches (as I recall).  They are meaningless to this project, but are helpful for others!  This configuration file is added to the web container on build.

#### uploadsize.conf
This file was also part of another project and again I chose to keep it intact with my other docker files.  It is added to the web container when it is built and enables the ability to configure a larger posting size on the server when uploading files to the server.

To get your containers built, run the following docker-compose CLI command at the root of the project.  This will build the web, app, database, and optional (unused in this project) redis container:

```docker-compose up -d```

If all appears successful then you should see no errors.  To check if your containers are ‘Up’ run the following CLI command at the project root:

```docker-compose ps```

### Step 4. Run Migrations
For this step you will migrate the database.  There are 5 migration files in this project.  They create the following tables in the database:

- users

- components

- issues

- component_issue (pivot relating components and issues)

- timelogs

To run the migration files and create the tables in your database run the following CLI command at the root of your project:

```php artisan migrate```

### Step 5.  Populate Database Tables with Custom Artisan Command
For this step you will populate the database using a custom artisan command.  The file that has the code for this command can be found at:  app/Console/Commands/taskTrackerData.php.

This CLI command needs to be run at the root of the project when the containers are up:

```php artisan add:data```

Now your application should have all of the necessary data to work at its endpoints.  Visit the links on the home page to see the JSON data output from the database!

### Step 6.  PHPUnit Testing
To run try out Laravel 5.8’s built in PHPUnit test functionality you can do so by utilizing the included APITest.php Unit test file by running the following CLI command at the project’s root:

```./vendor/bin/phpunit```

