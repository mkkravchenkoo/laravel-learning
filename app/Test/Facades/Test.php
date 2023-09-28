<?php

namespace App\Test\Facades;

use Illuminate\Support\Facades\Facade;

class Test extends Facade
{
    protected static function getFacadeAccessor(): string
    {
       return 'test';
    }
}
