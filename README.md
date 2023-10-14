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

## Pages
in blade we can use directives (@) and interpolation {{smthg}}. Some of them
```
@php
    $time = time();
    $str = '<h2>Hello</h2>'
@endphp

@if(true)
    is true
@endif

{!!$str!!}  {{-- html output --}};

@{{$str}}  {{-- skip this handle --}};

@json(['app' => 'myApp'])

@foreach([1,2,3] as $value)
    {{$value}}
@endforeach

@include('includes.header')

{{route('register')}} - generate url

@yield('content') - create section

@section('content')
    <h1>Login</h1>
@endsection


@stack('css') // set in parent template
@stack('js')

@once
    @push('css')
        <link rel="stylesheet" href="/css/trix.css">
    @endpush
    
    @push('js')
        <script src="/js/trix.js"></script>
    @endpush
@endonce

{{request('tag')}}

```

To bind view with template (and add vars):   
```php
class LoginController extends Controller
{
    public function index(){
//        return view('login.index')->with('foo', 'bar'); //this also works;
        return view('login.index', ['foo' => 'bar']); // this is more popular
    }
}
```
Create section (to extend)  
`layouts.base.blade.php`  
```html
<main class="flex-grow-1 py-3">
    @yield('content')
</main>

```

extend our layouts.base.blade.php  
```html
@extends('layouts.base')
@section('content')
    <h1>Login</h1>
@endsection
```

To share variable in whole app, use `AppServiceProvider::boot`  
```php
    public function boot(): void
    {
        View::share('date', date('Y'));
        View::composer('blog*', function ($view){
            // share in 'blog*'
            $view->with('balance', 123);
        });
    }
```

## Blade Components  

Create components
`resources/views/components/card.blade.php`
```html
@props(['myprop' => false]) {{--describe props and set defualt value --}}
<div class="card mb-3"{{$attributes->merge(['one' => '1', 'two' => '2'])}}> // this will output all attributes key=>value. Add default attributes with merge() method

    {{ $slot }} {{-- default slot --}}
 
    @dump($myprop)

    @isset($myslot)  {{-- custom slot --}}
        <div>{{ $myslot }}</div>
    @endisset

</div>
```
Use component in template
`:post` - means, that this is object, not component attribute.
```html
 <div class="col-12">
    <x-card my-custom-attr="abc" myprop one="0" :post="$post">
        my content 
        <x-slot name="myslot"> {{-- custom slot --}}
            myslot
        </x-slot>
    </x-card>
   
</div>
or
<x-select :options="[1 => 1, 2 => 2]"/>
```

## Requests
```php
    public function store(Request $request){
        $request->all();
        $request->only(['name']);
        $request->except(['_token']);
        $request->input('email');
        $request->boolean('agreement');
        $request->email;
        $request->file('avatar');
        $request->has('name');
        $request->filled('name');
        $request->missing('first_name');

        $request->ip();
        $request->path();
        $request->url();
        $request->fullUrl();
    }
```
## Responses  
```php
  public function __invoke()
    {
        $html = response('Test', 200, ["k1" => 'v1']);
        $json = response()->json(['key1' => 'val1'], 200, ['k1' => 'v1']);
        return $json;
    }


        return redirect('/abc'); // redirect to url
        return redirect()->route('user'); // redirect to route
        return redirect()->back();
        return redirect()->back()->withInput(); // redirect with form values
```

## Session
config is in `config/session.php`  

```php
session(['foo' => 'bar', 'baz' => 'gas']); // write to session
session('foo'); // read from session
session()->has('foo') // check if session has key
session()->all() // get all values
session()->forget('foo'); // clear one value
session()->flush();// clear all session
session()->pull('alert') // get and delete item
```
## Database  
config is in `config/database.php`  
Migrations are in `database/migrations`  
Create migration  
```bash
./vendor/bin/sail php artisan make:migration create_users_table
```
modify columns and run migration
```bash
./vendor/bin/sail php artisan migrate
```
create another one migration
```bash
php artisan make:migration add_admin_field_to_users_table
```

revert last migration
```bash
./vendor/bin/sail php artisan migrate:rollback

```
revert all migrations
```bash
 ./vendor/bin/sail php artisan migrate:reset
```
revert all migrations and migrate again (migrate:reset+ migrate)
```bash
./vendor/bin/sail php artisan migrate:fresh
```
## Model
create model  
```bash
./vendor/bin/sail php artisan make:model Currency
```
file `app/Models/Currency.php` will be created  
Create model with migration  
```bash
./vendor/bin/sail php artisan make:model Currency -m
```
Some useful methods
```php
 $currency = App\Models\Currency::first();
$currency->toArray();
$currency->toJson();
$currency->name
```

## Validation  
```php
validator([], [])
Validator::make([], [])
validator(['email' => 'aaa@mail.de'], ['email' => 'required|string|email']);

$validator = validator(['email' => 'aaa@mail.de'], ['email' => ['required', 'string', 'email']]);
$validator->passes(); // true or false
$validator->fails(); // true or false
$validator->validate(); // returns validated fields
```
Example validation in controller
```php
    public function store(Request $request){
       $validated = validator($request->all(), [
           'title' => ['required', 'string', 'max:100'],
           'content' => ['required', 'string'],
       ])->validate();
       // do something with $validated
    }
```
Create post request for validation (another way)
```bash
 ./vendor/bin/sail php artisan make:request Post/StorePostRequest
```
Then use in controller this request in argument instead of default

We can throw custom error
```php
    throw ValidationException::withMessages([
        'custom_field' => 'Custom message'
    ]);
```
We can use validation to compare values from DB  
```php
    [
       'country_id' => ['required', 'integer', 'exists:countries,id'], 
       'country_id' => ['required', 'integer', Rule::exists('countries', 'id')->where('active', true)], // check with condition
       'name' => ['required', 'unique:users,name'], // not yet in database
       'published_at' => ['required', 'string', 'date_format:Y.m.d'],
       'email' => ['required', Rule::unique('users', 'email')->ignore($user->id)], // all except some user
        // callback
       'title' => [ 'required', function (string $attribute, mixed $value, Closure $fail) {
            if ($value === 'foo') {
                $fail("The {$attribute} is invalid.");
            }
          },
       ],
    ]

```
Create custom rule
```bash
./vendor/bin/sail artisan make:rule Phone
```

## Save to DB  
```php
        User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);
```
Some different ways to fill object  
```php
    $user = new User([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);
    $user->setAttribute('email', $validated['email']);
    $user->fill(['email' => $validated['email']]);
    $user->email = $validated['email'];
    $user->save();
```

## Faker example  
```php
      for($i=0; $i < 99; $i++){
           $post = Post::query()->create([
               'user_id' => User::query()->value('id'),
               'title' => fake()->sentence(),
               'content' => fake()->paragraph(),
               'published_at' => fake()->dateTimeBetween(now()->subYear(), now()),
               'published' => true
           ]);
       }
```

## Get data from DB  
```php
    $posts = Post::all(['id', 'title','published_at']); // get all posts with separate fields
    $posts = Post::query()->limit(12)->get(['id', 'title','published_at']); // with limit
    $posts = Post::query()->paginate(12, ['id', 'title','published_at']); // with pagination

```
