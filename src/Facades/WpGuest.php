<?php

namespace Pavenum\LaravelWpRest\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pavenum\LaravelWpRest\LaravelWpRest
 */
class WpGuest extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Pavenum\LaravelWpRest\Wordpress\WpApiGuest::class;
    }
}
