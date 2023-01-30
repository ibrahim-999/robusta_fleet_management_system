# Fleet Management System

## Task Description

The goal of this project is to implement a building a fleet-management system (bus-booking
system) using the latest version of the Laravel Framework.

## Prerequisite
- PHP 8.2
- Laravel 9.19
- Mysql for database

## Installation

### Step 1.
- Begin by cloning this repository to your machine
```
git clone `repo url` 
```

- Install dependencies
```
composer install
```

- Create environmental file and variables
```
cp .env.example .env
```

- Generate app key
```
php artisan key:generate
```

### Step 2
- Next, create a new database and reference its name and username/password in the project's .env file.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=root
DB_PASSWORD=your_password
```

- Run migration
```
php artisan migrate or php artisan migrate:fresh
```

### Step 3
- before start, you need to run table seeders
```
php artisan db:seed
```

### Step 4
- To start the server, run the command below
```
php artisan serve
```

## Application Route
```
http://127.0.0.1:8000
```

## Task Expectations

provided 2 APIs for any consumer(ex: web app, mobile app,...)
- User can book a seat if there is an available seat.
- User can get a list of available seats to be booked for his trip by sending start and end
- Postman collection to test Apis

## Author
- ibrahim khalaf
