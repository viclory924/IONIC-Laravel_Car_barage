<?php

use Illuminate\Http\Request;

/*
 * |--------------------------------------------------------------------------
 * | API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register API routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | is assigned the "api" middleware group. Enjoy building your API!
 * |
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', 'workshop\workshopController@mobView');
Route::get('/details/{id}', 'workshop\workshopController@modShowDetails');

Route::get('/setting', 'setting\SettingController@mobGetSetting');

Route::get('/services', 'categories\CategoryController@mobView');
Route::get('/sub-services/{id}', 'categories\SubCategoryController@mobView');
Route::post('/login', 'user\UserController@mobLogin');
Route::post('/register', 'user\UserController@mobRegister');

Route::post('/valid-mob', 'user\UserController@mobValidMobile');
Route::post('/valid-email', 'user\UserController@mobValidEmail');

Route::post('/reset-email', 'user\UserController@mobResetByEmail');
Route::post('/reset-mobile', 'user\UserController@mobResetByMobile');
Route::post('/reset-check', 'user\UserController@mobCheckResetCode');
Route::post('/reset-pass', 'user\UserController@mobRestPass');

Route::group(['middleware' => ['auth:api']], function () {
    //userController
    Route::post('/change-pass', 'user\UserController@mobChangePass');
    Route::post('/upload-profile', 'user\UserController@mobUploadProfileImg');

    //carController
    Route::get('/car-list', 'car\CarController@mobIndex');
    Route::post('/car-add', 'car\CarController@mobStore');
    Route::post('/upload-car-image/{id}', 'car\CarController@mobCarImage');
    Route::get('/car-delete/{id}', 'car\CarController@mobDeleteCar');
    Route::get('/car-history/{id}', 'car\CarController@mobCarHistory');
    Route::post('/car-scan', 'car\CarController@mobCarScan');

    //workshop
    Route::post('/booking', 'workshop\requestController@mobBook');
    Route::get('/garage-info', 'workshop\workshopController@mobGarageInfo');
    Route::post('/upload-workshop-image', 'workshop\workshopController@mobGarageImg');
    Route::post('/save-workshop-data', 'workshop\workshopController@mobGarageSaveData');
    Route::post('/save-workshop-place', 'workshop\workshopController@mobGarageSavePlace');

    //notification
    Route::get('/noti', 'notification\notificationController@mobGetNoti');
    Route::get('/openNotiPage', 'notification\notificationController@mobOpenNotiPage');

});
