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

use App\Models\Category;

//Route::get('/arrange-categories', function () {
//    $categories = Category::orderBy('id', 'asc')->get();
//    foreach ($categories as $i => $category) {
//        DB::table('categories')->where('id', $category->id)->update(['order' => ++$i]);
//    }
//});

Route::get('/', function () {
    return redirect()->route('login');
});

/**************************************** Auth *****************************************/
/* LOGIN ROUTES */
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('post.login');
Route::get('/logout', 'Auth\LoginController@logout')->middleware('auth')->name('logout');;

/* RESET PASSWORD */
Route::post('password/reset', 'Web\UsersController@forgotPassword')->name('sendResetEmail');
// activate account
Route::get('/user/{user_id}/{timestamp}/activate', ['uses' => 'Web\UsersController@activate']);

// set new password
Route::get('/user/{user_id}/set-password/{token}', ['uses' => 'Web\UsersController@getSetPassword']);

Route::post('/user/set-password', ['uses' => 'Web\UsersController@SetSetPassword', 'as' => 'resetPassword']);

Route::group(['namespace' => 'Web', 'middleware' => ['auth']], function () {

    Route::get('/home', ['uses' => 'AdminController@index', 'as' => 'admin.dashboard']);

    // categories CRUD
    Route::get('/categories', ['uses' => 'CategoryController@index', 'as' => 'categories.index']);
    Route::get('/categories/create', ['uses' => 'CategoryController@create', 'as' => 'categories.create']);
    Route::post('/categories', ['uses' => 'CategoryController@store', 'as' => 'categories.store']);
    Route::get('/categories/{id}/edit', ['uses' => 'CategoryController@edit', 'as' => 'categories.edit']);
    Route::patch('/categories/{id}', ['uses' => 'CategoryController@update', 'as' => 'categories.update']);
    Route::delete('/categories/{id}', ['uses' => 'CategoryController@destroy', 'as' => 'categories.destroy']);

    Route::get('/categories/{id}/{status}/', ['uses' => 'CategoryController@changeORder', 'as' => 'categories.change-order']);


    // color CRUD
    Route::get('/colors', ['uses' => 'ColorController@index', 'as' => 'colors.index']);
    Route::get('/colors/create', ['uses' => 'ColorController@create', 'as' => 'colors.create']);
    Route::post('/colors', ['uses' => 'ColorController@store', 'as' => 'colors.store']);
    Route::get('/colors/{id}/edit', ['uses' => 'ColorController@edit', 'as' => 'colors.edit']);
    Route::patch('/colors/{id}', ['uses' => 'ColorController@update', 'as' => 'colors.update']);
    Route::delete('/colors/{id}', ['uses' => 'ColorController@destroy', 'as' => 'colors.destroy']);

    // products CRUD
    Route::post('/products/import', ['uses' => 'ProductController@import', 'as' => 'products.import']);
    Route::get('/products', ['uses' => 'ProductController@index', 'as' => 'products.index']);
    Route::get('/products/create', ['uses' => 'ProductController@create', 'as' => 'products.create']);
    Route::post('/products', ['uses' => 'ProductController@store', 'as' => 'products.store']);
    Route::get('/products/{id}/edit', ['uses' => 'ProductController@edit', 'as' => 'products.edit']);
    Route::get('/products/{id}/show', ['uses' => 'ProductController@show', 'as' => 'products.show']);
    Route::patch('/products/{id}', ['uses' => 'ProductController@update', 'as' => 'products.update']);
    Route::delete('/products/{id}', ['uses' => 'ProductController@destroy', 'as' => 'products.destroy']);

    Route::get('/product/{product_id}/variant/add', ['uses' => 'ProductController@addVariant', 'as' => 'products.add_variant']);
    Route::post('/product/variants/store', ['uses' => 'ProductController@StoreVariants', 'as' => 'products.store_variants']);

    Route::get('/load-form/{form}', ['uses' => 'FormController@load', 'as' => 'form.loader']);
    Route::get('/variants/{product_id}/loader', ['uses' => 'ProductController@getVariants', 'as' => 'product.variant.load']);
    Route::get('/variant/{variant_id}/loader', ['uses' => 'ProductController@getVariant', 'as' => 'product.variant']);
    Route::delete('/variants/{id}', ['uses' => 'ProductController@deleteVariant', 'as' => 'variant.destroy']);
    Route::post('/variant/{id}', ['uses' => 'ProductController@updateVaraint', 'as' => 'variant.update']);

    // orders
    Route::get('/orders', ['uses' => 'OrderController@index', 'as' => 'orders.index']);
    Route::get('/orders/{id}/show', ['uses' => 'OrderController@show', 'as' => 'orders.show']);
    Route::post('/order/change-status', ['uses' => 'OrderController@changeStatus', 'as' => 'orders.change-status']);

    // account - sales CRUD
    Route::get('/sales', ['uses' => 'UsersController@index', 'as' => 'sales.index']);
    Route::get('/sales/create', ['uses' => 'UsersController@create', 'as' => 'sales.create']);
    Route::post('/sales', ['uses' => 'UsersController@store', 'as' => 'sales.store']);
    Route::get('/sales/{id}/edit', ['uses' => 'UsersController@edit', 'as' => 'sales.edit']);
    Route::patch('/sales/{id}', ['uses' => 'UsersController@update', 'as' => 'sales.update']);
    Route::delete('/sales/{id}', ['uses' => 'UsersController@destroy', 'as' => 'sales.destroy']);

    // account - sales CRUD
    // settings
    Route::get('/set-lang/{lang}', ['uses' => 'SettingController@setLang', 'as' => 'lang.set']);
    Route::get('/change-password', ['uses' => 'SettingController@changePasswordView', 'as' => 'user.change_pass_view']);
    Route::post('/change-password/store', ['uses' => 'SettingController@changePasswordStore', 'as' => 'user.change_pass_store']);

    // about us
    Route::get('/about-us', ['uses' => 'SettingController@getAboutUs', 'as' => 'user.get_about_us']);
    Route::post('/about-us', ['uses' => 'SettingController@postAaboutUs', 'as' => 'user.post_about_us']);

    Route::get('/settings', ['uses' => 'SettingController@settings_form', 'as' => 'user.settings_form']);
    Route::post('/permissions/update', ['uses' => 'SettingController@permissions', 'as' => 'permissions.update']);

    // users
    Route::get('/users', ['uses' => 'UsersController@allUsers', 'as' => 'users.index']);

    // statistics
    Route::get('/statistics/orders', ['uses' => 'StatisticsController@orders', 'as' => 'orders.chart']);

    Route::get('notification/send', ['uses' => 'NotificationController@notificationsForm', 'as' => 'notification.form']);
    Route::post('notification/submit', ['uses' => 'NotificationController@sendNotification', 'as' => 'notification.submit']);


    // categories CRUD
    Route::get('/ads', ['uses' => 'AdsController@index', 'as' => 'ads.index']);
    Route::get('/ads/create', ['uses' => 'AdsController@create', 'as' => 'ads.create']);
    Route::post('/ads', ['uses' => 'AdsController@store', 'as' => 'ads.store']);
    Route::get('/ads/{id}/edit', ['uses' => 'AdsController@edit', 'as' => 'ads.edit']);
    Route::patch('/ads/{id}', ['uses' => 'AdsController@update', 'as' => 'ads.update']);
    Route::delete('/ads/{id}', ['uses' => 'AdsController@destroy', 'as' => 'ads.destroy']);
});
