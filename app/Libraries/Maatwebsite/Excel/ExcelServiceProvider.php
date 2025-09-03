<?php

namespace App\Libraries\Maatwebsite\Excel;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Maatwebsite\Excel\Excel;

class ExcelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('excel', function () {
            return new Excel();
        });
    }
}
