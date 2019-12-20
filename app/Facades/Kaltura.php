<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Kaltura extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kaltura';
    }
}
