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
//Auth::routes();
//mirar como va quedando el admin
/* Route::get('/admin', function () {
    return view('adminCoreui.layout');
}); */

////////RUTAS DE LOGIN Y AUTENTICACION
Route::group(['middleware' => 'guest'], function () {
    // Authentication Routes...OK
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('login'); //Pagina Principal el Login
    Route::post('logingo', 'Auth\LoginController@logingo')->name('logingo');
    // Registration Routes...OK
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
    // Password Reset Routes...OK
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    // Email Verification Routes...OK
    Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

    //cuando es autenticado o logueado Entra a administrar
    Route::get('admin', 'HomeController@index')->name('admin');

    //Controllador de Users
    Route::get('getUserAuth', 'UsersController@getUserAuth')->name('getUserAuth');
});
