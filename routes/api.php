<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewPassWordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum', 'cors'])->group( function () {
    Route::post('logout',[AuthController::class, 'logout']);
    Route::get('/me',[AuthController::class, 'userProfile']);
    Route::post('change-password',[AuthController::class,'change_password']);

    //CRUD products
    Route::delete('product/delete/{id}',[ProductController::class,'delete']);
    Route::post('/product/create', [ProductController::class, 'store']);
    Route::put('/product/update/{id}', [ProductController::class, 'update']);
    Route::post('product/restore/{id}',[ProductController::class,'restore']);
    //CRUD user
    Route::get('allUsers',[UserController::class,'index']);
    Route::get('users/{id}',[UserController::class,'show']);
    Route::post('/user/create', [UserController::class, 'store']);
    Route::put('user/update/{id}',  [UserController::class, 'update']);
    Route::delete('user/delete/{id}',[UserController::class,'destroy']);
    Route::post('user/restore/{id}',[UserController::class,'restore']);
    Route::post('changePassword',[AuthController::class,'change_password']);

    //filter,sort,search user
    Route::get('users',[UserController::class,'getByCondition']);

    //Order
    Route::post("/orders", [OrderController::class, "store"]);
    Route::get("/orders/sendmail", [OrderController::class, "sendmail"]);


//    Route::get("orders/{id}", [OrderController::class, "getById"]);

    Route::put("/orders/update/{id}", [OrderController::class, "update"]);
    Route::delete('/orders/delete/{id}',[OrderController::class,'destroy']);
    Route::get('orders', [OrderController::class,'getByCondition']);



});
Route::get("orders/{id}", [OrderController::class, "getById"]);

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);




Route::get('products', [ProductController::class,'getByCondition']);

Route::get('getRecommendedPhones', [ProductController::class,'getRecommendedPhones']);
Route::get('getRecommendedLaptops', [ProductController::class,'getRecommendedLaptops']);
Route::get('getRecommendedTablets', [ProductController::class,'getRecommendedTablets']);
Route::get('getRecommendedAccessories', [ProductController::class,'getRecommendedAccessories']);

Route::get('products/{id}', [ProductController::class, 'show']);

Route::post('product/review/{id}', [ReviewController::class,'update']);
Route::get('product/list-review/{id}', [ProductController::class,'getListReviewByID']);

Route::post('forget-password', [NewPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::post('reset-password', [NewPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::get("/sendmail", [NewPasswordController::class, "sendmail"]);
Route::get('reset-password/{token}', [NewPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');

