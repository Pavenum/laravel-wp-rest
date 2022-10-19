<?php

namespace Pavenum\LaravelWpRest\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pavenum\LaravelWpRest\LaravelWpRest
 */
class WpPost extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Pavenum\LaravelWpRest\Wordpress\WpApi\WpPost::class;
    }
}
