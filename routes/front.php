<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');// Logs to see any kind of error
Route::get('/', 'HomeController@index');// Show Login Page

Route::group(['middleware' => 'backendAuthenticate'], function () { //admin middleware to manage authentication

    //After Login redirect to admin Dashboard
    Route::get('dashboard', 'UserController@signUpSuccess')->name('signup-success-get');
    //Profile
    Route::get('edit-profile', 'UserController@updateProfileView')->name('edit-profile');
    Route::post('edit-profile/update', 'UserController@updateEditProfile')->name('edit-profile.update');
    //Password Reset
    /*Route::get('reset-password', 'UserController@resetPasswordView')->name('reset-password.index');
    Route::put('change-password', 'UsersController@processChangePassword')->name('reset-password.update');*/
    Route::get('/change-password', ['uses' => 'UserController@resetPasswordView', 'as' => 'users.change-password']);
    Route::post('/change-password', ['uses' => 'UserController@processChangePassword', 'as' => 'users.change-password']);

    Route::group(['middleware' => ['backendAuthenticate', 'PermissionHandler']], function () {
        //Roles
        Route::resource('role', 'RoleController');
        Route::get('role/set-permissions/{role}', 'RoleController@setPermissions')->name('role.set-permissions');
        Route::post('role/set-permissions/update/{role}', 'RoleController@setPermissionsUpdate')->name('role.set-permissions.update');

        //Sub-Admin Route
        Route::resource('sub-admin', 'SubAdminController');
        Route::get('sub-admin/active/{record}', 'SubAdminController@active')->name('sub-admin.active');
        Route::get('sub-admin/inactive/{record}', 'SubAdminController@inactive')->name('sub-admin.inactive');

        //Dispatch Route For View
        Route::get('grocery-dispatch', 'DispatchController@groceryIndex')->name('Grocery-Dispatch');
        // Get data by search, sorting, and filtered by ajax
        Route::get('grocery-dispatch/data', 'DispatchController@groceryData')->name('Grocery-Dispatch.data');
        // Open Assign, Transfer And PreBroadcast Modals
        Route::get('order/modals/{dispatch}', 'DispatchController@assignTransferAndPreBroadcastModalData')->name('open.modals');
        // transfer order from joey to joey
        Route::get('order/transfer/{joey}/dispatch/{dispatch}', 'DispatchController@transferOrder')->name('transfer.order');
        // assign order to joey
        Route::get('order/assign/{joey}/dispatch/{dispatch}', 'DispatchController@assignOrder')->name('assign.order');
        //Rebroadcast order
        Route::post('order/rebroadcast/{sprint}', 'DispatchController@reBroadcastOrder')->name('rebroadcast.order');
        //Pre Broadcast order to multiple joeys
        Route::post('order/pre_broadcast', 'DispatchController@preBroadcastOrder')->name('pre.broadcast.order');
        // dispatch cancel order
        Route::post('order/cancel/{sprint}', 'DispatchController@sprintCancel')->name('sprint.cancel');
        // order Edit
        Route::get('order/{sprint}/edit', 'DispatchController@editOrder')->name('edit.order');
        // map markers
        Route::get('order/{sprint}/map', 'DispatchController@getMapLatLng')->name('order.map');
        //order Notes
        Route::post('order/{sprint}/note', 'DispatchController@OrderNote')->name('order.note');
        //view Order Notes
        Route::get('order/{sprint}/notes', 'DispatchController@dispatchOrderNotes')->name('order.notes');
        // order Details
        Route::get('order/{sprint}/detail', 'DispatchController@sprintOrderDetail')->name('order.detail');
        // update Sprint
        Route::put('order/{sprint}/update', 'DispatchController@sprintOrderUpdate')->name('order.sprint.update');
        // sprint task update
        Route::put('order/{sprint_task}/task/update', 'DispatchController@sprintOrderTaskUpdate')->name('order.sprint.task.update');
        // map view of dispatch
        Route::post('dispatch/map-view', 'DispatchController@dispatchMapView')->name('dispatch.map.view');

        Route::get('grocery-dispatch-map-view', 'DispatchController@groceryDispatchMap')->name('Dispatch-map');

        Route::get('ecommerce-dispatch', 'DispatchController@eCommerceIndex')->name('E-Commerce-Dispatch');


        /// Batch Orders Routes
        Route::get('batch-order-list', 'BatchOrdersController@index')->name('batch-order.index');
        Route::get('batch-create-model', 'BatchOrdersController@batchCreateModelHtmlRender')->name('batch-create-model-html-render');
        Route::post('batch-create', 'BatchOrdersController@CreateBatch')->name('create.batch');
        Route::get('/ajax/date/sam', 'BatchOrdersController@ajaxedit')->name('edit.ajax');
        //Assign to joey
        Route::get('batch-assign-model', 'BatchOrdersController@AssigntoJoey')->name('assign.batch.joey');
        Route::post('batch-assign-joey', 'BatchOrdersController@CreateBatchAssign')->name('create.batch.assign');
        //transfer to joy
        Route::get('transfer-assign-batch', 'BatchOrdersController@transferBatchView')->name('transfer.batch.joey');
        Route::post('transfer-batch-assign-joey', 'BatchOrdersController@transferBatch')->name('transfer.batch');
        //edit
        Route::get('edit/{id}/batch/', 'BatchOrdersController@editBatch')->name('edit.assign.batch');
        Route::post('edit-profile/update', 'BatchOrdersController@updateEditBatch')->name('edit-batch.update');
        //DELETE
        Route::get('delete/batch/data', 'BatchOrdersController@viewDeletebatch')->name('Unassigned.batch');
        Route::delete('delete/batch/success', 'BatchOrdersController@deleteBatch')->name('success.Unassigned.batch');
        //Map
        Route::get('batch/map', 'BatchOrdersController@Map')->name('map.view');

        Route::get('batch/delete/all', 'BatchOrdersController@deleteAll')->name('batch.delete.all');

        //Order Control
//        Route::get('order_control', 'ControlOrderController@index')->name('order.control.index');

        Route::resource('delivery_type', 'DeliveryTypeController');
        Route::get('delivery_type/status/{deliveryType}', 'DeliveryTypeController@status')->name('delivery_type.status');
        Route::get('delivery_type/edit', 'DeliveryTypeController@edit')->name('delivery_type.edit');

        Route::resource('delivery_preference', 'DeliveryPreferenceController');
        Route::get('delivery_preference/status/{deliveryPreference}', 'DeliveryPreferenceController@status')->name('delivery_preference.status');

        Route::resource('order_category', 'OrderCategoryController');
//        Route::resource('order_zone_routing', 'OrderZoneRoutingController');
//        Route::resource('order_category_zones', 'OrderCategoryZoneController');

        Route::resource('schedule', 'ScheduleController');
        Route::post('schedule/search', 'ScheduleController@searchSchedule')->name('schedule.search');

        Route::get('shift/publisher', 'ShiftPublisherController@index')->name('shift.publisher.index');
        Route::post('shift/publisher/search', 'ShiftPublisherController@search')->name('shift.publisher.search');
        Route::get('shift/publisher/display/{schedule}/joey_id/{joey}', 'ShiftPublisherController@status')->name('shift.publisher.display');
        Route::delete('shift/publisher/enabled_disabled_schedule', 'ShiftPublisherController@enabledDisabledSchedule')->name('shift.publisher.enabled.disabled');

        Route::get('jobs', 'JobController@index')->name('job.route');
        Route::get('jobs/{id}', 'JobController@jobRoutes')->name('job.routes');
        Route::get('joey_routes', 'JoeyRouteController@index')->name('joey.route.index');

        //Page for return orders
        Route::get('return-orders', 'ReturnOrdersController@index')->name('return-orders-get');
        Route::get('detail-return-orders', 'ReturnOrdersController@Details')->name('detail-return-orders');


    });
});



Route::get('signup', 'Auth\RegisterController@showSignUpView')->name('sign-up');
Route::post('register-joey', 'Auth\RegisterController@registerJoey')->name('register-joey');
//Route::post('create/profile', 'Auth\RegisterController@create')->name('create-profile');
//Route::post('signup', 'Auth\RegisterController@signupStepOne')->name('signup-step-one');

// Activate joey account after signup
Route::get('/account/active/{email}/{token}', 'Auth\RegisterController@accountActive')->name('account.active');
Route::get('account/active/success', 'Auth\RegisterController@accountActiveSuccess')->name('account.active.success');
###Login ###
Route::get('/login', ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'login']);
Route::post('/login-joey', ['uses' => 'Auth\LoginController@login', 'as' => 'login-joey']);

Route::get('/auth-type', ['uses' => 'Auth\LoginController@getType', 'as' => 'type']);
Route::post('/type/auth', ['uses' => 'Auth\LoginController@posttypeauth', 'as' => 'post.type.auth']);
Route::get('/google-auth', ['uses' => 'Auth\LoginController@getgoogleAuth', 'as' => 'get.google.auth']);
Route::post('/google/auth', ['uses' => 'Auth\LoginController@postgoogleAuth', 'as' => 'post.google.auth']);
Route::get('/verify-code', ['uses' => 'Auth\LoginController@getverifycode', 'as' => 'get.verify.code']);
Route::post('/verify/code', ['uses' => 'Auth\LoginController@postverifycode', 'as' => 'post.verify.code']);
###Logout###
Route::any('/logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);
###Reset Password###
Route::post('/password/email', 'Auth\ForgotPasswordController@send_reset_link_email')->name('password.email');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset_password_update')->name('reset.password.update');
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::get('/password/reset/{email}/{token}/{role_id}', 'Auth\ResetPasswordController@reset_password_from_show')->name('password.reset');






