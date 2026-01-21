<?php

use App\Http\Controllers\AccountController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
 

/*
|--------------------------------------------------------------------------
| Web TR Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/







Route::prefix('iletisim')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('contact');
    Route::post('/formcontact', [ContactController::class, 'formcontact'])->name('formcontact');
});



// Route::group(['middleware' => ['auth']], function () {
//     Route::controller(UserController::class)->group(function () {
//         Route::post('/upload-gallery', 'uploadGallery')->name('uploadGallery');
//         Route::post('/update', 'updatePost')->name('updatePost');
//         Route::get('/ayarlar', 'userSetting')->name('userSetting');
//         Route::get('/cikis', 'userLogout')->name('userLogout'); 
//     });
    
// });


// Route::group(['middleware' => ['guest']], function () {
//     Route::controller(UserController::class)->group(function () {
//         Route::get('/giris', 'loginGet')->name('loginGet');
//         Route::post('/login', 'loginPost')->name('loginPost');
//         Route::get('/kayit', 'registerGet')->name('registerGet');
//         Route::post('/register', 'registerPost')->name('registerPost');
//         Route::get('/reset-password', 'resetPasswordGet')->name('resetPasswordGet');
//         Route::post('/reset-password', 'resetPasswordPost')->name('resetPasswordPost');
//         Route::get('/password-reset/{token}/{email}', 'passwordResetGet')->name('passwordResetGet');
//         Route::post('/password-change', 'newPasswordPost')->name('newPasswordPost');
//         Route::post('/email-verify', 'verify')->name('emailVerify');
//     });
// });




/* PUBLIC ROUTES */



Route::controller(HomeController::class)->group(function () {
    Route::get('/hakkinda', 'about')->name('about');
    Route::get('/sss', 'faq')->name('faqs');
    // Route::get('/dokumanlar', 'files')->name('files');
});



    Route::get('/', [HomeController::class, 'index'])->name('homepage');
    Route::get('/sayfa/{slug}', [HomeController::class, 'pageShow'])->name('pageShow');
    
    
    
    Route::get('/projeler', [HomeController::class, 'projectAll'])->name('projects');
    Route::get('/projeler/{slug}', [HomeController::class, 'projectShow'])->name('projectShow');

    Route::get('/blog', [HomeController::class, 'blogAll'])->name('blogs'); 
    Route::get('/blog/{category}/{slug?}', [HomeController::class, 'blogShow'])->name('blogShow');


    Route::get('/menu', [HomeController::class, 'menuList'])->name('menuList');


    Route::get('/ekibimiz', [HomeController::class, 'teamAll'])->name('team');


    Route::get('/hizmetler', [HomeController::class, 'serviceAll'])->name('services');
    // Route::get('/hizmetler/{category}/{slug?}', [HomeController::class, 'serviceCatShow'])->name('serviceShow');

  
    Route::get('/{slug}', [HomeController::class, 'serviceShow'])->name('serviceShow');


    // Route::post('/account/package/take/checkout', [AccountController::class, 'callback'])->name('callback');
    // Route::get('/hesap/paketler/odeme/ok', [AccountController::class, 'userPackagePayResultGet'])->name('userPackagePayResultGet');
    
/* PUBLIC ROUTES */


Route::get('/menu-children/{id}', [HomeController::class, 'getMenuChildren'])->name('menu.children');
Route::get('/menu-search', [HomeController::class, 'getMenuSearch'])->name('menu.search');

Route::any('{catchall}', [HomeController::class, 'notfound'])->where('catchall', '.*');

Route::fallback(function () {
    App::abort(404);
});
