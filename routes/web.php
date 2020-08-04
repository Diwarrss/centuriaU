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
    //Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    //Route::post('register', 'Auth\RegisterController@register');
    // Password Reset Routes...OK
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    //Route for access Bases de datos Unisangil http://centuria.unisangil.edu.co/bases-de-datos
    Route::get('login-bases-de-datos', 'Auth\LoginController@showLoginBd');
    //save accesses for login to http://centuria.unisangil.edu.co/bases-de-datos
    Route::post('createBdAccess', 'CenturiaBdAccessController@create');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    // Email Verification Routes...OK
    Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

    //cuando es autenticado o logueado Entra a administrar
    Route::get('admin', 'HomeController@index')->name('admin');

    //Controlador de Users
    Route::get('getUserAuth', 'UsersController@getUserAuth')->name('getUserAuth');
    Route::get('getUsers', 'UsersController@getUsers')->name('getUsers');
    Route::post('saveUser', 'UsersController@saveUser')->name('saveUser');
    Route::post('updateUser', 'UsersController@updateUser')->name('updateUser');
    Route::get('getPerfil', 'UsersController@getPerfil')->name('getPerfil');
    Route::post('updatePerfil', 'UsersController@updatePerfil')->name('updatePerfil');
    Route::post('updateAvatar', 'UsersController@updateAvatar')->name('updateAvatar');
    Route::post('updatePass', 'UsersController@updatePass')->name('updatePass');

    //Controlador de Ingresos
    Route::post('crearIngreso', 'IngresosController@crearIngreso')->name('crearIngreso');
    Route::post('crearIngresoBD', 'IngresosController@crearIngresoBD')->name('crearIngresoBD');
    Route::get('getIngresosActuales', 'IngresosController@getIngresosActuales')->name('getIngresosActuales');
    Route::get('getIngresos', 'IngresosController@getIngresos')->name('getIngresos');

    //Controlador Periodos
    Route::get('getPeriodo', 'PeriodosController@getPeriodo')->name('getPeriodo');
    Route::get('getPeriodosAll', 'PeriodosController@getPeriodosAll')->name('getPeriodosAll');
    Route::post('savePeriodo', 'PeriodosController@savePeriodo')->name('savePeriodo');
    Route::put('updatePeriodo', 'PeriodosController@updatePeriodo')->name('updatePeriodo');
    Route::get('getPeriodos', 'PeriodosController@getPeriodos')->name('getPeriodos');

    //Controlador Personas
    Route::get('getPersona', 'PersonasController@getPersona')->name('getPersona');
    Route::post('crearPersona', 'PersonasController@crearPersona')->name('crearPersona');
    Route::post('savePersona', 'PersonasController@savePersona')->name('savePersona');
    Route::get('getPersonas', 'PersonasController@getPersonas')->name('getPersonas');
    Route::post('updatePersona', 'PersonasController@updatePersona')->name('updatePersona');
    Route::get('exportPersonas', 'PersonasController@exportPersonas')->name('exportPersonas');
    Route::post('importPersonas', 'PersonasController@importPersonas')->name('importPersonas');
    Route::get('descargarFormato', 'PersonasController@descargarFormato')->name('descargarFormato');

    //Controlador Computadores
    Route::get('getComputadorlibre', 'ComputadoresController@getComputadorlibre')->name('getComputadorlibre');
    Route::get('getCompu', 'ComputadoresController@getCompu')->name('getCompu');
    Route::post('saveCompu', 'ComputadoresController@saveCompu')->name('saveCompu');
    Route::put('updateCompu', 'ComputadoresController@updateCompu')->name('updateCompu');

    //Controlador Prestamos
    Route::get('getPrestamos', 'PrestamosController@getPrestamos')->name('getPrestamos');
    Route::post('crearPrestamo', 'PrestamosController@crearPrestamo')->name('crearPrestamo');
    Route::post('finalizarPrestamo', 'PrestamosController@finalizarPrestamo')->name('finalizarPrestamo');
    Route::post('reportarObservacion', 'PrestamosController@reportarObservacion')->name('reportarObservacion');

    //Controlador Sedes
    Route::get('getSedes', 'SedesController@getSedes')->name('getSedes');

    //Controlador de Escritorio
    Route::get('countIngresos', 'EscritorioController@countIngresos')->name('countIngresos');
    Route::get('countComputadores', 'EscritorioController@countComputadores')->name('countComputadores');
    Route::get('countPrestamos', 'EscritorioController@countPrestamos')->name('countPrestamos');
    Route::get('countUsers', 'EscritorioController@countUsers')->name('countUsers');
    Route::get('getIngresoTipoPersona', 'EscritorioController@getIngresoTipoPersona')->name('getIngresoTipoPersona');
    Route::get('getIngresosMes', 'EscritorioController@getIngresosMes')->name('getIngresosMes');

    //Controlador de Roles
    Route::get('getRoles', 'RolesController@getRoles')->name('getRoles');

    //Controlador Universidad
    Route::get('getUniversidad', 'UniversidadesController@getUniversidad')->name('getUniversidad');
    Route::post('updateUniversidad', 'UniversidadesController@updateUniversidad')->name('updateUniversidad');
    Route::post('updateImagen', 'UniversidadesController@updateImagen')->name('updateImagen');

    //Controlador de Reportes
    Route::get('exportAvanzado', 'ReportesController@exportAvanzado')->name('exportAvanzado');
});
