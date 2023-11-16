<?php

namespace App\Providers;

use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 *
 * @author Yousuf Sadiq <muhammad.sadiq@joeyco.com>
 */
class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    /**
     * Bind the interface to an implementation repository class
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Interfaces\AdminRepositoryInterface', 'App\Repositories\AdminRepository');
        $this->app->bind('App\Repositories\Interfaces\UserRepositoryInterface', 'App\Repositories\UserRepository');
        $this->app->bind('App\Repositories\Interfaces\TrainingRepositoryInterface', 'App\Repositories\TrainingRepository');
        $this->app->bind('App\Repositories\Interfaces\QuizRepositoryInterface', 'App\Repositories\QuizRepository');
        $this->app->bind('App\Repositories\Interfaces\RoleRepositoryInterface', 'App\Repositories\RolesRepository');

        $this->app->bind('App\Repositories\Interfaces\DeliveryTypeRepositoryInterface', 'App\Repositories\DeliveryTypeRepository');
        $this->app->bind('App\Repositories\Interfaces\DeliveryPreferenceRepositoryInterface', 'App\Repositories\DeliveryPreferenceRepository');
        $this->app->bind('App\Repositories\Interfaces\OrderZoneRoutingRepositoryInterface', 'App\Repositories\OrderZoneRoutingRepository');
        $this->app->bind('App\Repositories\Interfaces\OrderCategoryRepositoryInterface', 'App\Repositories\OrderCategoryRepository');
        $this->app->bind('App\Repositories\Interfaces\ZoneScheduleRepositoryInterface', 'App\Repositories\ZoneScheduleRepository');
        $this->app->bind('App\Repositories\Interfaces\RouteRequestRepositoryInterface', 'App\Repositories\RouteRequestRepository');
        $this->app->bind('App\Repositories\Interfaces\JoeyZoneScheduleRepositoryInterface', 'App\Repositories\JoeyZoneScheduleRepository');
        $this->app->bind('App\Repositories\Interfaces\PreferenceRepositoryInterface', 'App\Repositories\PreferenceRepository');
    }
}
