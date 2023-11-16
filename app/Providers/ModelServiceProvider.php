<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ModelServiceProvider
 *
 * @author Yousuf Sadiq <muhammad.sadiq@joeyco.com>
 */
class ModelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    /**
     * Bind the interface to an implementation model class
     */
    public function register()
    {
        $this->app->bind('App\Models\Interfaces\UserInterface', 'App\Models\User');
        $this->app->bind('App\Models\Interfaces\SiteSettingInterface', 'App\Models\SiteSetting');
        $this->app->bind('App\Models\Interfaces\JoeyDepositInterface', 'App\Models\JoeyDeposit');
        $this->app->bind('App\Models\Interfaces\JoeyVehicleInterface', 'App\Models\JoeyVehicle');
        $this->app->bind('App\Models\Interfaces\JoeyDocumentInterface', 'App\Models\JoeyDocument');
        $this->app->bind('App\Models\Interfaces\ZonesInterface', 'App\Models\Zones');
        $this->app->bind('App\Models\Interfaces\PreferWorkTimesInterface', 'App\Models\PreferWorkTime');
        $this->app->bind('App\Models\Interfaces\PreferWorkTypesInterface', 'App\Models\PreferWorkType');
        $this->app->bind('App\Models\Interfaces\ContactUsInterface', 'App\Models\ContactUs');
//        $this->app->bind('App\Models\Interfaces\ZoneScheduleInterface', 'App\Models\ZoneSchedule');
        $this->app->bind('App\Models\Interfaces\JoeysZoneScheduleInterface', 'App\Models\JoeysZoneSchedule');
        $this->app->bind('App\Models\Interfaces\CityInterface', 'App\Models\City');
        $this->app->bind('App\Models\Interfaces\TrainingInterface', 'App\Models\Trainings');
        $this->app->bind('App\Models\Interfaces\QuizInterface', 'App\Models\Quiz');
        $this->app->bind('App\Models\Interfaces\OrderCategoryInterface', 'App\Models\OrderCategory');
        $this->app->bind('App\Models\Interfaces\JoeyAttemptedQuizInterface', 'App\Models\JoeyAttemptedQuiz');
        $this->app->bind('App\Models\Interfaces\JoeyAttemptedQuizDetailInterface', 'App\Models\JoeyAttemptedQuizDetail');
        $this->app->bind('App\Models\Interfaces\JoeyTrainingSeenInterface', 'App\Models\JoeyTrainingSeen');
        $this->app->bind('App\Models\Interfaces\QuizAnswerInterface', 'App\Models\QuizAnswers');
        $this->app->bind('App\Models\Interfaces\DocumentTypeInterface', 'App\Models\DocumentType');

        //Dispatch


        $this->app->bind('App\Models\Interfaces\DispatchInterface', 'App\Models\Dispatch');
        $this->app->bind('App\Models\Interfaces\VendorInterface', 'App\Models\Vendor');
        $this->app->bind('App\Models\Interfaces\JoeyInterface', 'App\Models\Joey');
        $this->app->bind('App\Models\Interfaces\HubInterface', 'App\Models\Hub');
        $this->app->bind('App\Models\Interfaces\DispatchInterface', 'App\Models\Dispatch');
        $this->app->bind('App\Models\Interfaces\PermissionsInterface', 'App\Models\Permissions');
        $this->app->bind('App\Models\Interfaces\RoleInterface', 'App\Models\Roles');

        $this->app->bind('App\Models\Interfaces\DeliveryTypeInterface', 'App\Models\DeliveryType');
        $this->app->bind('App\Models\Interfaces\DeliveryPreferenceInterface', 'App\Models\DeliveryPreference');
        $this->app->bind('App\Models\Interfaces\OrderZoneRoutingInterface', 'App\Models\OrderZoneRouting');
        $this->app->bind('App\Models\Interfaces\ZoneScheduleInterface', 'App\Models\ZoneSchedule');
        $this->app->bind('App\Models\Interfaces\SprintZoneScheduleInterface', 'App\Models\SprintZoneSchedule');
        $this->app->bind('App\Models\Interfaces\JoeyZoneScheduleInterface', 'App\Models\JoeyZoneSchedule');

    }
}
