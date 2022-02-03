<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyPackageController;

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

//Route::put('api/company/register', [CompanyController::class, 'register'])->name('company.register');
Route::get('api/company/packages/receive-payments', [CompanyPackageController::class, 'receivePayments'])->name('company.receivePayments');

/*Route::group([
    'middleware' => ['api.token']
], function(){
    Route::get('api/company/list', [CompanyController::class, 'list'])->name('company.list');
    Route::get('api/packages/list', [PackageController::class, 'list'])->name('package.list');
    Route::put('api/company/packages/add', [CompanyPackageController::class, 'add'])->name('company.package.add');
    Route::get('api/company/packages/list', [CompanyPackageController::class, 'list'])->name('company.package.list');
});*/
