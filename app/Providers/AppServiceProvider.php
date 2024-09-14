<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use domain\Services\StudentService;
use domain\Facades\StudentFacade;
use App\Models\Student;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(StudentService::class, function ($app) {
            return new StudentService(new Student());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
