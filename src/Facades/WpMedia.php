<?php

namespace Pavenum\LaravelWpRest\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pavenum\LaravelWpRest\LaravelWpRest
 */
class WpMedia extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Pavenum\LaravelWpRest\Wordpress\WpApi\WpMedia::class;
    }
}
