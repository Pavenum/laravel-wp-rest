<?php

namespace Pavenum\LaravelWpRest\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pavenum\LaravelWpRest\LaravelWpRest
 */
class LaravelWpRest extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Pavenum\LaravelWpRest\LaravelWpRest::class;
    }
}
