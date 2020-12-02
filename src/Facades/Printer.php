<?php

namespace AwemaPL\Printer\Facades;

use AwemaPL\Printer\Contracts\Printer as PrinterContract;
use Illuminate\Support\Facades\Facade;

class Printer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PrinterContract::class;
    }
}
