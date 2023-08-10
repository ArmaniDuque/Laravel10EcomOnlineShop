<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\TempImagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => 'admin.guest'], function () {

        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
        // Route::resource("/authenticate", AdminLoginController::class);


    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');
        //    Category Routes List Blade 
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        //    Category Routes Create Blade 
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        //    Category Routes save in Category Controller 
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        //    Category Routes edit Blade 
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        //    Category Routes edit Blade 
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        //    Category Routes Delete Blade 
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');


        // temp-images.create
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');


        Route::get('/getSlug', function (Request $request) {
            $slug = '';
            if (!empty($request->title)) {
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);

        })->name('getSlug');

    });



});