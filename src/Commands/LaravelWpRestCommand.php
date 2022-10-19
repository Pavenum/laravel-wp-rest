<?php

namespace Pavenum\LaravelWpRest\Commands;

use Illuminate\Console\Command;

class LaravelWpRestCommand extends Command
{
    public $signature = 'laravel-wp-rest';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
