<?php

use App\Http\Controllers\ApproveController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\Carset1Controller;
use App\Http\Controllers\CarsetController;
use App\Http\Controllers\ChangecarController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DriverdontactiveController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManagecarController;
use App\Http\Controllers\ManagedriverController;
use App\Http\Controllers\RecordRequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportdriverController;
use App\Http\Controllers\ReportuserController;
use App\Http\Controllers\ReturncarController;
use App\Http\Controllers\TypecarController;
use App\Http\Controllers\UserDontActiveController;
use App\Http\Controllers\UserlistController;
use GuzzleHttp\Middleware;
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

//ลืมรหัสผ่าน
Route::get('/send', [HomeController::class, "sendnotification"]);
Route::put('/forgotpassword', [LoginController::class, 'resetpassword'])->name('login.resetpassword');
Route::get('/report1', [ReportController::class, 'search'])->name('report1.search');
Route::get('/reportpdf', [ReportController::class, 'exportpdf']);
Route::get('/reportdetails/{id}', [ReportController::class, 'exportpdfdetails'])->name('reportdetails.exportpdfdetails');

Route::get('/reportuser1', [ReportuserController::class, 'search'])->name('reportuser1.search');
Route::get('/reportdriver1', [ReportdriverController::class, 'search'])->name('reportdriver1.search');
Route::get('/carlist1', [CarController::class, 'search'])->name('carlist1.search');
Route::get('/userlist1', [UserlistController::class, 'search'])->name('userlist1.search');

Route::get('/reportpdfuser', [ReportuserController::class, 'exportpdfuser']);
Route::get('/reportpdfdriver', [ReportdriverController::class, 'exportpdfdriver']);

Route::get('/view-image', [ReturncarController::class, 'viewImage'])->name('images.view');
Route::resource('/userDontactive', UserDontActiveController::class);
Route::resource('/driverdontactive', DriverdontactiveController::class);

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('admin.menucar.editcar');
});
Route::get('/forgetpassword', function () {
    return view('auth.forgetpassword');
});
//เมนูหลัก
Route::resource('/recordRequest', RecordRequestController::class)->middleware('checkLogin');
Route::resource('/returncar', ReturncarController::class);

Route::get('/userlist/{id}/editprofile', [UserlistController::class, 'editprofile'])->name('userlist.editprofile')->middleware('checkLogin');
Route::put('/userlist/{id}/updateprofile', [UserlistController::class, 'updateprofile'])->name('userlist.updateprofile')->middleware('checkLogin');
Route::put('/userlist/{id}/inactive', [UserlistController::class, 'inactive'])->name('userlist.inactive')->middleware('checkLogin');

Route::put('/driver/{id}/inactive', [DriverController::class, 'inactive'])->name('driver.inactive')->middleware('checkLogin');

Route::put('/carlist/{id}/inactive', [CarController::class, 'inactive'])->name('carlist.inactive')->middleware('checkLogin');

///////////////////

// เมนู ตั้งค่ารถยนต์
Route::group(['middleware' => ['checkLogin', 'checkPermission']], function () {
    Route::resource('/carset1', Carset1Controller::class);
    Route::resource('/carset', CarsetController::class);
    Route::resource('/approve', ApproveController::class);
    Route::resource('/addcolor', ColorController::class);
    Route::resource('/brand', BrandController::class);
    Route::get('/addcar', [CarController::class, 'addcar']);
    Route::get('findModel', [CarController::class, 'findModel']);
    Route::resource('/driver', DriverController::class);
    Route::resource('/typecar', TypecarController::class);
    Route::resource('/carlist', CarController::class);
    Route::resource('/model', CarModelController::class);
    Route::resource('/department', DepartmentController::class);
    Route::resource('/userlist', UserlistController::class);
    Route::resource('/report', ReportController::class);
    Route::resource('/reportuser', ReportuserController::class);
    Route::resource('/reportdriver', ReportdriverController::class);
});

////////////////////////////////////////////////////
// จัดรถยนต์ และ จัดพนักงาน
Route::get('/managedriver/{id}', [CarsetController::class, 'editdriver'])->name('carset.editdriver');
Route::put('/managecar/car/{carid}/request/{requestid}', [ManagecarController::class, 'updatetest'])->name('managecar.updatetest');
Route::put('/changecar/car/{carid}/request/{requestid}', [ChangecarController::class, 'changecar'])->name('changecar.changecar');
Route::put('/managedriver/driver/{driverid}/request/{requestid}', [ManagedriverController::class, 'updatedriver'])->name('managedriver.updatedriver');

//เมนู ตั้งค่าผู้ใช้
Route::put('/{id}', [HomeController::class, 'updatepassword'])->name('home.updatepassword')->middleware('checkLogin');

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    //* Home Routes
    Route::get('/', 'HomeController@index')->name('home.index')->middleware('checkLogin');

    Route::group(['middleware' => ['guest']], function () {
        // * Register Routes
        Route::get('/register', 'RegisterController@show')->name('register.show')->middleware('checkLogin', 'checkPermission');
        Route::get('/edituser', 'RegisterController@show')->name('register.show')->middleware('checkLogin', 'checkPermission');
        Route::post('/register', 'RegisterController@register')->name('register.perform');
        //* Login Routes
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
    });
    Route::group(['middleware' => ['auth']], function () {
        // Logout Routes
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
    ///////////////////

});
