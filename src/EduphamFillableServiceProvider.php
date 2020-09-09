<?php

namespace Edupham\Fillable;

use Edupham\Fillable\App\Console\Commands\ShowTableFieldCommand;
use Edupham\Fillable\App\Console\Commands\ShowTableListCommand;
use Illuminate\Support\ServiceProvider;

class EduphamFillableServiceProvider extends ServiceProvider
{
    protected $package_name = 'fillable';

    protected $array_command = [
        ShowTableListCommand::class,
        ShowTableFieldCommand::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {}

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->array_command);
    }

}
