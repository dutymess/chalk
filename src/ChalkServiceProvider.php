<?php

namespace Dutymess\Chalk;

use Illuminate\Support\ServiceProvider;

class ChalkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerHelper();
    }



    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }



    protected function registerHelper()
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . "helpers.php";
    }
}
