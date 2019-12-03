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

Route::get('/', function () {
    return view('welcome');
});
Route::get('errors', function (){
    return view('errors/upload');
});
Route::get('content/{folder1}/{folder2}/{filename}', function ($folder1, $folder2, $filename){
    $path = env('CONTENT').$folder1.'/'.$folder2.'/'.$filename;
    if(!file_exists($path)){
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

Route::get('content/{folder1}/{filename}', function ($folder1, $filename){
    $path = env('CONTENT').$folder1.'/'.$filename;
    if(!file_exists($path)){
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
Route::group(['middleware'=>['auth', 'userActive']], function (){

    Route::get('/setting', 'setting\SettingController@index');
    Route::post('/setting', 'setting\SettingController@update');

    Route::get('/users', 'user\UserController@index');
    Route::get('/user-edit/{id}', 'user\UserController@form');
    Route::get('/user-form', 'user\UserController@form');
    Route::post('/user-save', 'user\UserController@create');
    Route::post('/user-save/{id}', 'user\UserController@update');
    Route::get('/user-suspend/{id}', 'user\UserController@suspend');
    Route::get('/user-unsuspend/{id}', 'user\UserController@unsuspend');
    Route::get('/user-reset/{id}', 'user\UserController@reset');
    Route::post('/user-reset/{id}', 'user\UserController@password');

    Route::get('/cat-main', 'categories\CategoryController@index');
    Route::get('/cat-form', 'categories\CategoryController@form');
    Route::post('/cat-save', 'categories\CategoryController@create');
    Route::get('/cat-form/{id}', 'categories\CategoryController@form');
    Route::post('/cat-save/{id}', 'categories\CategoryController@update');
    Route::get('/cat-delete/{id}', 'categories\CategoryController@delete');

    Route::get('/sub-main', 'categories\SubCategoryController@index');
    Route::get('/sub-form', 'categories\SubCategoryController@form');
    Route::post('/sub-save', 'categories\SubCategoryController@create');
    Route::get('/sub-form/{id}', 'categories\SubCategoryController@form');
    Route::post('/sub-save/{id}', 'categories\SubCategoryController@update');
    Route::get('/sub-delete/{id}', 'categories\SubCategoryController@delete');

    Route::get('/workshop-list', 'workshop\workshopController@index');
    Route::get('/workshop-form', 'workshop\workshopController@form');
    Route::post('/workshop-save', 'workshop\workshopController@create');
    Route::post('/workshop-save/{id}', 'workshop\workshopController@update');
    Route::get('/workshop-delete/{id}', 'workshop\workshopController@delete');
    Route::get('/workshop-edit/{id}', 'workshop\workshopController@form');

    Route::get('/brand', 'Lists\BrandController@index');
    Route::get('/brand-create', 'Lists\BrandController@create');
    Route::post('/brand-store', 'Lists\BrandController@store');
    Route::get('/brand-update/{id}', 'Lists\BrandController@update');
    Route::post('/brand-edit/{id}', 'Lists\BrandController@edit');
    Route::get('/brand-destroy/{id}', 'Lists\BrandController@destroy');
});
