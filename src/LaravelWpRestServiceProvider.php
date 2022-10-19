<?php

namespace Pavenum\LaravelWpRest;

use Illuminate\Support\Facades\Http;
use Pavenum\LaravelWpRest\Facades\WpGuest;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Pavenum\LaravelWpRest\Commands\LaravelWpRestCommand;

class LaravelWpRestServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-wp-rest')
            ->hasConfigFile()
//            ->hasViews()
//            ->hasMigration('create_laravel-wp-rest_table')
//            ->hasCommand(LaravelWpRestCommand::class)
        ;
    }
}
