<?php
namespace Yeganehha\DynamicForms\Facades;

use Illuminate\Support\Facades\Facade;

class DynamicForms extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'DynamicForms';
    }
}
