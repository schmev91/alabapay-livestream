<?php

namespace Alabapay\AlabapayLivestream\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Alabapay\AlabapayLivestream\AlabapayLivestream
 */
class AlabapayLivestream extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Alabapay\AlabapayLivestream\AlabapayLivestream::class;
    }
}
