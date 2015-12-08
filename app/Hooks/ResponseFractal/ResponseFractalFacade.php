<?php

namespace GDGFoz\ResponseFractal;

use Illuminate\Support\Facades\Facade;

class ResponseFractalFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'response_fractal'; }

}