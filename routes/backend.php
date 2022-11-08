<?php
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::group(['as' => 'backend.', 'prefix' => 'backend'],function () {
    //登入
    Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
        Route::get('/login', [Controllers\Backend\LoginController::class, 'index'])->name('login')->middleware(['guest:'.config('fortify.guard')]);
        $limiter = config('fortify.limiters.login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest:'.config('fortify.guard'),
                $limiter ? 'throttle:'.$limiter : null,
            ]));
    });

    Route::group(['middleware' => ['auth:admin', 'user.status', 'verified']],function () {
        Route::get('/dashboard', [Controllers\Backend\DashboardController::class, 'index'])->name('dashboard');
        //修改密碼
        Route::resource('/edit_password', Controllers\Backend\AuthController::class);

        //操作紀錄
        Route::resource('/audits', Controllers\Backend\AuditController::class);

        //部門
        Route::resource('/departments', Controllers\Backend\DepartmentController::class);
        //人員
        Route::resource('/staff', Controllers\Backend\StaffController::class);

        Route::group(['prefix' => 'test'],function () {
            Route::resource('/template', Controllers\Backend\TemplateController::class);
            Route::put('/template/status/{template}', [Controllers\Backend\TemplateController::class, 'status'])->name('template.status');
        });
        
        //新增管理員
        Route::resource('/users', Controllers\Backend\UserController::class);
        Route::put('/users/status/{user}', [Controllers\Backend\UserController::class, 'status'])->name('users.status');
        // //角色
        // Route::resource('/roles', Controllers\Backend\RoleController::class);            

        Route::post('/upload', [Controllers\Backend\UploadController::class, 'store'])->name('upload.store');
        Route::delete('/upload', [Controllers\Backend\UploadController::class, 'destroy'])->name('upload.destroy');
    });
});
