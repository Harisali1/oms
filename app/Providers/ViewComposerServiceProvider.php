<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;


/**
 * Class ViewComposerServiceProvider
 *
 * @author Yousuf Sadiq <muhammad.sadiq@joeyco.com>
// */
class ViewComposerServiceProvider extends ServiceProvider
{


    public function boot()
    {
        $this->composeAdminPages();


        view()->composer('*', function ($view)
        {
            $header_menu = 0;
            if (auth()->user()) {
                $auth_user = Auth::user();

                $userPermissoins = $auth_user->getPermissions();
               /* dd([$auth_user,$userPermissoins]);*/
                $dashbord_cards_rights = $auth_user->DashboardCardRightsArray();
                $Admin_name = $auth_user->name;
                $joey = auth()->user();

                /*composing data to all views */
                $view->with(compact(
                    'joey','header_menu','userPermissoins','dashbord_cards_rights','Admin_name'
                ));
            }

        });
    }

    public function register()
    {
        //
    }

    /**
     * Compose the admin pages
     *
     * e-g: admin page titles etc.
     */
    private function composeAdminPages()
    {


    }
}
