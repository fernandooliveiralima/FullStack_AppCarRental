## FullStack App Car Rental


![maintenance-status](https://img.shields.io/badge/maintenance-actively--developed-brightgreen.svg)

## Description Of Project
     What does the application do?
    App Car Rental, is a fullstack application that is a car rental company, where you can enter records of car models and their brands. 
     

## Technologies Applied in the Project
     
### DataBase
![maintenance-status](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

### Authentication
![maintenance-status](https://img.shields.io/badge/JWT-000000?style=for-the-badge&logo=JSON%20web%20tokens&logoColor=white)

### BackEnd
![maintenance-status](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)

## FrontEnd
![maintenance-status](https://img.shields.io/badge/Vue%20js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D)

## Installation Instructions

### Pre Requirements
## Composer
## NodeJs

### Steps for Project Execution

### Step 1 - Clone the project Run the code below
```bash
git clone https://github.com/fernandooliveiralima/FullStack_AppCarRental.git 
```
### Step 2 - Access the project folder Run the code below
```bash
cd FullStack_AppCarRental 
```

### Step 3 - Install the project's BackEnd Dependencies Run the code below
```bash
composer install
```
### Step 4 - Rename the file `.env.example` to `.env` Run the code below
```bash
cp .env.example .env
```

### Step 6 - Configure the `.env` file Copy the code below
```bash
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=appcar_rental
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

```

### Step 7 - Create the Database: `appcar_rental` `Suggestion: Use MySQL Workbench`

## Important: The `DB_PASSWORD` field cannot be empty, enter your MySQL Workbench password. 

### In MySQL Workbench Run the Code Below
```bash
1. create database appcar_rental;
2. use appcar_rental;
```

### Step 8 - Run Project Migrations Run the code below
```bash
php artisan migrate
```

### Step 9 - Generate the Application Key Run the code below
```bash
php artisan key:generate
```

### Step 10 - Generate the Application Storage Link Run the code below
```bash
php artisan storage:link
```
### Step 11 - Generate the Application Authentication JWT Secret Key Run the code below
```bash
php artisan jwt:secret
```

### Step 12 - Install the Application's NodeJs Dependencies Run the code below
```bash
npm install
```

### Step 13 - Open Two Parallel Terminals:
### In Terminal 1 Run The Code Below
```bash
php artisan serve
```

### In Terminal 2 Run The Code Below
```bash
npm run dev
```

## Application Authentication Instructions
1. With Both Terminals Running
2. Create Your Account in the `Register` Tab Fill in All Fields
3. After creating your account, go to the `Login` tab and enter your email and password to authenticate.
### Ready Now You Can Enjoy The Application's New Features!


