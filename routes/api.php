<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
// Route::get('/products', [ProductController::class, 'index']);
//

// Public routes
Route::resource('products', ProductController::class);

// Protected routes
Route::middleware('auth:sanctum')->group(function() {
  Route::post('/products', [ProductController::class, 'store']);
  Route::put('/products/{id}', [ProductController::class, 'update']);
  Route::get('/products/search/{name}', [ProductController::class, 'search']);
});

Route::middleware('auth:sanctum')->get('/user', function(Request $request) {
  return $request->user();
});
