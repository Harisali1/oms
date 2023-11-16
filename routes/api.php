<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], static function(){

    Route::get('create_route', 'RoutingController@index')->name('create.route');
    Route::get('create_route_afi', 'RoutingController@afiIndex')->name('create.route.afi');
    Route::get('routing', 'RoutingController@routing')->name('routing');
    Route::get('create-shifts', 'TestScheduleCreateController@index')->name('create.shifts');


    Route::get('/clear-cache', function() {
        Artisan::call('optimize:clear');
        return "Caches cleared successfully!";
    });

    Route::get('order-type', 'PreferenceController@order_type')->name('order_type');
    
});

