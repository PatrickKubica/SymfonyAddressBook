# Symfony Address Book
A personal address book build with Symfony.

You are able to create new contacts, edit and view your current ones and upload pictures to identify your contacts.

## Installation
To install this project please run
```bash
composer install
```

Please make sure that you adjust the configuration in
`app\config\parameters.yml` so it matches the configuration for the database that you are using.

While developing I have been using sqlite, to do so you need to add a `database_path` to `app\config\parameters.yml`. Please make sure that you created the directory that holds your database and run
```bash
php bin/console doctrine:database:create
```

and execute
```bash
php bin/console doctrine:schema:create
```
to let doctrine create the correct database schema for this application.

Run
```bash
php bin/console bin/console server:run
```

and the application is ready and waiting for you on http://127.0.0.1:8000/

This application was tested on PHP 7.2 and PHP 7.3