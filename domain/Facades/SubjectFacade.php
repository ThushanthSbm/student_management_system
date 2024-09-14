<?php

namespace domain\Facades;

use Illuminate\Support\Facades\Facade;
use domain\Services\SubjectService;

class SubjectFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SubjectService::class;
    }
}
