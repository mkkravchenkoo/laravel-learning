## Some commands  
`./vendor/bin/sail up -d`  - run project  
`./vendor/bin/sail php artisan` - artisan command  
`./vendor/bin/sail artisan tinker` - interpreter php  

`./vendor/bin/sail artisan tinker` - then run `app()` - will show project settings
Then run some container and use ` app()->make("cache")` or shot variant `app('cache')`

## Structure of laravel  
`app/` - The main code for project  
`bootstrap/app.php` - creates the app  
`config/` - settings    
`database/` - migrations, seeds  
`public/` - js/css which cals in browser
`resources/` - templates, some resources, which after build appears in public  
`routes/` - routes web and api  
`storage/` - logs, files, which user uploads 

Laravel is Service Container, it contains another services, for example cache, queues, auth, other  

Facades - it is ability to call Laravel feature in static way

Service Providers - gives ability to register own services inside container  
`config/app.php` - here are described all services  
`app/Providers` - some services you can find here  

## Create own provider  
`php artisan make:provider TestServiceProvider` - create own provider  
register `config/app.php`  
Then call `app("test")->config()`  

Also we can create own facade and call - `Test::config()`

can add own helper in `composer.json`, then run `./vendor/bin/sail composer dump`

## Routes and Controllers  

We have service provider for it `app/Providers/RouteServiceProvider.php`  
`routes/web.php` - Some route usage:  
```php
Route::get('/', function () {
    return view('welcome');
});
Route::view('/', 'welcome'); // the same

Route::redirect('/home', '/');
Route::fallback(function (){
    return 'our fallback';
});

```
Show all routes
```bash
./vendor/bin/sail php artisan route:list
```  
Create controller  
```bash
./vendor/bin/sail php artisan make:controller TestController
```
then import in `routes/web.php` - 
```php
Route::get('/test', TestController::class); 
```

CRUD
Create controller with resource
```bash
./vendor/bin/sail php artisan make:controller Posts/CommentController --resource
```
For CRUD we can use resource in this way `Route::resource('posts', PostController::class);` - it wil create all needed routes with default names

we have helper, that can show url - `route("posts.store")`  

## Middleware  
Some default middlewares you can find in` app/Http/Middleware`
Create middleware `./vendor/bin/sail artisan make:middleware LogMiddleware`  
add it to separate route `Route::get('/test', TestController::class)->middleware(LogMiddleware::class);`
log will be written in `storage/logs/laravel.log`  
global middlewares are in `app/Http/Kernel.php`
