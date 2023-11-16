<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

###Logs###
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('admin', 'IndexController@index')->name('login'); // for redirection purpose


Route::get('reset/success', function (Request $request) {
    return view('admin.auth.passwords.success');
});

###Swagger Link###
Route::get('apidocs', static function (Request $request) {
    return view('documentation.index');
});

Route::get('json-file', static function (Request $request) {


    //Get Json File
    $file = file_get_contents(base_path('webservices.json'));

    $decodeFile = json_decode($file, true);

    //Replace Host With Current Host
    $decodeFile['host'] = request()->getHttpHost();

    //Set Base Path
    $decodeFile['basePath'] = str_replace('json-file', 'api/v1', request()->getRequestUri());

    //Set Scheme According To Request
    $decodeFile['schemes'] = $request->isSecure() ? ['https'] : ['http'];

    return response()->json($decodeFile);

})->name('json-url');


/*Route::name('/')->group(
    function () {*/

/*Route::get('/', 'IndexController@index');
Route::group(['middleware' => 'backendAuthenticate'], function () {



    Route::group(['middleware' => ['backendAuthenticate', 'PermissionHandler']], function () {


        ###role management routes###
        Route::resource('role', 'RoleController');
        Route::get('role/set-permissions/{role}', 'RoleController@setPermissions')->name('role.set-permissions');
        Route::post('role/set-permissions/update/{role}', 'RoleController@setPermissionsUpdate')->name('role.set-permissions.update');

        ###Customer###
        Route::get('customer/data', 'CustomerController@data')->name('customer.data');
        Route::resource('customer', 'CustomerController');
        Route::get('customer/active/{record}', 'CustomerController@active')->name('customer.active');
        Route::get('customer/inactive/{record}', 'CustomerController@inactive')->name('customer.inactive');

        ###Sub Admins###
        Route::get('sub-admin/data', 'SubAdminController@data')->name('sub-admin.data');
        Route::resource('sub-admin', 'SubAdminController');
        Route::get('sub-admin/active/{record}', 'SubAdminController@active')->name('sub-admin.active');
        Route::get('sub-admin/inactive/{record}', 'SubAdminController@inactive')->name('sub-admin.inactive');

        ###Contact Us###
        Route::get('contact-us/data', 'ContactUsController@data')->name('contact-us.data');
        Route::resource('contact-us', 'ContactUsController');


        ###Push Notification###
        Route::get('notification', 'NotificationController@showNotification')->name('notification.index');
        Route::post('notification/send', 'NotificationController@sendNotification')->name('notification.send');

        ###Banner Routes###
        Route::get('banner/data', 'BannerController@data')->name('banner.data');
        Route::resource('banner', 'BannerController');
        Route::get('banner/active/{record}', 'BannerController@active')->name('banner.active');
        Route::get('banner/inactive/{record}', 'BannerController@inactive')->name('banner.inactive');

        ###Brand Routes###
        Route::get('brand/data', 'BrandController@data')->name('brand.data');
        Route::resource('brand', 'BrandController');


        ###Pages###
        Route::resource('cms', 'CmsController');

        ###Admin profile###
        Route::get('/edit-profile', [
            'uses' => 'UsersController@editProfile',
            'as' => 'users.edit-profile'
        ]);

        Route::post('/edit-profile', [
            'uses' => 'UsersController@updateEditProfile',
            'as' => 'users.edit-profile'
        ]);

        ###Change Password###
        Route::get('/change-password', [
            'uses' => 'UsersController@changePassword',
            'as' => 'users.change-password'
        ]);


        Route::post('/change-password', [
            'uses' => 'UsersController@processChangePassword',
            'as' => 'users.change-password'
        ]);
    });
}
);
###Login ###
Route::get('/login', [
    'uses' => 'Auth\LoginController@showLoginForm',
    'as' => 'login'
]);

Route::post('/login', [
    'uses' => 'Auth\LoginController@login',
    'as' => 'login'
]);

###Logout###
Route::any('/logout', [
    'uses' => 'Auth\LoginController@logout',
    'as' => 'logout'
]);

###Reset Password###
Route::post('/password/email', 'Auth\ForgotPasswordController@send_reset_link_email')->name('password.email');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset_password_update')->name('reset.password.update');
//Route::post('/password/reset', 'Auth\ResetPasswordController@reset_password_update');
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

Route::get('/password/reset/{email}/{token}/{role_id}', 'Auth\ResetPasswordController@reset_password_from_show')->name('password.reset');*/
//}
//);
