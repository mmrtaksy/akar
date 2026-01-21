<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;

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




 


Route::prefix('contact')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('contact');
    Route::post('/formcontact', [ContactController::class, 'formcontact'])->name('formcontact');
});

 


 

// Route::group(['middleware' => ['guest']], function () {
//     Route::controller(UserController::class)->group(function () {
//         Route::get('/login', 'loginGet')->name('loginGet');
//         Route::post('/login', 'loginPost')->name('loginPost');
//         Route::get('/register', 'registerGet')->name('registerGet');
//         Route::post('/register', 'registerPost')->name('registerPost');
//         Route::get('/reset-password', 'resetPasswordGet')->name('resetPasswordGet');
//         Route::post('/reset-password', 'resetPasswordPost')->name('resetPasswordPost');
//         Route::get('/password-reset/{token}/{email}', 'passwordResetGet')->name('passwordResetGet');
//         Route::post('/password-change', 'newPasswordPost')->name('newPasswordPost');
//     });
// });




/* PUBLIC ROUTES */



Route::controller(HomeController::class)->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/faq', 'faq')->name('faqs');
    // Route::get('/documents', 'files')->name('files');
});


    Route::get('/', [HomeController::class, 'index'])->name('homepage');
    Route::get('/page/{slug}', [HomeController::class, 'pageShow'])->name('pageShow');
    
    Route::get('/projects', [HomeController::class, 'projectAll'])->name('projects');
    Route::get('/projects/{slug}', [HomeController::class, 'projectShow'])->name('projectShow');

 
    Route::get('/blog', [HomeController::class, 'blogAll'])->name('blogs'); 
    Route::get('/blog/{category}/{slug?}', [HomeController::class, 'blogShow'])->name('blogShow');

    Route::get('/menu', [HomeController::class, 'menuList'])->name('menuList');

    

    Route::get('/team', [HomeController::class, 'teamAll'])->name('team');

    Route::get('/services', [HomeController::class, 'serviceAll'])->name('services');
   // Route::get('/services/{category}/{slug?}', [HomeController::class, 'serviceCatShow'])->name('serviceShow');

   Route::get('/{slug}', [HomeController::class, 'serviceShow'])->name('serviceShow');
    
    // Route::get('/ilan-ara', [HomeController::class, 'jobsearch'])->name('jobsearch');

    // Route::post('/account/package/take/checkout', [AccountController::class, 'callback'])->name('callback');
    // Route::get('/hesap/paketler/odeme/ok', [AccountController::class, 'userPackagePayResultGet'])->name('userPackagePayResultGet');
    
/* PUBLIC ROUTES */



Route::any('{catchall}', [HomeController::class, 'notfound'])->where('catchall', '.*');

Route::fallback(function () {
    App::abort(404);
});
