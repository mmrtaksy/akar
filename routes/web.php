<?php

use App\Helpers\Helper;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PanelMenuController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
 
use App\Http\Controllers\SeoController;
use App\Http\Controllers\SitemapController;

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

Route::group(['prefix' => 'xadmin'], function () {



    Route::group(['middleware' => ['guest']], function () {

        Route::post('/login', [AdminController::class, 'loginPost'])->name('xloginPost');
        Route::get('/login', [AdminController::class, 'loginGet'])->name('xloginGet');

    });



    Route::group(['middleware' => ['authadmin']], function () {
        
                
                
        Route::middleware(['authadminapi'])->group(function () {
            Route::post('/delete-image', [ApiController::class, 'serviceDeleteImage'])->name('serviceDeleteImage');
            Route::post('/set-cover', [ApiController::class, 'serviceSetCoverImage'])->name('serviceSetCoverImage');
            Route::post('/services/set-sort', [ApiController::class, 'serviceSetSort'])->name('serviceSetSort');
            Route::post('/getimages', [ApiController::class, 'getImages'])->name('getImages');
            Route::post('/upload-images', [ApiController::class, 'uploadImages'])->name('uploadImages');
            Route::post('/transferImages', [ApiController::class, 'transferImages'])->name('transferImages');
            Route::post('/transferMetaRoute', [ApiController::class, 'transferMetaRoute'])->name('transferMetaRoute');
        });
        



        Route::get('/', [AdminController::class, 'index'])->name('home');

        Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/location/{location}', [AdminController::class, 'location'])->name('location');


        /* ############## USER ROUTES ############# */
        Route::group(['prefix' => 'user'], function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/list', 'userList')->name('userList');
                Route::get('/create', 'userCreateGet')->name('userCreateGet');
                Route::post('/create', 'userCreatePost')->name('userCreatePost');
                Route::get('/update/{id}', 'userUpdateGet')->name('userUpdateGet');
                Route::get('/update/password/{id}', 'userUpdatePasswordGet')->name('userUpdatePasswordGet');
                Route::post('/update/password', 'userPasswordUpdatePost')->name('userPasswordUpdatePost');
                Route::post('/update', 'userUpdatePost')->name('userUpdatePost');
                Route::get('/delete/{id}', 'userDelete')->name('userDelete');
                Route::get('/loginasuser/{id}', 'loginAsUser')->name('loginAsUser');
            });
        });
        /* ############## USER ROUTES ############# */

        /* ############## USER TYPE ROUTES ############# */
        Route::group(['prefix' => 'user-type'], function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/list', 'usertypeList')->name('usertypeList');
                Route::get('/create', 'usertypeCreateGet')->name('usertypeCreateGet');
                Route::post('/create', 'usertypeCreatePost')->name('usertypeCreatePost');
                Route::get('/update/{id}', 'usertypeUpdateGet')->name('usertypeUpdateGet');
                Route::post('/update', 'usertypeUpdatePost')->name('usertypeUpdatePost');
                Route::get('/delete/{id}', 'usertypeDelete')->name('usertypeDelete');
            });
        });
        /* ############## USER ROUTES ############# */

        /* ############## BLOG ROUTES ############# */
        Route::group(['prefix' => 'blog'], function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/list/{listlang?}', 'blogList')->name('blogList');
                Route::get('/create', 'blogCreateGet')->name('blogCreateGet');
                Route::post('/create', 'blogCreatePost')->name('blogCreatePost');
                Route::get('/update/{id}/{lang}', 'blogUpdateGet')->name('blogUpdateGet');
                Route::post('/update', 'blogUpdatePost')->name('blogUpdatePost');
                Route::get('/delete/{id}', 'blogDelete')->name('blogDelete');
            });
        });
        /* ############## BLOG ROUTES ############# */

        /* ############## BLOG TYPE ROUTES ############# */
        Route::group(['prefix' => 'blog-type'], function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/list/{listlang?}', 'blogtypeList')->name('blogtypeList');
                Route::get('/create', 'blogtypeCreateGet')->name('blogtypeCreateGet');
                Route::post('/create', 'blogtypeCreatePost')->name('blogtypeCreatePost');
                Route::get('/update/{id}/{lang}', 'blogtypeUpdateGet')->name('blogtypeUpdateGet');
                Route::post('/update', 'blogtypeUpdatePost')->name('blogtypeUpdatePost');
                Route::get('/delete/{id}', 'blogtypeDelete')->name('blogtypeDelete');
            });
        });
        /* ############## BLOG TYPE ROUTES ############# */

        /* ############## SERVICES ROUTES ############# */
        Route::group(['prefix' => 'models'], function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/list', 'servicesList')->name('servicesList');
                Route::get('/create', 'servicesCreateGet')->name('servicesCreateGet');
                Route::post('/create', 'servicesCreatePost')->name('servicesCreatePost');
                Route::get('/update', 'servicesUpdateGet')->name('servicesUpdateGet');
                Route::post('/update', 'servicesUpdatePost')->name('servicesUpdatePost');
                Route::get('/delete', 'servicesDelete')->name('servicesDelete');
                Route::get('/sort', 'servicesSortGet')->name('servicesSortGet');
                Route::get('/deleteAll', 'servicesDeleteAll')->name('servicesDeleteAll');


            });
        });
        /* ############## SERVICES ROUTES ############# */



    

        /* ############## LANGUAGES ROUTES ############# */
        Route::group(['prefix' => 'languages'], function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/list/{listlang?}', 'languagesList')->name('languagesList');
                Route::get('/create', 'languagesCreateGet')->name('languagesCreateGet');
                Route::post('/create', 'languagesCreatePost')->name('languagesCreatePost');
                Route::get('/update/{id}', 'languagesUpdateGet')->name('languagesUpdateGet');
                Route::post('/update', 'languagesUpdatePost')->name('languagesUpdatePost');
                Route::get('/delete/{id}', 'languagesDelete')->name('languagesDelete');
            });
        });
        /* ############## LANGUAGES ROUTES ############# */



        /* ############## SETTINGS ############# */
        Route::group(['prefix' => 'settings'], function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/', 'settingsIndex')->name('settingsIndex');
                Route::get('/create', 'settingsCreateGet')->name('settingsCreateGet');
                Route::post('/update', 'settingsUpdatePost')->name('settingsUpdatePost');
                Route::post('/set', 'settingsUpdateSet')->name('settingsUpdateSet');
                Route::get('/update/{id}', 'settingsUpdateGet')->name('settingsUpdateGet');
                Route::get('/delete/{id}', 'settingsDelete')->name('settingsDelete');
            });
        });
        /* ############## SETTINGS ############# */


        /* ############## LANGUAGE LEVEL ROUTES ############# */
        Route::group(['prefix' => 'languagelevel'], function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/list/{listlang?}', 'languagelevelList')->name('languagelevelList');
                Route::get('/create', 'languagelevelCreateGet')->name('languagelevelCreateGet');
                Route::post('/create', 'languagelevelCreatePost')->name('languagelevelCreatePost');
                Route::get('/update/{id}/{lang}', 'languagelevelUpdateGet')->name('languagelevelUpdateGet');
                Route::post('/update', 'languagelevelUpdatePost')->name('languagelevelUpdatePost');
                Route::get('/delete/{id}', 'languagelevelDelete')->name('languagelevelDelete');
            });
        });
        /* ############## LANGUAGE LEVEL ROUTES ############# */

        /* ############## EXPERIENCE LEVEL ROUTES ############# */
        Route::group(['prefix' => 'experiencelevel'], function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/list/{listlang?}', 'experiencelevelList')->name('experiencelevelList');
                Route::get('/create', 'experiencelevelCreateGet')->name('experiencelevelCreateGet');
                Route::post('/create', 'experiencelevelCreatePost')->name('experiencelevelCreatePost');
                Route::get('/update/{id}/{lang}', 'experiencelevelUpdateGet')->name('experiencelevelUpdateGet');
                Route::post('/update', 'experiencelevelUpdatePost')->name('experiencelevelUpdatePost');
                Route::get('/delete/{id}', 'experiencelevelDelete')->name('experiencelevelDelete');
            });
        });
        /* ############## EXPERIENCE LEVEL ROUTES ############# */



   

        /* ############## ORDER ############# */
        Route::group(['prefix' => 'order'], function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/list', 'orderList')->name('orderList');
                Route::get('/create', 'orderCreateGet')->name('orderCreateGet');
                Route::post('/create', 'orderCreatePost')->name('orderCreatePost');
                Route::get('/update/{id}', 'orderUpdateGet')->name('orderUpdateGet');
                Route::post('/update', 'orderUpdatePost')->name('orderUpdatePost');
                Route::get('/delete/{id}', 'orderDelete')->name('orderDelete');
            });
        });
        /* ############## ORDER ############# */



        /* ############## PARTNERS ############# */
        Route::group(['prefix' => 'partners'], function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/list', 'partnersList')->name('partnersList');
                Route::get('/create', 'partnersCreateGet')->name('partnersCreateGet');
                Route::post('/create', 'partnersCreatePost')->name('partnersCreatePost');
                Route::get('/update/{id}', 'partnersUpdateGet')->name('partnersUpdateGet');
                Route::post('/update', 'partnersUpdatePost')->name('partnersUpdatePost');
                Route::get('/delete/{id}', 'partnersDelete')->name('partnersDelete');
            });
        });
        /* ############## PARTNERS ############# */





        /* ############## MESSAGES ############# */
        Route::group(['prefix' => 'messages'], function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/list', 'messagesList')->name('messagesList');
                Route::get('/show/{id}', 'messagesShow')->name('messagesShow');
                Route::get('/delete/{id}', 'messagesDelete')->name('messagesDelete');
            });
        });
        /* ############## MESSAGES ############# */



        Route::group(['prefix' => 'seo'], function () {
            Route::controller(SeoController::class)->group(function () {
                Route::get('/', 'index')->name('seo_page');
                Route::post('/update', 'update')->name('seo_update');
            });
        });



        Route::group(['prefix' => 'menu'], function () {
            Route::controller(PanelMenuController::class)->group(function () {
                Route::get('/', 'index')->name('panel_menus.index');
                Route::post('/create', 'createNewPost')->name('panel_menus.store');
                Route::get('/create', 'create')->name('panel_menus.create');
                Route::get('/edit/{id}', 'edit')->name('panel_menus.edit');
                Route::get('/delete/{id}', 'delete')->name('panel_menus.delete');
                Route::post('/update', 'updatePost')->name('panel_menus.update');// web.php
                
            });
        });


        Route::group(['prefix' => 'translate'], function () {
            Route::controller(LanguageController::class)->group(function () {
                Route::get('/', 'index')->name('translate_index');
                Route::get('/group', 'createTranslateGet')->name('translate.create.get');
                Route::post('/group/translate/create', 'createTranslatePost')->name('translate.create.post');
                Route::post('/group/translate/update', 'updateTranslatePost')->name('translate.update.post');
                Route::get('/edit/{id}', 'editTranslateGet')->name('translate.edit');
                Route::get('/delete/{id}', 'deleteTranslation')->name('translate.delete');



            });
        });


    });
});


 
 

Route::controller(SitemapController::class)->group(function () {
    Route::get('/sitemap.xml', 'index')->name('sitemap');
    Route::get('/sitemap/hizmetler', 'servicesTr')->name('sitemap.servicestr');
    Route::get('/sitemap/services', 'servicesEn')->name('sitemap.servicesen');
    Route::get('/sitemap/blog-tr', 'blogsTr')->name('sitemap.blogstr');
    Route::get('/sitemap/blog-en', 'blogsEn')->name('sitemap.blogsen');
});


Route::get('/menu-children/{id}', [HomeController::class, 'getMenuChildren'])->name('menu.children');
Route::get('/menu-search', [HomeController::class, 'getMenuSearch'])->name('menu.search');

Route::get('/returntoadmin', [AdminController::class, 'returnToAdmin'])->name('returnToAdmin');

Route::get('image/{path}/{width}/{height}', [ImageController::class, 'getResizedImage']) ->where(['width' => '[0-9]+', 'height' => '[0-9]+']);

Route::prefix('{locale}')
    ->where(['locale' => 'tr|en'])
    ->middleware(['setlocale', 'trackVisitor'])
    ->group(function () {
        $locale = Helper::getLocaleFromUrl();
        require base_path("routes/{$locale}.php");
    });

Route::get('/', function () {
    return redirect(app()->getLocale());
});

Route::fallback(function () {
    App::abort(404);
});
