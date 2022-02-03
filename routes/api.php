<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\CompanyPackageController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::put('company/register', [CompanyController::class, 'register'])->name('company.register');
//Route::get('api/company/packages/receive-payments', [CompanyPackageController::class, 'receivePayments'])->name('company.receivePayments');

Route::group([
    'middleware' => ['api.token']
], function(){
    Route::get('company/list', [CompanyController::class, 'list'])->name('company.list');
    Route::get('packages/list', [PackageController::class, 'list'])->name('package.list');
    Route::put('company/packages/add', [CompanyPackageController::class, 'add'])->name('company.package.add');
    Route::get('company/packages/list', [CompanyPackageController::class, 'list'])->name('company.package.list');
});

