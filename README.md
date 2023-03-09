<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Homeowner Data CSV Parser
This project provides a solution for parsing a CSV file containing homeowner data provided by an estate agent. 
The CSV contains data where multiple homeowners have been entered into one field, often in different formats. 
The provided solution accepts the CSV and outputs an array of people, splitting the name into the correct fields, 
and splitting multiple people from one string where appropriate.

### Getting Started
To use this project, you will need to have the following software installed:

- PHP 7.4 or higher
- Composer
- Laravel 8.0 or higher

Once you have these prerequisites installed, follow these steps to get started:

Clone this repository to your local machine.

To install project dependancies run:

```
composer install
```

Start the Laravel development server by running:

```
php artisan serve
```

Open Postman and use a GET request to hit this endpoint. http://localhost:8000/upload-person-csv  (No Auth Needed)

Currently the project returns a Dump and Die to present the data in the format requested but on the next line down there is a return which can be uncommented.

### Features

- Parses a CSV file containing homeowner data provided by an estate agent.
- Outputs an array of people objects with the correct fields for each person.
- Splits the name into the correct fields.
- Splits multiple people from one string where appropriate.

### Changes Made
This project introduces four new files:

- **CsvPersonParser.php:** This file contains the implementation of the CsvPersonParser class. The class is responsible for reading in the CSV file and converting it to an array of people objects with the correct fields for each person.
- **PersonController.php:** This file contains the implementation of the uploadPersonCSV method which calls the parse method of the CsvPersonParser class and returns the resulting array of people.
- **api.php:** This file contains a new route that points to the uploadPersonCSV method of the PersonController class.
- **CsvPersonParserTest.php:** This file contains unit tests for the CsvPersonParser class.


### Usage
The project default csv is provided within the codebase at the following location:
storage/person-fixtures/people.csv 

The CSV includes the following columns:

- title
- first_name
- initial
- last_name


Should you want to swap out the csv file it is referenced on **L:14 in the PersonController**

### Tests
Unit tests have been created and added to the tests folder and all pass.
To run the test suite you will need phpunit installed and can trigger the tests by entering the following into the terminal.
```
vendor/bin/phpunit --filter CsvPersonParserTest
```

### Future Improvements
- In the future this project could be improved apon by the following refactor:
 - Refactoring Person to their own Scheme which would make the code easier to maintain should it need to upscale

### Screenshots
![image](https://user-images.githubusercontent.com/127329407/224027118-b18e0ee8-48f1-4bc8-bdab-d824c2db12dd.png)
![image](https://user-images.githubusercontent.com/127329407/224027221-b6811920-e7d6-4d99-a1a7-4e0364b51484.png)
![image](https://user-images.githubusercontent.com/127329407/224027335-00f6a448-a0aa-4929-b4d8-74e5f8029883.png)
![image](https://user-images.githubusercontent.com/127329407/224028118-07bf73cd-5abc-4191-8dcb-89422d049fa5.png)


