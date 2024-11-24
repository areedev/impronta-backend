<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('max_decimal', function ($attribute, $value, $parameters) {
            $value = str_replace(',', '.', $value);
            return (floatval($value) <= 4);
        });

        Validator::extend('numeric_array', function ($attribute, $value) {
            foreach ($value as $key => $val) {
                $val = str_replace(',', '.', $val);
                if (!is_numeric($val)) {
                    return false;
                }
            }
            return true;
        });
    }
}
