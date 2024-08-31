# Donation Tracker CLI

Donation Tracker CLI is a PHP-based command-line application that allows users to manage charities and track donations.
It supports operations such as adding, editing, and deleting charities, as well as adding and viewing donations.

## Features

- Add, view, edit, and delete charities.
- Add and view donations to specific charities.
- Input validation for charity and donation details.
- CSV file storage for persistent data.

## Requirements

- PHP 8.0 or higher
- Composer

## Installation

1. Clone the repository

2. Install dependencies via Composer:

    ```bash
    composer install
    ```

3. Ensure you have a valid CSV file for charities and donations in the `/data` directory:

    - `charities.csv`
    - `donations.csv`

   If these files do not exist, you can create them manually or they will be created automatically when you start using
   the application.

## Usage[CharityController.php](src%2FController%2FCharityController.php)

Run the application using the PHP CLI:
php index.php

Run the tests:
vendor/bin/phpunit