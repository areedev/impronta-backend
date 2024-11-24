<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class CustomValidationRules
{
    public static function extendRules()
    {
        Validator::extend('max_decimal_4', function ($attribute, $value) {
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
