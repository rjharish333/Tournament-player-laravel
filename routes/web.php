<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\Dashboard\Auth\AuthController::class, 'login']);
Route::get('/login', [App\Http\Controllers\Dashboard\Auth\AuthController::class, 'login'])->name('login');
Route::get('email-verification', [App\Http\Controllers\Dashboard\Auth\AuthController::class, 'emailVerify'])->name('email-verification');

Route::post('email-verification', [App\Http\Controllers\Dashboard\Auth\AuthController::class, 'postEmailVerify'])->name('email-verification.post');

Route::get('email-verify/{token}', [App\Http\Controllers\Dashboard\Auth\AuthController::class, 'tokenEmailVerify'])->name('token.email.verification');

Route::post('/login', [App\Http\Controllers\Dashboard\Auth\AuthController::class, 'authenticate'])->name('authenticate');

Route::middleware(['auth'])->group( function(){

    Route::get('/sports/', 'App\Http\Controllers\Admin\SportController@index')->name('sports.index');

    Route::get('/sport/create/', 'App\Http\Controllers\Admin\SportController@create')->name('sport.create');

    Route::post('/sport/store/', 'App\Http\Controllers\Admin\SportController@store')->name('sport.store');

    Route::get('/sport/edit/{id}', 'App\Http\Controllers\Admin\SportController@edit')->name('sport.edit');

    Route::post('/sport/update/{id}', 'App\Http\Controllers\Admin\SportController@update')->name('sport.update');

    Route::get('/sport/destroy/{id}', 'App\Http\Controllers\Admin\SportController@destroy')->name('sport.destroy');

    Route::get('/regions/', 'App\Http\Controllers\Admin\RegionController@index')->name('regions.index');

    Route::get('/region/create/', 'App\Http\Controllers\Admin\RegionController@create')->name('region.create');

    Route::post('/region/store/', 'App\Http\Controllers\Admin\RegionController@store')->name('region.store');

    Route::get('/region/edit/{id}', 'App\Http\Controllers\Admin\RegionController@edit')->name('region.edit');

    Route::post('/region/update/{id}', 'App\Http\Controllers\Admin\RegionController@update')->name('region.update');

    Route::get('/region/destroy/{id}', 'App\Http\Controllers\Admin\RegionController@destroy')->name('region.destroy');

    // dashboard
  Route::post('/dashboard/team/update', [App\Http\Controllers\Dashboard\DashboardController::class, 'updateActiveTeam'])->name('dashboard.team.update');

  Route::get('/dashboard', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard');

  Route::get('/teams', [App\Http\Controllers\Dashboard\TeamController::class, 'index'])->name('teams.index');

  Route::get('/team/create/', [App\Http\Controllers\Dashboard\TeamController::class, 'create'])->name('team.create');

  Route::post('/team/store/', [App\Http\Controllers\Dashboard\TeamController::class, 'store'])->name('team.store');

  Route::get('/team/edit/{id}', [App\Http\Controllers\Dashboard\TeamController::class, 'edit'])->name('team.edit');

  Route::post('/team/update/{id}', [App\Http\Controllers\Dashboard\TeamController::class, 'update'])->name('team.update');

  Route::get('/team/delete/{id}', [App\Http\Controllers\Dashboard\TeamController::class, 'destroy'])->name('team.destroy');


  // change password
  Route::get('/change-password', [App\Http\Controllers\Dashboard\Auth\AuthController::class, 'changePassword'])->name('password.change');

  Route::post('/change-password', [App\Http\Controllers\Dashboard\Auth\AuthController::class, 'postChangePassword'])->name('postpassword.change');

  // user crud

  Route::get('/members/', 'App\Http\Controllers\Dashboard\UserController@index')->name('members.index');

  Route::post('/members/import', 'App\Http\Controllers\Dashboard\UserController@import')->name('members.import');

  Route::get('/member/create/', 'App\Http\Controllers\Dashboard\UserController@create')->name('member.create');

  Route::post('/member/store/', 'App\Http\Controllers\Dashboard\UserController@store')->name('member.store');

  Route::get('/member/edit/{id}', 'App\Http\Controllers\Dashboard\UserController@edit')->name('member.edit');

  Route::post('/member/update/{id}', 'App\Http\Controllers\Dashboard\UserController@update')->name('member.update');

  Route::get('/member/destroy/{id}', 'App\Http\Controllers\Dashboard\UserController@destroy')->name('member.destroy');

  Route::post('/user/change-password/', 'App\Http\Controllers\Dashboard\UserController@changePassword')->name('user.password');

  Route::get('/user/change-status/{id}', 'App\Http\Controllers\Dashboard\UserController@changeStatus')->name('user.status');

  // send email routes
  Route::get('/send-emails/', 'App\Http\Controllers\Dashboard\EmailController@index')->name('email.index');
  Route::post('/send-emails/', 'App\Http\Controllers\Dashboard\EmailController@sendEmail')->name('email.send');

  // activities routes
  Route::get('/activities', 'App\Http\Controllers\Dashboard\ActivityController@index')->name('activities.index');

  Route::get('/activity/create', 'App\Http\Controllers\Dashboard\ActivityController@create')->name('activity.create');

  Route::post('/activity/store', 'App\Http\Controllers\Dashboard\ActivityController@store')->name('activity.store');

  Route::get('/activity/show/{id}', 'App\Http\Controllers\Dashboard\ActivityController@show')->name('activity.show');

  Route::get('/activity/destroy/{id}', 'App\Http\Controllers\Dashboard\ActivityController@destroy')->name('activity.destroy');

  Route::get('/activity/attending/{id}', 'App\Http\Controllers\Dashboard\ActivityController@attending')->name('activity.attending');

  Route::get('/activitynot-attending/{id}', 'App\Http\Controllers\Dashboard\ActivityController@notAttending')->name('activity.not-attending');


  //logout
  Route::get('/logout', [App\Http\Controllers\Dashboard\Auth\AuthController::class, 'logout'])->name('logout');

  // distributors routes

  Route::get('/distributors/', 'App\Http\Controllers\Dashboard\DistributorController@index')->name('distributors.index');

  Route::post('/distributors/get-district', 'App\Http\Controllers\Dashboard\DistributorController@getDistricts')->name('distributors.districts');

  Route::get('/distributor/create/', 'App\Http\Controllers\Dashboard\DistributorController@create')->name('distributor.create');

  Route::post('/distributor/store/', 'App\Http\Controllers\Dashboard\DistributorController@store')->name('distributor.store');

  Route::get('/distributor/edit/{id}', 'App\Http\Controllers\Dashboard\DistributorController@edit')->name('distributor.edit');

  Route::post('/distributor/update/{id}', 'App\Http\Controllers\Dashboard\DistributorController@update')->name('distributor.update');

  Route::get('/distributor/destroy/{id}', 'App\Http\Controllers\Dashboard\DistributorController@destroy')->name('distributor.destroy');

  // retailers routes

  Route::get('/retailers/', 'App\Http\Controllers\Dashboard\RetailerController@index')->name('retailers.index');

  Route::get('/retailer/create/', 'App\Http\Controllers\Dashboard\RetailerController@create')->name('retailer.create');

  Route::post('/retailer/store/', 'App\Http\Controllers\Dashboard\RetailerController@store')->name('retailer.store');

  Route::get('/retailer/edit/{id}', 'App\Http\Controllers\Dashboard\RetailerController@edit')->name('retailer.edit');

  Route::post('/retailer/update/{id}', 'App\Http\Controllers\Dashboard\RetailerController@update')->name('retailer.update');

  Route::get('/retailer/destroy/{id}', 'App\Http\Controllers\Dashboard\RetailerController@destroy')->name('retailer.destroy');

  
  // target routes

  Route::get('/target/', 'App\Http\Controllers\Dashboard\TargetController@index')->name('target.index');

  Route::post('/target/update/', 'App\Http\Controllers\Dashboard\TargetController@update')->name('target.update');

  Route::post('/target/status/update/', 'App\Http\Controllers\Dashboard\TargetController@changeStatus')->name('target.status.update');

  Route::post('/types/update-order/', 'App\Http\Controllers\Dashboard\TargetController@updateOrders')->name('types.order.update');

   // Gift center routes

  Route::get('/gift-centers/', 'App\Http\Controllers\Dashboard\GiftCenterController@index')->name('giftcenters.index');

  Route::get('/gift-center/destroy/{id}', 'App\Http\Controllers\Dashboard\GiftCenterController@destroy')->name('giftcenter.destroy');

  Route::get('/gift-center/export/', 'App\Http\Controllers\Dashboard\GiftCenterController@export')->name('giftcenter.export');


  // Misscalls routes

  Route::get('/misscalls/', 'App\Http\Controllers\Dashboard\MisscallController@index')->name('misscalls.index');

  Route::get('/misscall/destroy/{id}', 'App\Http\Controllers\Dashboard\MisscallController@destroy')->name('misscall.destroy');

 });

  Route::get('/payment/{token}', 'App\Http\Controllers\Dashboard\StripePaymentController@stripe')->name('payment');
  Route::post('/payment/', 'App\Http\Controllers\Dashboard\StripePaymentController@createSession')->name('payment.post');

  Route::post('/hook-payment-success/', 'App\Http\Controllers\Dashboard\StripePaymentController@paymentSuccessHook')->name('payment.success-hook');
  Route::get('/payment-success/', 'App\Http\Controllers\Dashboard\StripePaymentController@paymentSuccess')->name('payment.success');
  Route::get('/failed-payment/', 'App\Http\Controllers\Dashboard\StripePaymentController@paymentError')->name('payment.error');

