<?php

use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\MaterialProductsController;
use App\Http\Controllers\Api\ProductMaterialsController;
use App\Http\Controllers\Api\MaterialWarehousesController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('materials', MaterialController::class);

        // Material Warehouses
        Route::get('/materials/{material}/warehouses', [
            MaterialWarehousesController::class,
            'index',
        ])->name('materials.warehouses.index');
        Route::post('/materials/{material}/warehouses', [
            MaterialWarehousesController::class,
            'store',
        ])->name('materials.warehouses.store');

        // Material Products
        Route::get('/materials/{material}/products', [
            MaterialProductsController::class,
            'index',
        ])->name('materials.products.index');
        Route::post('/materials/{material}/products/{product}', [
            MaterialProductsController::class,
            'store',
        ])->name('materials.products.store');
        Route::delete('/materials/{material}/products/{product}', [
            MaterialProductsController::class,
            'destroy',
        ])->name('materials.products.destroy');

        Route::apiResource('products', ProductController::class);

        // Product Materials
        Route::get('/products/{product}/materials', [
            ProductMaterialsController::class,
            'index',
        ])->name('products.materials.index');
        Route::post('/products/{product}/materials/{material}', [
            ProductMaterialsController::class,
            'store',
        ])->name('products.materials.store');
        Route::delete('/products/{product}/materials/{material}', [
            ProductMaterialsController::class,
            'destroy',
        ])->name('products.materials.destroy');

        Route::apiResource('users', UserController::class);

        Route::apiResource('warehouses', WarehouseController::class);
        Route::get("/order", [OrderController::class, 'examination']);
    });
