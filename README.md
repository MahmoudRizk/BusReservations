# Introduction
The goal of this project is to implement a building a fleet-management system (bus-booking
system) using the latest version of the Laravel Framework.

# Setup

Built using php 8.15 & laravel 9. 

After installing the mentioned requirements above.

1. Clone the repo
2. In the .env file add database connection configuration. For simplicity I have been using sqlite, but any database vendor can be used.
```
DB_CONNECTION=sqlite
DB_DATABASE='absolute/path/to/db.sqlite'
```
3. Run database migrations with demo data
```
php artisan migrate:fresh --seed
```
4. Run the server
```
php artisan serve
```

# Features
* Authentication service
    * Responsible for user registeration & login.
* Administration service
    * Where operations team can manage operations like creating new trips lines & add new cities.
    * Only users with Admin role can perform these actions.
* Reservations service
    * Service used by customers to create & check reservations.

# APIs
* Implemented using rest APIs.
* Check postman collection: https://documenter.getpostman.com/view/12423053/UyxjF5qL

# Database tables
* Cities
    * List of available cities to be used in trip configuration.
* Users
    * list of system users.
* User Assigned Roles
    * List of roles assigned to certain user.
* Trips
    * List of trips, and it configuration like departure city, arrival city & max number of seats.
* Reservations
    * List of reservations made by the user against certain trip.
    * Each reservation is recorded in a separated row.
