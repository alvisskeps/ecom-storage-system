<?php

use App\Http\Controllers\Api\ProductsController;
use Illuminate\Support\Facades\Route;

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

Route::get('products', [ProductsController::class, 'getAllProducts']);
Route::get('products/{id}', [ProductsController::class, 'getProduct']);
Route::get('products/{id}/amount', [ProductsController::class, 'getProductAmount']);
Route::post('products', [ProductsController::class, 'createProduct']);
Route::put('products/{id}', [ProductsController::class, 'updateProduct']);
Route::delete('products/{id}', [ProductsController::class, 'deleteProduct']);
