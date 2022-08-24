<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SupervisorsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\WasfaController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\chifController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\WasfaController as FrontWasfaCotnroller;
use App\Http\Controllers\Admin\RatingReseservationsController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\DashboradController;
use App\Http\Controllers\Admin\ChefController;
use  App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationUserController;
use App\Http\Controllers\RatingReservationUserController;
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

Route::get('statusUpdate', function () {


    if (auth()->user()->status == 1) {
        return redirect()->route('home');
    }

    return view('statusUpdate');
})->name('statusUpdate');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/admin', [DashboradController::class, 'index'])->middleware(['auth', 'verified', 'isAdmin'])->name('admin');
Route::get('/dashboard', [DashboradController::class, 'index'])->middleware(['auth', 'verified', 'isAdmin'])->name('admin');

Route::group(['prefix' => '/admin/', 'as' => 'admin.', 'middleware' => ['auth', 'verified', 'isAdmin']], function () {



    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'editprofile'])->name('profile.edit');



    Route::group(['prefix' => '/roles/', 'as' => 'roles.'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [RoleController::class, 'update'])->name('update');
        Route::post('/delete', [RoleController::class, 'destroy'])->name('delete');
    });
    Route::group([
        'prefix' => '/supervisors',
        'as' => 'supervisors.'
    ],  function () {
        Route::get('/', [SupervisorsController::class, 'index'])->name('index');
        Route::post('/store', [SupervisorsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SupervisorsController::class, 'edit'])->name('edit');
        Route::post('/update', [SupervisorsController::class, 'update'])->name('update');
        Route::post('/delete', [SupervisorsController::class, 'destroy'])->name('delete');
    });
    Route::group(['prefix' => '/chef', 'as' => 'chefs.'], function () {
        Route::get('/', [ChefController::class, 'index'])->name('index');
        Route::post('/store', [ChefController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ChefController::class, 'edit'])->name('edit');
        Route::post('/update', [ChefController::class, 'update'])->name('update');
        Route::post('/delete', [ChefController::class, 'destroy'])->name('delete');
    });
    //categories
    Route::group([
        'prefix' => '/categories',
        'as' => 'categories.'
    ],  function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('index');
        Route::post('/store', [CategoriesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoriesController::class, 'edit'])->name('edit');
        Route::post('/update', [CategoriesController::class, 'update'])->name('update');
        Route::post('/delete', [CategoriesController::class, 'destroy'])->name('delete');
    });

    Route::group([
        'prefix' => '/users',
        'as' => 'users.'
    ],  function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('edit');
        Route::post('/update', [UsersController::class, 'update'])->name('update');
        Route::post('/delete', [UsersController::class, 'destroy'])->name('delete');
    });
    //wasfas
    Route::group([
        'prefix' => '/wasfa',
        'as' => 'wasfas.'
    ],  function () {
        Route::get('/', [WasfaController::class, 'index'])->name('index');
        //طلبات المستخدمين
        Route::get('/users', [WasfaController::class, 'users'])->name('users');
        Route::get('/users/edit/{id}', [WasfaController::class, 'usersedit'])->name('users.edit');
        Route::post('/users/edit', [WasfaController::class, 'userseditpost'])->name('users.post');
        Route::get('/users/show/{id}', [WasfaController::class, 'usersshow'])->name('users.show');
        Route::post('/showstatus', [WasfaController::class, 'updateStatus'])->name('status.update');


        Route::post('/store', [WasfaController::class, 'store'])->name('store');
        Route::get('/show/{id}', [WasfaController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [WasfaController::class, 'edit'])->name('edit');
        Route::post('/update', [WasfaController::class, 'update'])->name('update');
        Route::post('/delete', [WasfaController::class, 'destroy'])->name('delete');
    });



    //rating Reseservations
    Route::group([
        'prefix' => '/ratingreservation',
        'as' => 'ratingreservation.'
    ],  function () {
        Route::get('/', [RatingReseservationsController::class, 'index'])->name('index');
        Route::get('/create', [RatingReseservationsController::class, 'create'])->name('create');
        Route::get('/rating/{id}', [RatingReseservationsController::class, 'rating'])->name('rating');
        Route::post('/store', [RatingReseservationsController::class, 'store'])->name('store');
        Route::get('/show/{id}', [RatingReseservationsController::class, 'show'])->name('show');
        Route::post('/delete', [RatingReseservationsController::class, 'destroy'])->name('delete');
    });


    //contact us
    Route::group([
        'prefix' => '/contactus',
        'as' => 'contactus.'
    ],  function () {
        Route::get('/', [ContactusController::class, 'index'])->name('index');
        Route::post('/delete', [ContactusController::class, 'delete'])->name('delete');
    });
    //خدمات
    Route::group([
        'prefix' => '/services',
        'as' => 'services.'
    ],  function () {
        Route::get('/', [ServicesController::class, 'index'])->name('index');
        Route::get('/subscribe/{id}', [ServicesController::class, 'subscribe'])->name('subscribe');
        Route::get('/subscribes', [ServicesController::class, 'subscribeChif'])->name('subscribechif');
        Route::post('/store', [ServicesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ServicesController::class, 'edit'])->name('edit');
        Route::post('/update', [ServicesController::class, 'update'])->name('update');
        Route::post('/delete', [ServicesController::class, 'destroy'])->name('delete');
        //اشتراك الطباخين
        //    Route::get('chif/subscribe', [ServiceController::class, 'chifSubscripe'])->name('chif.subscribe');
        //    Route::get('chif/create', [ServiceController::class, 'chifCreate'])->name('chif.create');
        //    Route::post('chif/store/{id}', [ServiceController::class, 'chifStore'])->name('chif.store');
    });
    //اعدادات الموقع
    Route::group([
        'prefix' => '/settings',
        'as' => 'settings.'
    ],  function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/', [SettingController::class, 'update'])->name('update');
        Route::get('/', [SettingController::class, 'index'])->name('index');
    });
});
Route::group(['middleware' => 'auth', 'as' => 'admin.', 'prefix' => '/admin/',], function () {
    // حجز المستخدمين   
    Route::group([
        'prefix' => '/reservation',
        'as' => 'reservation.'
    ],  function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [ReservationController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [ReservationController::class, 'edit'])->name('status');
        Route::post('/showstatus', [ReservationController::class, 'updateStatus'])->name('status.update');
        Route::post('/update', [ReservationController::class, 'update'])->name('update');
        Route::post('/delete', [ReservationController::class, 'destroy'])->name('destroy');
    });
});
Route::group(['middleware' => 'auth', 'as' => 'user.', 'prefix' => '/user/',], function () {
    // حجز المستخدمين   
    Route::group([
        'prefix' => '/reservation',
        'as' => 'reservation.'
    ],  function () {
        Route::get('/', [ReservationUserController::class, 'index'])->name('index');
        Route::get('/create/{id}', [ReservationUserController::class, 'create'])->name('create');
        Route::post('/store', [ReservationUserController::class, 'store'])->name('store');

        Route::get('/edit/{id}', [ReservationUserController::class, 'edit'])->name('edit');
        Route::post('/reservationupdate', [ReservationUserController::class, 'update'])->name('update');
        Route::post('/delete', [ReservationUserController::class, 'destroy'])->name('delete');
    });
});

Route::group(['middleware' => 'auth', 'as' => 'user.', 'prefix' => '/user/',], function () {
    // حجز المستخدمين   
    Route::group([
        'prefix' => '/ratingReservation',
        'as' => 'ratingReservation.'
    ],  function () {
        Route::post('/create', [RatingReservationUserController::class, 'create'])->name('create');
        Route::post('/store', [RatingReservationUserController::class, 'store'])->name('update');
    });

    //rating wasfa
    Route::group([
        'prefix' => '/rating',
        'as' => 'rating.'
    ],  function () {
        Route::get('/', [RatingController::class, 'index'])->name('index');
        Route::post('/create', [RatingController::class, 'create'])->name('create');
        Route::post('/rating', [RatingController::class, 'rating'])->name('rating');
        Route::post('/store', [RatingController::class, 'store'])->name('store');
        Route::get('/show/{id}', [RatingController::class, 'show'])->name('show');
        Route::post('/delete', [RatingController::class, 'destroy'])->name('delete');
    });


    //rating Reseservations
    Route::group([
        'prefix' => '/payment',
        'as' => 'payment.'
    ],  function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::post('/create/reservation', [PaymentController::class, 'createReservation'])->name('create.reservation');
        Route::post('/create/wasfa', [PaymentController::class, 'createwasfa'])->name('create.wasfa');
        Route::post('/store', [PaymentController::class, 'store'])->name('store');
        Route::post('/delete', [PaymentController::class, 'destroy'])->name('delete');
    });
});

Route::get('chifs', [chifController::class, 'index'])->name('chif.index');

Route::group(['as' => 'user.wasfas.', 'prefix' => '/wasfas/'],  function () {
    Route::get('wasfas', [FrontWasfaCotnroller::class, 'index'])->name('index');
    Route::get('wasfasuser', [FrontWasfaCotnroller::class, 'userWsafas'])->name('user');
    Route::get('wasfas/show/{id}', [FrontWasfaCotnroller::class, 'show'])->name('show');
    Route::post('wasfas/show', [FrontWasfaCotnroller::class, 'store'])->middleware('auth', 'verified')->name('store');
});
Route::get('category/{id}', [FrontWasfaCotnroller::class, 'category'])->name('wasfa.category.index');
Route::post('contactus', [ContactusController::class, 'store'])->name('contactus.store');
require __DIR__ . '/auth.php';
