## About This Project

I have used Laravel as Backend API provider and Nuxt as Frontend, and used Tailwind for styling. 
I have added PHP Unit test for create, list and update operations.
I have also added input validations at back-end and toast notification at front-end.
I have added pagination for better viewing.

After cloning the project you can setup as follows:-

## Setup API (Laravel Backend)
Set your front-end url into config/cors.php like following:
```'allowed_origins' => ['http://localhost:3000']```

Set database credentials into env file then run following commands:
```cd  order-api```
```composer install```
```php artisan migrate```
```php artisan serve```

### Run Unit tests:
```php artisan test```

## Setup Frontend (Nuxt)
Set apiBase in next config or app/pages/orders/index.vue then run following commands:
```cd  order-nuxt```
```npm install ```
```npm run dev```

**visit /orders to access the orders page**

- [Working Demo Video](https://app.usebubbles.com/wJBRvomfMGMTYwuaFBSq2c/muhammad-order-management).