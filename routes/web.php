<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SectionController; 
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AuthController;

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

Route::middleware(['auth'])->get('/', function () {
    return view('welcome');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/home', [HomeController::class, 'index'])
// ->middleware(['auth', 'verified']) // Middleware list goes here, if needed
// ->name('home');

Route::get('/login', [AuthController::class, 'login'])->name(name:'login');
Route::post('/login', [AuthController::class, 'loginPost'])->name(name:'login.post');

Route::get('/register', [AuthController::class, 'register'])->name(name:'register');
Route::post('/register', [AuthController::class, 'registerPost']);
Route::get('/logout', [AuthController::class, 'logout'])->name(name:'logout');


Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
Route::get('/adddepartment', [DepartmentController::class, 'create'])->name('department.create');
Route::post('/department', [DepartmentController::class, 'store'])->name('department.store');
Route::get('/department/{department}/edit', [DepartmentController::class, 'edit'])->name('department.edit');
Route::patch('/department/{department}', [DepartmentController::class, 'update'])->name('department.update');
Route::delete('/department/{department}', [DepartmentController::class, 'destroy'])->name('department.delete');

Route::get('/section', [SectionController::class, 'index'])->name('section.index');
Route::get('/addsection', [SectionController::class, 'create'])->name('section.create');
Route::post('/section', [SectionController::class, 'store'])->name('section.store');
Route::get('/section/{section}/edit', [SectionController::class, 'edit'])->name('section.edit');
Route::patch('/section/{section}', [SectionController::class, 'update'])->name('section.update');
Route::delete('/section/{section}', [SectionController::class, 'destroy'])->name('section.delete');
Route::get('/sections/{department}', [SectionController::class, 'getSectionsByDepartment'])->name('sections.getSectionsByDepartment');

Route::get('/role', [RoleController::class, 'index'])->name('role.index');
Route::get('/addrole', [RoleController::class, 'create'])->name('role.create');
Route::post('/role', [RoleController::class, 'store'])->name('role.store');
Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
Route::patch('/role/{role}', [RoleController::class, 'update'])->name('role.update');
Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('role.delete');

Route::get('/designation', [DesignationController::class, 'index'])->name('designation.index');
Route::get('/add-designation', [DesignationController::class, 'create'])->name('designation.create');
Route::post('/designation', [DesignationController::class, 'store'])->name('designation.store');
Route::get('/designation/{designation}/edit', [DesignationController::class, 'edit'])->name('designation.edit');
Route::patch('/designation/{designation}', [DesignationController::class, 'update'])->name('designation.update');
Route::delete('/designation/{designation}', [DesignationController::class, 'destroy'])->name('designation.delete');


Route::get('/grade', [GradeController::class, 'index'])->name('grade.index');
Route::get('/add-grade', [GradeController::class, 'create'])->name('grade.create');
Route::post('/grade', [GradeController::class, 'store'])->name('grade.store');
Route::get('/grade/{grade}/edit', [GradeController::class, 'edit'])->name('grade.edit');
Route::patch('/grade/{grade}', [GradeController::class, 'update'])->name('grade.update');
Route::delete('/grade/{grade}', [GradeController::class, 'destroy'])->name('grade.delete');

//Add_User
Route::get('/create-user', [AdminController::class, 'createUser'])->name('users.create');
Route::post('/store-user', [AdminController::class, 'storeUser'])->name('users.store');


require __DIR__.'/auth.php';
