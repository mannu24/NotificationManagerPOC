# NotificationsManagerPOC

## Introduction

This project is built with Laravel LiveWire and uses Vite for asset compilation. Follow the steps below to get the project up and running.

## Prerequisites

Make sure you have the following installed on your machine:

- PHP (version 8.2.11 or higher)
- Composer
- Node.js and npm
- MySQL

## Installation

### 1. Clone the repository

### 2. Copy .env.example to .env file

### 3. Install PHP dependencies
    composer install

### 4. Install Node.js dependencies
    npm install

### 5. Build assets for production
    npm run build

### 6. Generate application key
    php artisan key:generate

### 7. Set up the database
    -> Create mysql database with name notification_manager
    -> Update the .env file with your database credentials.

### 8. Run migrations
    php artisan migrate

### 9. Run migrations
    php artisan db:seed

### 10. Run the serve 
    php artisan serve
    follow the link in browser

## Admin Login
Login with below credentials
username : admin@sample.com
password : admin@sample.com
