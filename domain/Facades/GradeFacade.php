<?php

namespace domain\Facades;

use Illuminate\Support\Facades\Facade;
use domain\Services\GradeService;

class GradeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GradeService::class;
    }
}
