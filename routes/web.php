<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

//dashboard routes
Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard')->middleware('auth');
//authentication routes
Route::view('login','Auth.login');
Route::post('login',[AuthController::class,'login'])->name('login');
Route::get('logout',[AuthController::class,'logout'])->name('logout');
Route::get('loginAsOtherUser',[AuthController::class,'loginAsOtherUser'])->name('loginAsOtherUser');
Route::group(['middleware' => ['auth']], function () {
//permissions route
Route::get('permission',[PermissionController::class,'index'])->name('permission');
Route::get('addpermission',[PermissionController::class,'createPermission'])->name('createPermission');
Route::post('storePermission',[PermissionController::class,'storePermission'])->name('storePermission');
Route::get('editPermission/{id}',[PermissionController::class,'editPermission'])->name('editPermission');
Route::post('updatePermission',[PermissionController::class,'updatePermission'])->name('updatePermission');

//roles route
Route::get('role',[RoleController::class,'index'])->name('role');
Route::get('addrole',[RoleController::class,'createRole'])->name('addrole');
Route::post('storeRole',[RoleController::class,'storeRole'])->name('storeRole');
Route::get('editRole/{id}',[RoleController::class,'editRole'])->name('editRole');
Route::post('updateRole',[RoleController::class,'updateRole'])->name('updateRole');

//users route
Route::get('users',[UserController::class,'index'])->name('users');
Route::get('createUser',[UserController::class,'createUser'])->name('createUser');
Route::post('storeUser',[UserController::class,'storeUser'])->name('storeUser');
Route::get('editUser/{id}',[UserController::class,'editUser'])->name('editUser');
Route::post('updateUser',[UserController::class,'updateUser'])->name('updateUser');

//profile
Route::get('profile',[ProfileController::class,'index'])->name('profile');
Route::post('updateProfile',[ProfileController::class,'updateProfile'])->name('updateProfile');
Route::post('changeSettings',[ProfileController::class,'changeSettings'])->name('changeSettings');
Route::post('changePassword',[ProfileController::class,'changePassword'])->name('changePassword');

//task route
Route::get('task',[TaskController::class,'index'])->name('task');
Route::get('addtask',[TaskController::class,'createTask'])->name('addtask');
Route::post('storeTask',[TaskController::class,'storeTask'])->name('storeTask');
Route::get('editTask/{id}',[TaskController::class,'editTask'])->name('editTask');
Route::post('updateTask',[TaskController::class,'updateTask'])->name('updateTask');
});
