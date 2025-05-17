# Medical E-commerce Platform

A Laravel-based medical e-commerce platform for managing products, orders, and customer interactions.

## Prerequisites
- PHP >= 8.1
- Composer
- Node.js & NPM
- SQLite (default) or MySQL


## Installation and testing
Clone the repo & Install dependencies
```bash
git clone https://github.com/abdelmeenam/Medical-E-commerce
composer install
npm install
npm run dev
npm run build
cp .env.example .env
php artisan key:generate
```

## Database Configuration
The project uses MySQL:
1. Update the `.env` file with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

2. Run migrations & Server:
```bash
php artisan migrate:fresh --seed
php artisan serve
```

## Endpoints

1. Admin Endpoints :
    - **GET /admin/login** - login as an admin 
        email : admin@example.com - 
        password : password
    - **Get /admin/products** - Get all Products.
    - **Get /admin/products/create** - Create new Products.
    - **GET /admin/products/{id}/edit** - Edit a single Product
    - **Get /admin/orders** - Get all Products.
    - **Get /admin/orders/{id}** - Get a single order with full cusrtomer data.


2. Shop Endpoints :
    - **Get /products** - Show Products Page.
    - **Get /Cart** - Show Cart Page.
    - **Get /checkout** - checkout Page.
    - **Get /order/success** - Order confirmation Page.
    






