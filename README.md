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

