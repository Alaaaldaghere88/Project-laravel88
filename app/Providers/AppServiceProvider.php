<?php

namespace App\Providers;

use App\Repositories\Eloquent\AppointmentRepository;
use App\Repositories\Eloquent\AuthRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\LocationRepository;
use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\Eloquent\PropertyTypeRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\LocationRepositoryInterface;
use App\Repositories\Interfaces\PropertyTypeRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\PropertyRepository;
use App\Repositories\Eloquent\ReviewRepository;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(PropertyTypeRepositoryInterface::class, PropertyTypeRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class,CategoryRepository::class);
        $this->app->bind(PropertyRepositoryInterface::class,PropertyRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\ReportRepositoryInterface::class,\App\Repositories\Eloquent\ReportRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class,ReviewRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\ReviewReplayRepositoryInterface::class,\App\Repositories\Eloquent\ReviewReplayRepository::class);
       // $this->app->bind(\App\Repositories\Interfaces\PropertyrepositoryInterface::class,Propertyre::class);
    }
}
